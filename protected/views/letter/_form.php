<div class="form">
<?php
	$toolbar = array( 
    array(
        'Source',
    ), 
    array(
        'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 
    ), 
    array(
        'Find', 'Replace', '-', 'SelectAll', '-', 'SpellChecker', 'Scayt'
    ),
	array(
        'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak',
    ), 
    '/', 
    array(
        'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat', 
    ), 
    array(
        'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr', 'BidiRtl', 
    ), 
    array(
        'Link', 'Unlink', 'Anchor', 
    ), 
    '/',
    array(
        'Styles', 'Format', 'Font', 'FontSize', 
    ), 
    array(
        'TextColor', 'BGColor', 
    ), 
    array(
        'Maximize', 'ShowBlocks',
    ), 
);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'letter-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php /*echo $form->textField($model,'type',array('size'=>16,'maxlength'=>16)); */?>
        <?php echo $form->dropDownList($model,'type',Enum::getList('LetterType'), array('prompt'=>'Please select')/*,array('size'=>16,'maxlength'=>16)*/); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'media'); ?>
		<?php /*echo $form->textField($model,'media',array('size'=>16,'maxlength'=>16));*/ ?>
        <?php echo $form->dropDownList($model,'media',Enum::getList('LetterMedia'), array('prompt'=>'Please select')/*,array('size'=>16,'maxlength'=>16)*/); ?>
		<?php echo $form->error($model,'media'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cat'); ?>
		<?php //echo $form->textField($model,'cat',array('size'=>16,'maxlength'=>16)); ?>
        <?php echo $form->dropDownList($model,'cat',Enum::getList('AppointmentType'), array('prompt'=>'Please select')); ?>
		<?php echo $form->error($model,'cat'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'subcat'); ?>
		<?php echo $form->textField($model,'subcat',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'subcat'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'sex'); ?>
		<?php echo $form->textField($model,'sex',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'sex'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php //echo $form->labelEx($model,'body'); ?>
		<?php //echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
		<?php // $form->error($model,'body'); ?>
	</div>
    
	<div class="row">
    <?php    
		$this->widget('ext.editMe.ExtEditMe', array(
			'model'=>$model,
			'attribute'=>'body',
			'toolbar'=>$toolbar,
			'height'=>'400',
/*			'htmlOptions'=>array('option'=>'value'),
			'editMeOption1'=>'value',
			'editMeOption2'=>'value',
			...
			*/
		));
	?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->