<?php
$this->breadcrumbs=array(
	'Cherubs'=>array('/cherub'),
	'CM Import Preview',
);?>
<h1>Import Cherub Data</h1>


<h3>Leads: <?php echo Enum::getLabel('Month', $source->month).', '.$source->year; ?>, <?php echo Enum::getLabel('CherubLeadType',$source->lead_type); ?>, <?php echo "Filename '".$source->fileinfo->name."'";?></h3>


<div class="form">
<?php echo CHtml::beginForm(); ?>
<?php echo CHtml::hiddenField('date_upload_data', $source->year.'-'.$source->month.'-1'); ?>
<?php echo CHtml::hiddenField('lead_type', $source->lead_type); ?>
<table>
<tr><th>First Name</th><th>Surname</th><th>Addr1</th><th>Town</th><th>Postcode</th><th>Sex</th><th>Dob/Due</th>
<th>Ignore</th><th>Import</th></tr>
<?php foreach($items as $i=>$item): ?>
<tr>
<td><?php echo CHtml::activeTextField($item,"[$i]firstname", array('size'=>'12')); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]surname", array('size'=>'12')); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]addr1"); ?>
	<?php echo CHtml::activeHiddenField($item,"[$i]addr2"); ?>
	<?php echo CHtml::activeHiddenField($item,"[$i]addr3"); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]town"); ?>
	<?php echo CHtml::activeHiddenField($item,"[$i]county"); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]postcode", array('size'=>'7')); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]sex", array('size'=>'1')); ?></td>
<td><?php echo CHtml::activeTextField($item,"[$i]baby_dob", array('size'=>'10')); ?></td>
<td><?php echo CHtml::activeCheckBox($item,"[$i]lead_ignore"); ?>
<td><?php echo CHtml::activeCheckBox($item,"[$i]import"); ?>
<?php echo CHtml::activeHiddenField($item,"[$i]name"); ?>
<?php echo CHtml::activeHiddenField($item,"[$i]title"); ?>

<?php echo CHtml::hiddenField(get_class($item)."[$i][lead_date]",$source->year.'-'.$source->month.'-1'); ?>
<?php echo CHtml::hiddenField(get_class($item)."[$i][lead_type]",$source->lead_type); ?></td>
</tr>
<?php
	$dup = $item['duplicate'];
	if ($dup) {

		if ($dup->address->lead_date)
			$date = 'Data '.$dup->address->lead_date;
		else if ($dup->address->date_added)
			$date = 'Added '.$dup->address->date_added;
		else
			$date = '';
			
		$lead_type = Enum::getLabel('AddressLeadType', $dup->address->lead_type);
		
		$name = CHtml::link($dup->name, array('contact/update', 'id'=>$dup->id)); 
		
		$txt = "Possible duplicate - Found ".
				$name." : ".
				$dup->address->addr1." : ".
				$date." : ".
				$lead_type;				
?>
<tr>
	<td colspan="10" class="importwarn">
<?php echo $txt; ?>&nbsp;- Update 
<?php echo CHtml::activeCheckBox($item,"[$i]update"); ?>
 (if not ticked, a new entry will be created)</td>
</tr>
<?php
		echo CHtml::hiddenField(get_class($item)."[$i][duplicate]",$dup->id);
		
	} else {
 		echo CHtml::hiddenField(get_class($item)."[$i][update]", 0);
		echo CHtml::hiddenField(get_class($item)."[$i][duplicate]",'');
	}
?>
<?php endforeach; ?>
</table>
 
<?php echo CHtml::submitButton('Import', array('name'=>'import')); ?>
<?php echo CHtml::endForm(); ?>
</div><!-- form -->
