<?php
class Enum
{
	static $ContactRole = array(
		'CHILD' => 'Child',
		'PARENT' => 'Parent',
		'GRANDPARENT' => 'Grandparent',
		'SIBLING' => 'Sibling', // The primary_contact's brother or sister
	);
	
	static $ContactSex = array(
			'MALE' => 'Male',
			'FEMALE' => 'Female',
	);
	
	static $ContactMethod = array(
			'EMAIL' => 'Email',
			'TEXT' => 'Text Msg',
			'PHONE' => 'Phone call',
	);
	
	static $AddressLeadType = array(
			'PP'		=> 'Pregnancy Pilates',
			'WP'		=> 'Pre-crawl Pilates',
			'FP'		=> 'Family Pilates',
			'REF' 		=> 'Referral',
			'FAIR' 		=> 'Fair',
			'WEB' 		=> 'Web Enquiry',
			'CHERUB_M' 	=> 'Cherub Watch Me Grow',
			'CHERUB_H' 	=> 'Cherub Hot',
			'CHERUB_P'  => 'Cherub Pre-natal',
			'CHERUB_F'  => 'Cherub Family & Me',
			'EMAIL' 	=> 'Email',
			'NEWSLETTER' => 'News Letter',
			'OTHER' 	=> 'Other',
			'CHERUB_O'	=> 'Cherub Other',
			'INTERNET' 	=> 'Internet',
			'GIFT'		=> 'Gift Voucher Rec',
			'FB'		=> 'Facebook',
	);
	static $CherubLeadType = array(
			'CHERUB_P'  => 'Cherub Pre-natal (1)',
			'CHERUB_M' 	=> 'Cherub Watch Me Grow (2)',
			'CHERUB_F'  => 'Cherub Family & Me (3)',	
	);
	static $Month = array(
			'1' => 'January',
			'2' => 'February',
			'3' => 'March',
			'4' => 'April',
			'5' => 'May',
			'6' => 'June',
			'7' => 'July',
			'8' => 'August',
			'9' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
    );
	
	static $Year = array(
			'2014'=>'2014',
			'2015'=>'2015',
//			'2016'=>'2016',
//			'2017'=>'2017',			
	);
	
	static $ShootLocationType = array(
			'STUDIO' => 'Studio',									  
			'LOC' => 'Location',
			'TBC' => 'To Be Confirmed',
			'FAM' => 'Family Home',		
	);
	static $ShootType = array(
			'CH1' => 'Cherub WMG 1',
			'CH2' => 'Cherub WMG 2',
			'CH3' => 'Cherub WMG 3',
			'CHB2B1' => 'Cherub B2B 1',
			'CHB2B2' => 'Cherub B2B 2',
			'CHFAM' => 'Cherub Family',
			'BFY1' => 'BFY 1',
			'BFY2' => 'BFY 2',
			'BFY3' => 'BFY 3',
			'BFY4' => 'BFY 4',
			'BABY' => 'Baby',
			'FAM' => 'Family',
			'COMM' => 'Commercial',
			'HEAD' => 'Commercial Head',
			'MHEAD' => 'Model/Music Head',
			'PASSPORT'=>'Passport',
			'MATERNITY' => 'Maternity',
			'NEWBORN' => 'Newborn',
			'CHILD' => 'Children',
			'COUPLE' => 'Couple',
			'OTHER' => 'Other',
	);
	static $YesNo = array(
			'0' => 'No',
			'1' => 'Yes',
	);
	static $AppointmentState = array(
			'TBC' => 'To be Confirmed',
			'DUE' => 'Due',
			'COMP' => 'Completed',
			'NOSHOW' => 'No Show/Cancelled',
			'MISSED' => 'Missed',
	);
	static $AppointmentType = array(
			'CONS' => 'Pre-Booking Consultation',
			'SHOOT' => 'Shoot',
			'VIEW' => 'Viewing',
			'CLOTHING' => 'Clothing/Home Consultation',
			'COLLECT' => 'Order Collection',
	);
	static $TaskType = array(
			'tbd' => '',
			'SMS' => 'Text Reminder', // Send an SMS to the primary contact to remind them
	);
	static $TaskState = array(
			'NOTSTART' => 'Not Started',
			'INPROG' => 'In progress',
			'DONE' => 'Completed',
			'CANCEL' => 'Cancelled',
	);
	static $LetterType = array(
			'REMINDER' => 'Reminder',
			'THANKYOU' => 'Thank you',
			'REFERRAL' => 'Referral Request',
			'MISSED' => 'Missed appointment',
			'CONFIRMATION' => 'Appointment Confirmation',
			'BDAY' => 'Birthday Invitation',
	);
	static $LetterMedia = array(
			'EMAIL' => 'Email',
			'TXT' => 'Text Message',
	);
	
	public function getList($list)
	{
		return self::$$list;
	}
	
	public static function getLabel($list, $index)
	{
		if (strlen(trim($index)) == 0)
			return '';
		$a = self::$$list;
		return $a[$index];
	}
	
}
?>