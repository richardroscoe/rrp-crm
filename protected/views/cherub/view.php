<?php
$this->breadcrumbs=array(
	'Cherub'=>array('/cherub'),
	'Update',
);?>
<?php echo CHtml::link('Export Warm Leads', array('cherub/exportWarm', 'id'=>$cherub->id)); ?>
<br /><br />
<h2>Lead Status for: <?php echo CrmHelper::monthOutput($cherub->date_upload_data); ?></h2>
<?php

	if ($CDPActive->itemCount > 0) {
?>
	<h3>Active leads</h3>
<?php		
		

		$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$CDPActive,
			'columns' => array(
								array(
									'class'=>'CLinkColumn',
									'header'=>'Primary Contact',
									'labelExpression'=>array('Address', 'renderPrimaryContact'),
									'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>Contact::getPrimaryContactId($data->id)))',
								),
								
								'addr1',
								'postcode',
								
								array(
									'name'=>'Appointment Date',
									'value'=>'CrmHelper::datetimeOutput($data->appointments[0]->apt_date)',
								),
								array(
									'name'=>'Appointment Sate',
									'value'=>'Enum::getLabel("AppointmentState",$data->appointments[0]->state)',
								),
						),
		));

	} else {
?>
	<p>No active leads from this month</p>
<?php
	}

	if ($CDPWarm->itemCount > 0) {
?>
	<h3>Warm leads</h3>
<?php		
		

		$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$CDPWarm,
			'columns' => array(
								array(
									'class'=>'CLinkColumn',
									'header'=>'Primary Contact',
									'labelExpression'=>array('Address', 'renderPrimaryContact'),
									'urlExpression'=>'Yii::app()->createUrl("contact/update",array("id"=>Contact::getPrimaryContactId($data->id)))',
								),
								
								'addr1',
								'town',
								'postcode',
						),
		));

	} else {
?>
	<p>No Warm leads from this month</p>
<?php
	}
?>

Display the cherub table record

Display the leads ...

Table of those that booked

Table of those not yet booked
