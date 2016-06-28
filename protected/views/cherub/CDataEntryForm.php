<?php
$this->breadcrumbs=array(
	'Cherubs'=>array('/cherub'),
	'Cherubs Data Entry',
);?>
<style type="text/css">
.rightcol input,
.leftcol input {
	width: 275px;
}
.rightcol textarea,
.leftcol textarea {
	width:275px;
}
label {
	padding-top: .5em;
}
.input {
	margin: 0px;
}
</style>

<h1>Cherubs Data Entry</h1>

<div class="form wide">

<?php echo CHtml::beginForm(); ?>

<?php /*echo $form->errorSummary($model);*/ ?>

<?php 
//echo "<pre>"; print_r($form['contact']); echo "</pre>"
?>
<div class="row submit">
	<?php echo CHtml::submitButton('Overview', array('name'=>'overview')); ?>
</div>
<div class="leftcol">
<fieldset>
<legend>Mum</legend>
    <?php /* echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]id'); */?>
    <?php echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]sex'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]role'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]dob'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]due_date'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]title'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['mum'], '[mum]address_id'); ?>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]firstname'); ?>
        <?php echo CHtml::activeTextField($form['contact']['mum'], '[mum]firstname') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]surname'); ?>
        <?php echo CHtml::activeTextField($form['contact']['mum'], '[mum]surname') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]email_address'); ?>
        <?php echo CHtml::activeTextField($form['contact']['mum'], '[mum]email_address') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]newsletter_signup'); ?>
        <?php echo CHtml::activeCheckBox($form['contact']['mum'], '[mum]newsletter_signup') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]primary_contact'); ?>
        <?php echo CHtml::activeCheckBox($form['contact']['mum'], '[mum]primary_contact') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]mobile_phone'); ?>
        <?php echo CHtml::activeTextField($form['contact']['mum'], '[mum]mobile_phone') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]pref_contact_method'); ?>
        <?php echo CHtml::activeDropDownList($form['contact']['mum'], '[mum]pref_contact_method', Enum::getList('ContactMethod'), array('prompt'=>'Please select')) ?>
    </div>    
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['mum'], '[mum]notes'); ?>
        <?php echo CHtml::activeTextArea($form['contact']['mum'], '[mum]notes') ?>
    </div>
</fieldset>

<fieldset>
<legend>Child 1</legend>
    <?php /*echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]id'); */ ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]address_id'); ?>    
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]role'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]title'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]email_address'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]newsletter_signup'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]primary_contact'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]mobile_phone'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]due_date'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['child1'], '[child1]wmg_cherub'); ?>

    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['child1'], '[child1]firstname'); ?>
        <?php echo CHtml::activeTextField($form['contact']['child1'], '[child1]firstname') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['child1'], '[child1]surname'); ?>
        <?php echo CHtml::activeTextField($form['contact']['child1'], '[child1]surname'); ?>
        
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['child1'], '[child1]sex'); ?>
        <?php echo CHtml::activeDropDownList($form['contact']['child1'], '[child1]sex', Enum::getList('ContactSex'), array('prompt'=>'Please select')) ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['child1'], '[child1]dob'); ?>
        <?php echo CHtml::activeTextField($form['contact']['child1'], '[child1]dob') ?>
    </div>        
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['child1'], '[child1]notes'); ?>
        <?php echo CHtml::activeTextArea($form['contact']['child1'], '[child1]notes') ?>
    </div>
</fieldset>
</div>
<?php 
//echo "<pre>"; print_r($form['address']); echo "</pre>"
?>
<div class="rightcol">
<fieldset>
<legend>Address</legend>
    <?php /* echo CHtml::activeHiddenField($form['address'], 'id'); */ ?>
    <?php echo CHtml::activeHiddenField($form['address'], 'primary_contact_id'); ?>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'company_name'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'company_name') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'addr1'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'addr1') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'addr2'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'addr2') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'addr3'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'addr3') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'town'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'town') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'county'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'county') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'postcode'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'postcode') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'landline'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'landline') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'lead_type'); ?>
        <?php echo CHtml::activeDropDownList($form['address'], 'lead_type', Enum::getList('AddressLeadType'), array('prompt'=>'Please select')) ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['address'], 'lead_date'); ?>
        <?php echo CHtml::activeTextField($form['address'], 'lead_date'); ?>
    </div>
</fieldset>

<fieldset>
<legend>Dad</legend>
    <?php /* echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]id'); */?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]address_id'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]role'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]sex'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]dob'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]notes'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]title'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]email_address'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]newsletter_signup'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]primary_contact'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]mobile_phone'); ?>
    <?php echo CHtml::activeHiddenField($form['contact']['dad'], '[dad]due_date'); ?>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['dad'], '[dad]firstname'); ?>
        <?php echo CHtml::activeTextField($form['contact']['dad'], '[dad]firstname') ?>
    </div>
    <div class="row">
		<?php echo CHtml::activeLabel($form['contact']['dad'], '[dad]surname'); ?>
        <?php echo CHtml::activeTextField($form['contact']['dad'], '[dad]surname') ?>
    </div>
</fieldset>
</div>
<div class="clear"></div>

<div class="table row">
<fieldset>
<legend>Shoots</legend>

<?php
	foreach ($form['shoots'] as $s => $shoot) {
?>
    <fieldset>
    <legend>Shoot # <?php echo $s; ?></legend>
    
    	<div class="row">
       		<?php echo CHtml::activeLabel($shoot, '['.$s.']type'); ?>
	        <?php echo CHtml::activeDropDownList($shoot, '['.$s.']type', Enum::getList('ShootType'), array('prompt'=>'Please select')) ?>
        </div>
    	
        <div class="clear"></div>
        
        <table width="100%">
        <caption>Appointments</caption>
        <tr>
            <th>Appt Type</th><th>Date</th><th>State</th><th>Notes</th>
        </tr>
    <?php
        foreach ($form['appointment'][$s] as $a => $appt) {
    ?>
            <tr>
            <td>
                <?php echo CHtml::activeDropDownList($appt, '['.$s.']['.$a.']type', Enum::getList('AppointmentType'), array('prompt'=>'Please select')); ?>
            </td>
            <td>
                <?php echo CHtml::activeTextField($appt, '['.$s.']['.$a.']apt_date', array('maxlength'=>'22', 'size'=>'22')); ?>
            </td>
            <td>
                <?php echo CHtml::activeDropDownList($appt, '['.$s.']['.$a.']state', Enum::getList('AppointmentState'), array('prompt'=>'Please select')); ?>
            </td>
            <td>
	            <?php echo CHtml::activeHiddenField($appt, '['.$s.']['.$a.']description'); ?>
                <?php echo CHtml::activeTextArea($appt, '['.$s.']['.$a.']notes', array('cols'=>'35', 'rows'=>'1')); ?>
            </td>
            </tr>            
    <?php		
        }
    ?>
        </table>
    </fieldset>
<?php
	}
?>
</fieldset>
</div>

<div class="row submit">
	<?php echo CHtml::submitButton('Save', array('name'=>'save')); ?>
</div>

<?php echo CHtml::endForm(); ?>
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
</div>