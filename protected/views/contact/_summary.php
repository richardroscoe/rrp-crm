<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$contacts,
		'columns' => array(
							array(
								 'class'=>'CLinkColumn',
								 'header'=>'name',
								 'labelExpression'=>'$data->name',
								 'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>$data->id))',
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
								 'name'=>'Last Contact',
								 'value'=>'$data->address->last_contact',
								 ),
							array(
								 'class'=>'CLinkColumn',
								 'header'=>'Options',
								 'label'=>'Birthday Invite',
								 'urlExpression'=>'Yii::app()->createUrl("contact/birthday",array("id"=>$data->id))',
								 ),								 
					),
	));
?>