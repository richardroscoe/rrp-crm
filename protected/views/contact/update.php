<?php
$this->breadcrumbs=array(
	'Contact'=>array('/contact'),
	ucfirst($this->action->id),
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<style type="text/css">
<!--
#Address_company_name,
#Address_addr1,
#Address_addr2,
#Address_addr3,
#Address_town,
#Address_county,
#Address_postcode,
#Address_landline,
#Contact_title,
#Contact_firstname,
#Contact_lastname,
#Contact_dob,
#Contact_due_date,
#Contact_email_address,
#Contact_mobile_phone,
#Contact_notes
{
	width: 20em;
}
</style>
<div class="wide form">
<?php echo $form->render(); ?>
</div>

<?php
Yii::app()->clientScript->registerScript( 
                'myHideEffect',
                '$("div[class^=flash-]").animate({opacity: 1.0}, 3000).fadeOut("slow");',
                CClientScript::POS_READY
            );
?>
<div class="flash-message">
<?php
if( Yii::app()->user->hasFlash('success') ) {
    echo Yii::app()->user->getFlash('success');
}

?>
</div>

<div id="members" class="wide form">
<?php echo CHtml::beginForm(); ?>
<fieldset>
<legend>Other members</legend>
<?php
// Now pull in the most recent (say 5 shoots) for the customer

// Maybe render partial from the controller ... cos we don't want it in create
	if (isset($members)) {
//		echo "<hr /><h2>Other members</h2>";
//$form['address']->model = $address;
		$this->renderPartial('//contact/_memberList', array('address_id'=> $form['address']->model->id, 'members' => $members));
	}
?>
</fieldset>
<?php echo CHtml::endForm(); ?>
</div>

<div id="shoots" class="wide form">

<?php echo CHtml::beginForm(); ?>
<fieldset>
<legend>Shoots</legend>
<?php
// Now pull in the most recent (say 5 shoots) for the customer

// Maybe render partial from the controller ... cos we don't want it in create
	if (isset($shoots)) {
//		echo "<hr /><h2>Shoots</h2>";
		$this->renderPartial('//shoot/_list', array('address_id'=> $form['address']->model->id, 'shoots' => $shoots));
	}
?>
</fieldset>
<?php echo CHtml::endForm(); ?>
</div>

<div id="orders" class="wide form">
<h1>Orders here</h1>
</div>
