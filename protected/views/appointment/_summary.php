<?php
	// id, type, location_type, location_address_id, description, address_id, date_added
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$appointments,
		'columns' => array(
							array(
								'class'=>'CLinkColumn',
								'header'=>'Primary Contact',
								'labelExpression'=>array('Appointment', 'renderPrimaryContact'),
								'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>Contact::getPrimaryContactId($data->address_id)))',
							),
							array(						
								 'class'=>'CLinkColumn',
								 'header'=>'type',
								 'labelExpression'=>'Enum::getLabel("AppointmentType",$data->type)',
								 'urlExpression'=>'Yii::app()->createUrl("appointment/update",array("id"=>$data->id))',
							),
							array(
								'name'=>'apt_date',
								'value'=>'CrmHelper::dateTimeOutput($data->apt_date)',
							),
						   	array(
								'name'=>'state',
								'value'=>'Enum::getLabel("AppointmentState",$data->state)',
							),
							array(						
								 'name'=>'Owner Info',
								 'value'=>array('Owner', 'renderSummaryDescription'),
							),						
					),
	));

?>