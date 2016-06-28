<?php
$this->breadcrumbs=array(
	'Search',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<?php
	// A link to create a new contact record
	echo CHtml::link('Add New Contact', array('create'));
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$contacts,
		'columns' => array(
						   array(
								 'class'=>'CLinkColumn',
								 'header'=>'Name',
								 'labelExpression'=>'$data->name',
								 'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>$data->id))',
								 ),
						   'firstname',
						   'surname',
						   array(
								'name'=>'role',
								'value'=>'Enum::getLabel("ContactRole",$data->role)',
							),
						   'email_address',
						   'mobile_phone',
						   array(
						   		'name' => 'newsletter_signup',
								'value' => '($data->newsletter_signup == "1" ? "Yes" : "")',
							),
							array(
						   		'name' => 'primary_contact',
								'value' => '($data->primary_contact == "1" ? "Yes" : "")',
							),
							array(
								 'class'=>'CLinkColumn',
								 'header'=>'',
								 'label'=>'CDE',
								 'urlExpression'=>'Yii::app()->createUrl("cherub/cde",array("address_id"=>$data->address_id))',							
							),
							array(
								 'class'=>'CLinkColumn',
								 'header'=>'',
								 'label'=>'Edit',
								 'urlExpression'=>'Yii::app()->createUrl("contact/update",array("id"=>$data->id))',							
							),
					),
	));

?>