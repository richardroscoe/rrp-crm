<?php
return array(
    'elements'=>array(
		
		'<div class="leftcol">',
        'shoot'=>array(			
            'type'=>'form',
            'title'=>'Shoot information',
            'elements'=>array(
			
				'type'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('ShootType'),
					'prompt'=>'Please select:',
                ),
				
				'location_type'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('ShootLocationType'),
					'prompt'=>'Please select:',
                ),
				
				'location_address_id'=>array(
                    'type'=>'text',
                ),

				'description'=>array(
                    'type'=>'text',
                ),
				
				'revenue'=>array(
                    'type'=>'text',
                ),
				'date_last_revenue'=>array(
                    'type'=>'text',
                ),
			),
        ),
	 	'</div>',

    ),
	
	'<div class="clear">&nbsp;</div>',
	
    'buttons'=>array(	
        'submit'=>array(
            'type'=>'submit',
            'label'=>'Save',
        ),
        'overview'=>array(
            'type'=>'submit',
            'label'=>'Overview',
        ),
    ),

);
?>