<?php
	// A link to create a new contact record
	echo CHtml::link('Add New Shoot', array('shoot/update', 'address_id'=>$address_id));
	
	// id, type, location_type, location_address_id, description, address_id, date_added
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$shoots,
		'columns' => array(
							array(						
								 'class'=>'CLinkColumn',
								 'header'=>'type',
								 'labelExpression'=>'Enum::getLabel("ShootType",$data->type)',
								 'urlExpression'=>'Yii::app()->createUrl("shoot/update",array("id"=>$data->id))',
							),
						   array(
								 'class'=>'CLinkColumn',
								 'header'=>'description',
								 'labelExpression'=>'$data->description',
								 'urlExpression'=>'Yii::app()->createUrl("shoot/update",array("id"=>$data->id))',
								 ),
						   array(
								'name'=>'location_type',
								'value'=>'Enum::getLabel("ShootLocationType",$data->location_type)',
							),
						   'location_address_id',
					),
	));

?>