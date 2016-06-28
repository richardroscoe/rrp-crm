<?php

class CherubController extends Controller
{
	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionView($id)
	{
		// Get the Cherubs record
		$cherub = Cherub::model()->findByPk($id);
		
		$cherub->loadLeads();
		
		$active =  new CActiveDataProvider('Address');
		$active->setData($cherub->getActiveLeads());
//		echo "<p>Acive leads $active->itemCount</p>";
		
		$warm =  new CActiveDataProvider('Address');
		$warm->setData($cherub->getWarmLeads());
//		echo "<p>Warm leads $warm->itemCount</p>";
		
//		return(0);
		
		$this->render('view', array('cherub'=>$cherub, 'CDPActive'=>$active, 'CDPWarm'=>$warm));
	}
	
	//
	// Export a CSV representation of the Warm leads
	//
	public function actionExportWarm($id)
	{
		// Get the Cherubs record
		$cherub = Cherub::model()->findByPk($id);
		
		$cherub->loadLeads();
		$addresses = new CActiveDataProvider('Address');
		$addresses->setData($cherub->getWarmLeads());
		
		$this->render('exportWarm', array('addresses'=>$addresses));
	}
	
	// Export Letter1 contacts
	public function actionExportLetter1()
	{
		$letter1 = Cherub::model()->leadsWMGLetter1();
		$letter1Addr = new CActiveDataProvider('Address');
		$letter1Addr->setData($letter1);
		
		Cherub::model()->setExportDate($letter1);
		
		$this->render('exportWarm', array('title'=>'letter1', 'addresses'=>$letter1Addr));
		
	}	
	
	// Export Letter2 contacts
	public function actionExportLetter2()
	{		
		$letter2 = Cherub::model()->leadsWMGLetter2();
		$letter2Addr = new CActiveDataProvider('Address');
		$letter2Addr->setData($letter2);
		
		Cherub::model()->setExportDate($letter2);
		$this->render('exportWarm', array('title'=>'letter2', 'addresses'=>$letter2Addr));
		
	}
	
	
	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
		// Show the cherubs data sets
		$criteria=new CDbCriteria;
		$criteria->order = 'date_upload_data DESC';
		
		$cherubs = new CActiveDataProvider('Cherub', array('criteria' => $criteria));
		
