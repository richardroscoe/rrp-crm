<?php
$this->breadcrumbs=array(
	'Contact',
);?>
<h1>Contacts<?php /*echo $this->id . '/' . $this->action->id; */ ?></h1>

<?php
	// A link to create a new contact record
	echo CHtml::link('Add New Contact', array('create'));
	echo '&nbsp;&nbsp;';
	echo CHtml::link('Export Email', array('exportEmail'));
	
	// Table of clients
	$dataProvider=new CActiveDataProvider('Contact');
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'columns' => array(
						   array(
								 'class'=>'CLinkColumn',
								 'header'=>'Name',
								 'labelExpression'=>'$data->name',
								 'urlExpression'=>'Yii::app()->createUrl("contact/update",array("id"=>$data->id))',
								 ),
						   'firstname',
						   'surname',
						   array(
								'name'=>'role',
								'value'=>'Enum::getLabel("ContactRole",$data->role)',
							),
						   'email_address',
						   'mobile_phone',
						   'wmg_cherub',
						   'newsletter_signup',
						   'primary_contact',
					),
	));

?>