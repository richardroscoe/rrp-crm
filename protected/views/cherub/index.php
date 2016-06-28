<?php
$this->breadcrumbs=array(
	'Cherubs',
);?>
<h1>Cherub Data Sets</h1>

<?php
	// A link to create a new contact record
	echo CHtml::link('Add New Cherub', array('cde'));
	echo "&nbsp;"; echo "&nbsp;";
	echo CHtml::link('Import Monthly Leads', array('importWMG'));
	echo "&nbsp;" ;echo "&nbsp;";
	echo CHtml::link('Import Cherubs Hot Lead', array('importCherubHotLead'));
	echo "&nbsp;" ;echo "&nbsp;";
	echo CHtml::link('WMG Activity', array('wmgIndex'));
	
?>
<br />
<?php
	$this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$cherubs,
		'columns' => array(	
						   array(
								 'class'=>'CLinkColumn',
								 'header'=>'Date',
								 'labelExpression'=>'CrmHelper::monthOutput($data->date_upload_data)',
								 'urlExpression'=>'Yii::app()->createUrl("cherub/view",array("id"=>$data->id))',
								 ),
							array(
								'name'=>'lead_type',
								'value'=>'Enum::getLabel("CherubLeadType", $data->lead_type)',
							),								 
					),
	));

?>