<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>

<?php
$this->breadcrumbs=array(
	'Contact'=>array('/contact'),
	ucfirst($this->action->id),
);?>
<h1><?php echo "View contact - ". $this->id . '/' . $this->action->id; ?></h1>

<?php
//
// Display a list item if it's not null or zero length
//
function listItem($value, $label = NULL, $makeUrl = NULL)
{
	if ($value == NULL || strlen($value) == 0)
		return NULL;
	
	if ($label)
		$value = $label.$value;
			
	$out = "<li>";
	if ($makeUrl)
		$out .= CHtml::link($value, $makeUrl);
	else
		$out .= $value;
	$out .= "</li>";
	
	return $out;
}
?>
<div class="wide form">

    <div class="leftcol">
        <div class="" id="Contacts">
        <fieldset>
        <legend>Family Members</legend>
        <ul>
        <?php
            foreach ($members as $i => $member) {
        ?>
            <li>
                <?php echo CHtml::link($member->name, array('contact/update', 'id'=>$member->id)); ?>
                <ul>
                    <li>
                    <?php
                        echo Enum::getLabel('ContactSex', $member->sex);
                        if ($member->role)
                            echo ', '.Enum::getLabel('ContactRole', $member->role);
						if ($member->primary_contact)
                            echo ', Primary Contact';
						if ($member->wmg_cherub)
							echo ', WMG Cherub';
                    ?>
                    </li>
                    <?php
                        echo listItem($member->mobile_phone, 'Mobile: ');
						if ($member->primary_contact && strlen($member->mobile_phone) == 0)
							echo listItem("<b class='crmwarn'>Unknown</b>", 'Mobile: ');
                        echo listItem($member->email_address, 'Email: ', "mailto:$member->email_address");
                        echo listItem($member->dob, 'Dob: ');
						echo listItem($member->due_date, 'Due Date: ');
						echo listItem($member->notes);
                    ?>				
                </ul>
            </li>
        <?php		
            }
        ?>
        </ul>
		<?php
			echo CHtml::link('Add Family Member', array('contact/update', 'address_id'=>$address->id));
		?>
        </fieldset>
        </div>
    </div>

    <div class="rightcol">
        <div class="" id="Address">
        <fieldset>
        <legend>Address</legend>
			<?php
				if ($address->company_name) :
			?>
            	<p><?php echo $address->company_name; ?></p>
           	<?php
				 endif;
			?>
            <address>
            <?php
                $addrElements = array(	'addr1',
										'addr2',
										'addr3',
										'town',
										'county',
										'postcode',
										);
				$first = 1;
				
				foreach ($addrElements as $el) {
					if ($address->$el != NULL && strlen(trim($address->$el)) > 0) {
						
						if ($first)
							$first = 0;
						else
							echo '<br>';

						echo $address->$el;						
					}
				}
			?>
            </address>

			<p>Landline: <?php echo $address->landline; ?><br />
            Lead Type: <?php echo Enum::getLabel('AddressLeadType', $address->lead_type); ?><br />
            Lead Date: <?php echo $address->lead_date; ?><br />
            Last Contact Date: <?php echo $address->last_contact; ?>&nbsp;<?php echo CHtml::link('Now', array('contact/contacted', 'id'=>$contact->id)); ?>
            <?php if ($address->lead_ignore) { ?>
            <br />
            <strong>Ignore this lead</strong><br />
            <?php } ?>
            
          </p>
            <p>
			<?php echo CHtml::link('Edit', array('contact/update', 'id'=>$contact->id)); ?>
            &nbsp;
            <?php echo CHtml::link('CDE', array('cherub/cde', 'address_id'=>$address->id)); ?>
            </p>   
        </fieldset>
        </div>
    </div>
    
    <div class="clear"></div>

    <div class="" id="Shoots">
    <fieldset>
    <legend>Shoots</legend>
    <?php
        echo CHtml::link('Add New Shoot', array('shoot/update', 'address_id'=>$address->id));
		echo "<br />";echo "<br />";
		foreach ($shoots as $shoot) {
			echo "<ul>";
			$this->renderPartial('//shoot/_view', array('shoot'=>$shoot,'contact'=>$contact,/*'address'=>$address*/));
			echo "</ul>";
		}
	?>
    </fieldset>
    </div>

</div>

<script type="text/javascript">
$(document).ready(function () {
    //Convert address tags to google map links - Copyright Michael Jasper 2011
    $('address').each(function () {
		var addr = $(this).html();
        var link = "<a href='http://maps.google.com/maps?q=" + encodeURIComponent( $(this).html().replace(/<br>/g, ', ').trim() ) + "' target='_blank'>" + "(map)" + "</a>";
        $(this).html(addr + link);
		
    });
});
</script>