<li>
<?php
	// Display a shoot and it's attributes

	// id, type, location_type, location_address_id, description, address_id
	echo CHtml::link(Enum::getLabel("ShootType",$shoot->type),
						array("shoot/update", "id"=>$shoot->id));

?>
</li>

<ul>
	<li>Type: <?php echo Enum::getLabel("ShootLocationType", $shoot->location_type); ?></li>
<?php
	if ($shoot->location_address_id)
		echo "<li>Location Address: $shoot->location_address_id</li>";

	if ($shoot->description)
		echo "<li>Description: $shoot->description</li>";
	
	if ($shoot->revenue != NULL)
		echo "<li>Revenue: £$shoot->revenue</li>";
?>
	<li>Appointments</li>
<?php
		echo "<ul>";
		foreach ($shoot->appointments(array('order'=>'apt_date DESC')) as $appointment) {

			$this->renderPartial('//appointment/_view', array('appointment'=>$appointment,'contact'=>$contact,/*'address'=>$address*/));
		}
		echo "</ul>";
?>
</ul>