<?php
	// id, type, location_type, location_address_id, description, address_id, date_added
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$tasks,
		'columns' => array(
							array(
								'class'=>'CLinkColumn',
								'header'=>'Primary Contact',
								'labelExpression'=>array('Contact', 'renderPrimaryContact'),
								'urlExpression'=>'Yii::app()->createUrl("contact/update",array("id"=>Contact::getPrimaryContactId($data->address_id)))',
							),
							array(						
								 'class'=>'CLinkColumn',
								 'header'=>'description',
								 'labelExpression'=>'$data->description',
								 'urlExpression'=>'Yii::app()->createUrl("task/update",array("id"=>$data->id))',
							),
							'due_date',
							'priority',
						   	array(
								'name'=>'state',
								'value'=>'Enum::getLabel("TaskState",$data->state)',
							),
														
					),
	));

?>