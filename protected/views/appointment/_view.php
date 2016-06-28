<li class="<?php if ($appointment->state == 'DUE' || $appointment->state == 'TBC') echo 'itemHighLight'; ?>">
<?php
	
	echo CHtml::link(Enum::getLabel("AppointmentType",$appointment->type),
						array("appointment/update", "id"=>$appointment->id));
	echo ", ";
	echo CrmHelper::dateTimeOutput($appointment->apt_date);
	echo ", ";
	echo Enum::getLabel("AppointmentState",$appointment->state);

	if ($appointment->notes)
		echo "<br />Notes: $appointment->notes";
?>
</li>
