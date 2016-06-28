<?php

// Data sent as a set of addresses
// Format is:
// "name","addr1","addr2","addr3","town","county","postcode","title","surname","firstname"


$this->widget('application.extensions.EExcelView', array(
	'dataProvider'=>$contacts,
	'grid_mode'=>'export',
	'filename'=>'exportemail',
	'columns' => array(
	
					array(
					 'name'=>'name',
					 'value'=>'$data->name',
					 ),
					 
					array(
						'name'=>'email_address',
						'value'=>'$data->email_address',
					),
					'newsletter_signup',

			),
));

?>