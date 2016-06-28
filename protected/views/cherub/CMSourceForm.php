<?php
// The form
return array(
		
    'title'=>'Import Cherubs WMG Data',
 
    'elements'=>array(
        'filename'=>array(
            'type'=>'file',
        ),
        'month'=>array(
			'type'=>'dropdownlist',
		    'items'=> Enum::getList('Month'),
		    'prompt'=>'Please select:',
        ),
        'year'=>array(
			'type'=>'dropdownlist',
		    'items'=> Enum::getList('Year'),
		    'prompt'=>'Please select:',
        ),
		'lead_type'=>array(
			'type'=>'dropdownlist',
		    'items'=> Enum::getList('CherubLeadType'),
		    'prompt'=>'Please select:',		
		),
    ),
	
    'buttons'=>array(	
        'preview'=>array(
            'type'=>'submit',
            'label'=>'Preview',
        ),
		'cancel'=>array(
			'type'=>'submit',
			'label'=>'Cancel'
		),
    ),
	
	'attributes'=>array(
		'enctype'=>'multipart/form-data',
	),

);
?>