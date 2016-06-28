<?php
$this->pageTitle=Yii::app()->name . ' - Admin';
$this->breadcrumbs=array(
	'About',
);
?>
<h1>Admin</h1>

<p>Admin areas:</p>
<ul>
  <li><?php echo CHtml::link('Letters', array('letter/index')); ?></li>
  <li><?php echo CHtml::link('Save Appointment Dues', array('appointment/saveDues'));?></li>
  <li><?php echo CHtml::link('Yiilog', array('yiilog/index'));?></li>
  
</ul>
<p>&nbsp;</p>
<p>Todo: </p>
<ul>
  <li>Appointment confirmation (text/email - use prefs)<br />
    These should be sent when a new appointment is made with the status DUE. This could be driven by the lifecycle - state machine.
  </li>
  <li>Google calenday integration<br />
    All appointments, created, changed and modified should be through the CRM. The CRM posts these to a Google Calendar.</li>
</ul>
<p>&nbsp;</p>
