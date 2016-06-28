<?php
	echo CHtml::link('Edit', array('contact/update', 'id'=>$id));
	
	// id, type, location_type, location_address_id, description, address_id, date_added
	
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$contact,
		'attributes'=>array(
			'title',             // title attribute (in plain text)
			
			'owner.name',        // an attribute of the related object "owner"
			'description:html',  // description attribute in HTML
			array(               // related city displayed as a link
				'label'=>'City',
				'type'=>'raw',
				'value'=>CHtml::link(CHtml::encode($model->city->name),
									 array('city/view','id'=>$model->city->id)),
			),
		),
	));

?>