<?php
$this->breadcrumbs=array(
	'Shoot'=>array('/shoot'),
	'Update',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
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
<h1>Appointments here</h1>
</div>

<div id="tasks" class="wide form">
<h1>Tasks here</h1>
</div>

<div id="orders" class="wide form">
<h1>Orders ??? here</h1>
</div>