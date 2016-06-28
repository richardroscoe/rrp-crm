<?php

class ShootController extends Controller
{
	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
		$shoots = new CActiveDataProvider('Shoot'); 
		
		// Display our populated contact form	
		$this->render('index', array('shoots' => $shoots));
	}

	public function actionUpdate($id = NULL, $address_id = NULL)
	{
//		echo "<p>actionUpdate($id, $address_id)</p>";

		Yii::app()->user->setReturnUrl(Yii::app()->createUrl('shoot/update', array('id'=>$id, 'address_id'=>$address_id)));

		if ($id) {	
			$shoot = Shoot::model()->findByPk($id);
		} elseif ($address_id) {
			$shoot = new Shoot;
			$shoot->address_id = $address_id;
		}
		
//		echo "<p>actionUpdate - address </p>";
//		echo "<pre>";
//		print_r($address);
//		echo "</pre>";
		
		$form = new CForm('application.views.shoot._form');
		
		$form['shoot']->model = $shoot;
		$form['shoot']->title = 'Shoot information : '.Address::renderPCName($shoot->address);

		
		if($form->submitted('submit') && $form->validate()) {
			$shoot = $form['shoot']->model;

			if($shoot->save(false)){
				Yii::app()->user->setFlash('success',"Shoot updated!");
			}
		} else if ($form->submitted('overview')) {
			$this->redirect(array('/contact/view', "id"=>Contact::getPrimaryContactId($shoot->address->id)));
		}
		
		//Get the list of associated appointments

		$criteria=new CDbCriteria;
		$criteria->condition='address_id=:addr_id AND owner_type_id = \'SHOOT\' AND owner_id = :owner_id';
		$criteria->params=array(':addr_id' => $shoot->address_id, ':owner_id' => (($id == NULL) ? -1 : $id));
		
//		echo "<p>actionUpdate - criteria </p>";
//		echo "<pre>";
//		print_r($criteria);
//		echo "</pre>";
		
		$appointments = new CActiveDataProvider('Appointment', array('criteria' => $criteria)); 

		//Here we now show the recent shoots
		
		$criteria=new CDbCriteria;
		$criteria->condition='address_id=:id';
		$criteria->params=array(':id'=>$shoot->address_id);
		
		$shoots = new CActiveDataProvider('Shoot', array('criteria' => $criteria)); // $params is not needed
		
		// Display our populated contact form
		$this->render('update', array('form'=>$form, 'shoots' => $shoots, 'appointments' => $appointments));
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