<link rel="stylesheet" type="text/css" href="/css/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" type="text/css" href="/css/ui-lightness/jquery-ui-1.8.18.custom.css" />
<script src="/js/jquery.js"></script>
<script src="/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="/js/jquery-ui-timepicker-addon.js"></script>


<?php
$this->breadcrumbs=array(
	'Appointment'=>array('/appointment'),
	'Update',
);?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<style type="text/css">
<!--
.wide input
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
<script>
	$('#Appointment_apt_date').datetimepicker( {
		timeFormat: 'hh:mm',
		dateFormat: 'yy-mm-dd',
		stepMinute: 5,
		hourMin: 8,
		hourMax: 18
		});
</script>
