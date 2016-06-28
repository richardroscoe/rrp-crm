<?php
$this->breadcrumbs=array(
	'Cherubs'=>array('/cherub'),
	'wmgIndex',
);?>


<h1>WMG Activity</h1>

<p>
Export&nbsp;
<?php echo CHtml::link('Letter 1', array('exportLetter1')); ?>,&nbsp;
<?php echo CHtml::link('Letter 2', array('exportLetter2'));?>
</p>

<!--
<pre>
	Display 
    a) Booked - contacts that have a due appoinment for a WMG1, not ignored      
    
    b) Letter 1 Leads - those that are in the target age range, that don't have a WMG1 appoinment and haven't yet been contacted recently    
    	target age: 13-16 weeks
        contacted recently: last_contact > 1 month ago
        not ignored
        
    c) Letter 2 Leads - those that are in the target age range, that have been contacted recently and don't have a WMG1 appointment.
    	target age: 13-16 weeks
        contacted recently: last_contact > 2 weeks ago and last_contact < 3 month ago
        not ignored
        
    d) Young - those leads that are too young
    	age < 13 weeks
        not ignored

	e) Old - those we missed sending a letter to ... or those not booked?
    
Need to be able to export lists. Need to be able to refine export list ... so that for example you tick a [un]check box to indicate those to export.

When we export ... that sets the last_contact date to NOW()


    
</pre>
-->
<h3>Booked Cherubs</h3>
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$booked,
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
							'name'=>'Appointment State',
							'value'=>'Enum::getLabel("AppointmentState",$data->appointments[0]->state)',
						),						
					),
	));
	
?>
<h3>Letter 1</h3>

<?php

	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$letter1,
		'columns' => array(	
						array(
							'class'=>'CLinkColumn',
							'header'=>'Primary Contact',
							'labelExpression'=>array('Address', 'renderPrimaryContact'),
							'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>Contact::getPrimaryContactId($data->id)))',
						),		
						'addr1',
						'town',
						'postcode',
						
						
						array(
							'name'=>'Baby DOB',
							'value'=>'$data->members[0]->dob',
							),									
					),
	));
	
?>
<h3>Letter 2</h3>
<?php

	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$letter2,
		'columns' => array(	
						array(
							'class'=>'CLinkColumn',
							'header'=>'Primary Contact',
							'labelExpression'=>array('Address', 'renderPrimaryContact'),
							'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>Contact::getPrimaryContactId($data->id)))',
						),		
						'addr1',
						'town',
						'postcode',
						
						array(
							'name'=>'Baby DOB',
							'value'=>'$data->members[0]->dob',
							),
												
					),
	));
	
?>
<h3>Young</h3>
<?php

	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$young,
		'columns' => array(	
						array(
							'class'=>'CLinkColumn',
							'header'=>'Primary Contact',
							'labelExpression'=>array('Address', 'renderPrimaryContact'),
							'urlExpression'=>'Yii::app()->createUrl("contact/view",array("id"=>Contact::getPrimaryContactId($data->id)))',
						),		
						'addr1',
						'town',
						'postcode',
						
						array(
							'name'=>'Baby DOB',
							'value'=>'$data->members[0]->dob',
							),
												
					),
	));
	
?>
<h3>Old</h3>
<p>END</p>