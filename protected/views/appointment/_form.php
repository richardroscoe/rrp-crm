<?php
return array(
    'elements'=>array(
		
		'<div class="leftcol">',
        'appointment'=>array(			
            'type'=>'form',
            'title'=>'Appointment',
            'elements'=>array(
			
				'apt_date'=>array(
                    'type'=>'text',
                ),
				
				'duration'=>array(
                    'type'=>'text',
                ),
				
				'type'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('AppointmentType'),
					'prompt'=>'Please select:',
                ),
				
				'state'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('AppointmentState'),
					'prompt'=>'Please select:',
                ),							
			
				'description'=>array(
                    'type'=>'text',
                ),
				
				'confirmation_sent'=>array(
                    'type'=>'text',
                ),
								
				'reminder_date'=>array(
                    'type'=>'text',
                ),
				
				'reminder_spec'=>array(
                    'type'=>'text',
                ),
				
				'reminder_sent'=>array(
                    'type'=>'text',
                ),
				
				'notes'=>array(
                    'type'=>'textarea',
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
    ),

);
?>