		$this->render('index', array('cherubs'=>$cherubs));
	}

	// WMG Index page
	//
	// We display the current active leads (those with due appointments???)
	// And those that are in the target age range - that don't yet have an appointment and that haven't been contacted - these can be exported.
	//
	public function actionWmgIndex()
	{
		/*
		// Show the cherubs data sets
		$criteria=new CDbCriteria;
		$criteria->order = 'date_upload_data DESC';
		
		$wmg = new CActiveDataProvider('Cherub', array('criteria' => $criteria));
		*/
		$booked = Cherub::model()->leadsWMGBooked();
		$bookedAddr = new CActiveDataProvider('Address');
		$bookedAddr->setData($booked);

		$letter1 = Cherub::model()->leadsWMGLetter1();
		$letter1Addr = new CActiveDataProvider('Address');
		$letter1Addr->setData($letter1);
		
		$letter2 = Cherub::model()->leadsWMGLetter2();
		$letter2Addr = new CActiveDataProvider('Address');
		$letter2Addr->setData($letter2);
		
		$young = Cherub::model()->leadsWMGYoung();
		$youngAddr = new CActiveDataProvider('Address');
		$youngAddr->setData($young);
			
		$this->render('wmgIndex', array('booked'=>$bookedAddr, 'letter1'=>$letter1Addr, 'letter2'=>$letter2Addr, 'young'=>$youngAddr,));
	}

	public function actionUpdate()
	{
		$this->render('update');
	}
	public function actionImportWMG()
	{
		if (isset($_POST['cancel'])) {
			
			$this->redirect(array('cherub/index'));
			
		} elseif (isset($_POST['preview'])) {
//			echo "<p>Preview</p>";
			// We get in here after the user has submitted the form
			// that collected the filename and date
			$model = new CMSourceForm;
			$form = new CForm('application.views.cherub.CMSourceForm', $model);
			
			if ($form->submitted('preview') && $form->validate()){
				$model = $form->model;
				
				// Get the file
	
				$model->fileinfo = CUploadedFile::getInstance($model, 'filename');
				
				$items = ImportCSV::getItemObjects($model->fileinfo, 'CMPreview');
					
				// Check items against what is already in our dbase.
				// Look for duplicate names (could be duplicate data or another baby
				foreach ($items as $i=>$item) {
//echo "<pre>";print_r($item);echo"</pre>";
					$dup = Contact::getContactByName($item['firstname'], $item['surname']);
					$items[$i]['duplicate'] = $dup;
				}			
				
				$this->render('CMPreview',array('items'=>$items, 'source'=>$model));
			} else {
				echo "<p>Form Didin't validate</p>";
				$this->render('CMSource', array('form'=>$form));
			}
			
		} elseif (isset($_POST['import'])) {
			
//echo "<pre>";print_r($_POST);echo"</pre>";	

			$cherub = new Cherub;
			$cherub->date_upload_data = $_POST['date_upload_data'];
			$cherub->lead_type = $_POST['lead_type'];
			$cherub->save(false);
			
			// We get in here when the user has previewed the information and now wants
			// to save the records in the model
			
			foreach ($_POST['CMPreview'] as $i => $item) {

				if ($item['import'] != 1) {
					continue;
				}
				
				if ($item['update'] == 1) {
					// Update the address and lead_type, lead_date
					$contact = Contact::model()->findByPk($item['duplicate']);
					
					$address = Address::model()->findByPk($contact->address_id);
					$address->cherubs_update($item);
					$address->save(false);
					
				} else {
					// New contact/address
					$address = new Address;
					$address->attributes = $item;
					$address->save_cherub_monthly();	
					
					$contact = new Contact;
					$contact->attributes = $item;
					$contact->address_id = $address->id;
					$contact->sex = 'FEMALE';
					$contact->role = 'PARENT';
					$contact->primary_contact = 1;				
				}
				
				if ($cherub->lead_type == "CHERUB_P") {
					// Then we use the date for a due date
					$contact->due_date = $item['baby_dob'];

				} else {
					// It's post natal and we have a child record to create
					$child = new Contact;

					switch ($item['sex']) {
						case 'B':
							$child->sex = "MALE";
							break;
						case 'G':
							$child->sex = "FEMALE";
							break;
						default:
							$child->sex = NULL;
					}
					$child->role = 'CHILD';
					$child->address_id = $address->id;
					$child->surname = $contact->surname;
					$child->firstname = 'Baby';
					$child->dob = $item['baby_dob'];
					$child->primary_contact = 0;
					$child->wmg_cherub = 1; // Mark the child as a Watch me Grow Cherub
					$child->save(false);
				}				
			
				$contact->save(false);
			}

			$this->render('CMComplete');
			
		} else {
			// Render the File and Date selection form
			$icm = new CMSourceForm;
			$form = new CForm('application.views.cherub.CMSourceForm', $icm);
			$this->render('CMSource', array('form'=>$form));
		}
		
	}

	
	public function actionImportCherubHotLead()
	{
		$this->render('importCherubHotLead');
	}
	
	//
	// Cherubs Data Entry
	//
	// Used to entry historical cherubs data. Can also be used to maintain a cherub record (or enter a completely new one)
	//
	public function actionCde($address_id = NULL)
	{
		$cdeForm = new CDataEntry;
		
		$cdeForm->load($address_id);
		
		// Render the File and Date selection form
		
		if (isset($_POST['save'])) {
			
			$cdeForm->getAttributes($_POST);
			
			// We have a submitted form, validate and save
			
			$cdeForm->save();
			
			Yii::app()->user->setFlash('success',"Contact Added!");
			
			// Re-load the data
			$cdeForm->load($address_id);
				
		} else if (isset($_POST['overview']) && $address_id) {
			$this->redirect(array('/contact/view', "id"=>$cdeForm->contact["mum"]->id));
		}	

		$this->render('CDataEntryForm', array('form'=>$cdeForm));
	}
		
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}