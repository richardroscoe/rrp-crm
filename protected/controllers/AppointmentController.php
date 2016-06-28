<?php

class AppointmentController extends Controller
{
	public function actionCreate()
	{
		$this->render('create');
	}

	public function actionDelete()
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
		$appointments = new CActiveDataProvider('Appointment'); 
		
		// Display our populated contact form	
		$this->render('index', array('appointments' => $appointments));
	}

	public function actionUpdate($id = NULL, $address_id = NULL,
								 $owner_type_id = NULL, $owner_id = NULL)
	{
		if ($id) {
			$appt = Appointment::model()->findByPk($id);
			$action = 'updated';
		} else {
			$appt = new Appointment;
			$appt->owner_type_id = $owner_type_id;
			$appt->owner_id = $owner_id;
			$appt->address_id = $address_id;
			$action = 'created';
		}
			
		$form = new CForm('application.views.appointment._form', $appt);
		
		if ($form->submitted('submit') && $form->validate()) {
			$appt->save('false');
			Yii::app()->user->setFlash('success',"Appointment ".$action);
			
//			echo "<p>returnUrl = '".Yii::app()->user->returnUrl."'</p>";
			if (Yii::app()->user->returnUrl)
				$this->redirect(Yii::app()->user->returnUrl);			
		}
		
		$this->render('update', array('form'=>$form));
	}

	public function actionSaveDues() {
		echo "<p>Take a look at the code, currently commented out</p>";
//		Appointment::saveDues();
	}
	
	public function actionReminders()
	{
			Appointment::reminders();
			$this->render('reminders');
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