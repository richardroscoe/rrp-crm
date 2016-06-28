<?php
	// A link to create a new contact record
	echo CHtml::link('Add New Appointment', array('appointment/update', 'address_id'=>$address_id, 'owner_id'=>$owner_id, 'owner_type_id' => 'SHOOT'));
	
	// id, type, location_type, location_address_id, description, address_id, date_added
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$appointments,
		'columns' => array(
							array(						
								 'class'=>'CLinkColumn',
								 'header'=>'type',
								 'labelExpression'=>'Enum::getLabel("AppointmentType",$data->type)',
								 'urlExpression'=>'Yii::app()->createUrl("appointment/update",array("id"=>$data->id))',
							),
							'apt_date',

						   array(
								'name'=>'state',
								'value'=>'Enum::getLabel("AppointmentState",$data->state)',
							),
						   array(
								 'class'=>'CLinkColumn',
								 'header'=>'description',
								 'labelExpression'=>'$data->description',
//								 'urlExpression'=>'Yii::app()->createUrl("shoot/update",array("id"=>$data->id))',
								 ),							
					),
	));

?>