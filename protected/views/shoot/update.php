<?php
$this->breadcrumbs=array(
	'Shoot'=>array('/shoot'),
	'Update',
);?>
<style type="text/css">
<!--
#Shoot_type,
#Shoot_location_type,
#Shoot_location_address_id,
#Shoot_description
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

<div id="appointments" class="wide form">

<?php echo CHtml::beginForm(); ?>
<fieldset>
<legend>Appointments</legend>
<?php
// Now pull in the shoots related appointments

	if (isset($appointments)) {
		$this->renderPartial('//appointment/_list', array('address_id' => $form['shoot']->model->address_id, 'owner_id'=> $form['shoot']->model->id, 'owner_type_id' => 'SHOOT', 'appointments' => $appointments));
	} else {
		// Offer the template ??
	}
?>
</fieldset>
<?php echo CHtml::endForm(); ?>
</div>


<div id="tasks" class="wide form">
<h1>Tasks here</h1>
</div>

<div id="orders" class="wide form">
<h1>Orders ??? here</h1>
</div>