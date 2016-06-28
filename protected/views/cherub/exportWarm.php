<?php

// Data sent as a set of addresses
// Format is:
// "name","addr1","addr2","addr3","town","county","postcode","title","surname","firstname"

$this->widget('application.extensions.EExcelView', array(
	'dataProvider'=>$addresses,
	'grid_mode'=>'export',
	'filename'=>'leads'.(isset($title)? '-'.$title : ""),
	'columns' => array(
	
					array(						
						'name'=>'name',
						'value'=>array('Address', 'renderPCName'),
					),
					
					array(
						'name'=>'addr1',
						'value'=>'$data->addr1',
					),
					
					array(
						'name'=>'addr2',
						'value'=>'$data->addr2',
					),

					array(
						'name'=>'addr3',
						'value'=>'$data->addr3',
					),												

					array(
						'name'=>'town',
						'value'=>'$data->town',
					),
					
					array(
						'name'=>'county',
						'value'=>'$data->county',
					),
					
					array(
						'name'=>'postcode',
						'value'=>'$data->postcode',
					),
					
					array(
						'name'=>'title',
						'value'=>array('Address', 'renderPCTitle'),
					),
					
					array(
						'name'=>'surname',
						'value'=>array('Address', 'renderPCSurname'),
					),
					
					array(
						'name'=>'firstname',
						'value'=>array('Address', 'renderPCFirstname'),
					),	

			),
));