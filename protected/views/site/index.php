<?php
//echo "Date: ".date('Y-m-d H:i:s')."<br>";
	if (isset($birthdayToday) && $birthdayToday->getTotalItemCount() > 0) {
		echo '<h4>Today\'s Birthdays</h4>';
		$this->renderPartial('//contact/_summary', array('contacts'=>$birthdayToday));
	} /* else
		echo '<p>No birthdays today</p>';*/
	
	if (isset($dueAppointments) && $dueAppointments->getTotalItemCount() > 0) {
		echo '<h4>Next 7 days appointments</h4>';
		$this->renderPartial('//appointment/_summary', array('appointments'=>$dueAppointments));
	} else
		echo '<p>No appointments in the next 7 days</p>';
		
	if (isset($nextAppts) && $nextAppts->getTotalItemCount() > 0) {
		echo '<h4>Next appointments</h4>';
		$this->renderPartial('//appointment/_summary', array('appointments'=>$nextAppts));
	} else
		echo '<p>No appointments in the future</p>';		

	if (isset($overDueAppointments) && $overDueAppointments->getTotalItemCount() > 0) {
		echo '<h4>Overdue appointments</h4>';
		$this->renderPartial('//appointment/_summary', array('appointments'=>$overDueAppointments));
	} else
		echo '<p>No Overdue appointments</p>';

	if (isset($dueTasks) && $dueTasks->getTotalItemCount() > 0) {
		echo '<h4>Next 7 days tasks</h4>';
		$this->renderPartial('//task/_summary', array('tasks'=>$dueTasks));
	} else
		echo '<p>No tasks in the next 7 days</p>';

	if (isset($overDueTasks) && $overDueTasks->getTotalItemCount() > 0) {
		echo '<h4>Overdue tasks</h4>';
		$this->renderPartial('//task/_summary', array('tasks'=>$overDueTasks));
	} else
		echo '<p>No Overdue tasks</p>';
		
	if (isset($birthdaySoon) && $birthdaySoon->getTotalItemCount() > 0) {
		echo '<h4>Upcoming Birthdays</h4>';
		$this->renderPartial('//contact/_summary', array('contacts'=>$birthdaySoon));
	} /*else
		echo '<p>No birthdays soon</p>';*/		
?>