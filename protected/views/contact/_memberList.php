<?php
	// A link to create a new contact record
	echo CHtml::link('Add Family Member', array('contact/update', 'address_id'=>$address_id));
	
	// id, type, location_type, location_address_id, description, address_id, date_added
	
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$members,
		'columns' => array(
							array(
								 'class'=>'CLinkColumn',
								 'header'=>'name',
								 'labelExpression'=>'$data->name',
								 'urlExpression'=>'Yii::app()->createUrl("contact/update",array("id"=>$data->id))',
								 ),
						 	array(
								 'name'=>'sex',
								 'value'=>'Enum::getLabel("ContactSex",$data->sex)',
								 ),
							array(
								 'name'=>'role',
								 'value'=>'Enum::getLabel("ContactRole",$data->role)',
								 ),
							array(
								 'name'=>'dob',
								 'value'=>'$data->dob',
								 ),
							array(
								 'name'=>'wmg_cherub',
								 'value'=>'Enum::getLabel("YesNo",$data->wmg_cherub)',
								 ),								 
							array(
								 'name'=>'primary_contact',
								 'value'=>'Enum::getLabel("YesNo",$data->primary_contact)',
								 ),
							array(
								 'class'=>'CLinkColumn',
								 'header'=>'email_address',
								 'labelExpression'=>'$data->email_address',
								 // URL SHOULD BE Mailto: emailadd
								 'urlExpression'=>'"mailto: ".$data->email_address',
								 ),
							array(            // display a column with "view", "update" and "delete" buttons
								'class'=>'CButtonColumn',
							),
					),
	));

?>