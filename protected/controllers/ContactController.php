<?php

class ContactController extends Controller
{

	public function actionCreate()
	{		
//		echo "<p>actionCreate()</p>";	
		$form = new CForm('application.views.contact._form');

		$form['contact']->model = new Contact;
		$form['address']->model = new Address;
	
		if($form->submitted('submit') && $form->validate()) {
			$contact = $form['contact']->model;
			$address = $form['address']->model;
					
			// First save the address, we need it's ID
			if($address->save(false)) {
				$contact->address_id = $address->id;					
				$contact->save(false);
				
				Yii::app()->user->setFlash('success',"Contact Added!");
				
				$this->redirect(array('/contact/update', "id"=>$contact->id));
			}
		} else {
			// Default value
			$form['contact']->model->primary_contact = 1;
//			$form['address']->model->lead_date = 'NOW()';
		}
		
		$this->render('update', array('form'=>$form));		
	}

	public function actionUpdate($id = NULL, $address_id = NULL)
	{
//		echo "<p>actionUpdate( $id, $address_id)</p>";
		if ($id) {	
			$contact = Contact::model()->findByPk($id);
			$address = Address::model()->findByPk($contact->address_id);
		} elseif ($address_id) {
			$contact = new Contact;
			$address = Address::model()->findByPk($address_id);
		}
		
		$form = new CForm('application.views.contact._form');
		
		$form['contact']->model = $contact;
		$form['address']->model = $address;

		if($form->submitted('submit') && $form->validate()) {
			$contact = $form['contact']->model;
			$address = $form['address']->model;
			$contact->address_id = $address->id;
		
			// If we're not a company ... use the family name for the location
//			if (strlen($address->company_name) == 0 && strlen($contact->surname) > 0) {
//				$address->company_name = $contact->surname.' Family';
//			}
						
			if($contact->save(false)){
				$address->save(false);
				Yii::app()->user->setFlash('success',"Contact updated!");
				$this->redirect(array('/contact/update', "id"=>$contact->id));
			}
		} else if ($form->submitted('overview') && $contact->id) {
			$this->redirect(array('/contact/view', "id"=>$contact->id));
		}	
		
		//Get the list of family members

		$criteria=new CDbCriteria;
		$criteria->condition='address_id=:addr_id AND id != :id';
		$criteria->params=array(':addr_id' => $address->id, ':id' => (($id == NULL) ? -1 : $id));
		
		$members = new CActiveDataProvider('Contact', array('criteria' => $criteria)); 

		//Here we now show the recent shoots
		
		$criteria=new CDbCriteria;
		$criteria->condition='address_id=:id';
		$criteria->params=array(':id'=>$address->id);
		
		$shoots = new CActiveDataProvider('Shoot', array('criteria' => $criteria)); 
		
		// Display our populated contact form
		
		$this->render('update', array('form'=>$form, 'shoots' => $shoots, 'members'=>$members));
	}


	public function actionDeleteMember()
	{
		$this->render('deleteMember');
	}

	public function actionExportEmail()
	{
		
		// Get a list of all our contacts, that we aren't ignoring, that have email addresses
		$criteria=new CDbCriteria;
		$criteria->with='address';
		$criteria->condition='lead_ignore = 0 AND email_address IS NOT NULL AND email_address != ""';
		// 
//		$criteria->params=array(':name'=>'%'.$searchName.'%', ':pcode'=>'%'.$searchPcode.'%');
		
		$contacts = new CActiveDataProvider('Contact', array('criteria' => $criteria, 'pagination'=>false));
// "blah<br>";
//echo "<pre>"; print_r($contacts->getData()); echo "</pre>";
		
//		$contacts = Contact::model()->with('Address')->findAll($criteria);
				
		// Do the export
		$this->render('exportEmail', array('contacts'=>$contacts));
	}
	
	public function actionContacted($id)
	{
		$contact = Contact::model()->findByPk($id);
		$address = $contact->address;
		
		// Update the last_contacted field for our address
		$address->contactedNow();
		
		// Back to the view
		$this->actionView($id);
	}

	// Called to send a birthday invitation
	public function actionBirthday($id)
	{

	}	
	
	public function actionIndex()
	{
		$this->render('index');
	}
	
	//
	// Display an overview of a client, this includes family members, address
	// their shoots, and the shoot related data (appointments, tasks, orders)
	//
	public function actionView($id)
	{
		Yii::app()->user->setReturnUrl(Yii::app()->createUrl('contact/update', array('id'=>$id)));
	
		$shoot_attrs = array('Appointment'/*, 'Task', 'Order'*/);
		
		$contact = Contact::model()->findByPk($id);
		$address = $contact->address;
		$members = $address->members(array('order'=>'role DESC, dob ASC'));
		$shoots = $address->shoots(array('order'=>'id DESC'));

		$this->render('view', array('contact'=>$contact, 'address'=>$address, 'members'=>$members, 'shoots'=>$shoots));
	}
	
	public function actionSearchName()
	{
//		echo "<pre>"; print_r($_POST); echo "</pre>";
		
		if (isset($_POST['search'])) {
			$searchName = (isset($_POST['searchName']) ? $_POST['searchName'] : '');
			
			// If the search is for a postcode, change spaces into %%
			$searchPcode = str_replace(' ', '%%', preg_replace('/\s\s+/', ' ',$searchName));
			
			$criteria=new CDbCriteria;
			$criteria->with='address';
			$criteria->condition='name LIKE :name OR mobile_phone LIKE :name OR landline LIKE :name OR postcode LIKE :pcode OR addr1 LIKE :name';
			$criteria->params=array(':name'=>'%'.$searchName.'%', ':pcode'=>'%'.$searchPcode.'%');
			
			$contacts = new CActiveDataProvider('Contact', array('criteria' => $criteria));
	
	//echo "<pre>Contact - search '$searchName'<br>"; print_r($contacts); echo "</pre>";
	
			// Search contacts with the supplied name
			
			$this->render('searchName', array('contacts'=>$contacts));
		} elseif (isset($_POST['addnew'])) {
			$this->redirect(array('/contact/create'));
		}
		
//		exit(0);
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


/*

FORM

return array(
    'elements' => array(
        'name' => array('type' => 'text'),
        'barId' => array('type' => 'dropdownlist'),
    ),
    'buttons' => array(
        'submit' => array('type' => 'submit'),
        'cancel' => array('type' => 'submit', 'label' => 'Cancel'),
    ),
);


------------------------------------------------
public function actionAdd()
{
    $this->_addOrUpdate(new Foo, 'add', 'Add');
}

public function actionUpdate()
{
    $this->_addOrUpdate($this->loadModel(), 'update', 'Update');
}

private function _addOrUpdate($model, $viewFile, $submitLabel)
{
    $form = new CForm('application.views.foo._form', $model);
    $form->buttons['submit']->label = $submitLabel;
    
    $form['barId']->label = Bar::model()->getAttributeLabel('name');
    $form['barId']->items = CHtml::listData(Bar::model()->findAll(), 'id', 'name');
    
    if ( ( $form->submitted() && $form->validate() && $model->save() ) || $form->submitted('cancel', false) )
        $this->redirect(array('index'));
    
    $this->render($viewFile, array('form' => $form, 'model' => $model));
}
*/