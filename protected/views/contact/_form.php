<?php
return array(
    'elements'=>array(
		
		'<div class="leftcol">',
        'contact'=>array(			
            'type'=>'form',
            'title'=>'Contact information',
            'elements'=>array(
				'title'=>array(
                    'type'=>'text',
                ),
                'firstname'=>array(
                    'type'=>'text',
                ),
				'surname'=>array(
                    'type'=>'text',
                ),
                'email_address'=>array(
                    'type'=>'text',
                ),
				'mobile_phone'=>array(
                    'type'=>'text',
                ),
				'sex'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('ContactSex'),
					'prompt'=>'Please select:',
                ),
				'role'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('ContactRole'),
					'prompt'=>'Please select:',
                ),
				'dob'=>array(
                    'type'=>'text',
                ),
				'wmg_cherub'=>array(
                    'type'=>'checkbox',
                ),
				'newsletter_signup'=>array(
                    'type'=>'checkbox',
                ),
				'primary_contact'=>array(
                    'type'=>'checkbox',
                ),
				'pref_contact_method'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('ContactMethod'),
					'prompt'=>'Please select:',
                ),
				'due_date'=>array(
                    'type'=>'text',
                ),
				'notes'=>array(
                    'type'=>'textarea',
                ),
            ),
			
        ),
		'</div>',
		
		'<div class="rightcol">',
        'address'=>array(
            'type'=>'form',
            'title'=>'Address information',
            'elements'=>array(
						  
                'company_name'=>array(
                    'type'=>'text',
                ),
				'addr1'=>array(
                    'type'=>'text',
                ),
                'addr2'=>array(
                    'type'=>'text',
                ),
                'addr3'=>array(
                    'type'=>'text',
                ),
				'town'=>array(
                    'type'=>'text',
                ),
				'county'=>array(
                    'type'=>'text',
                ),
				'postcode'=>array(
                    'type'=>'text',
                ),
				'landline'=>array(
                    'type'=>'text',
                ),
				'lead_type'=>array(
					'type'=>'dropdownlist',
					'items'=> Enum::getList('AddressLeadType'),
					'prompt'=>'Please select:',
                ),
				'lead_date'=>array(
                    'type'=>'text',
                ),
				'lead_ignore'=>array(
                    'type'=>'checkbox',
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