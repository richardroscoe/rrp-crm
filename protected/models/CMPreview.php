<?php
/**
 * CMSource class.
 * CMSource is the data structure for keeping
 * Cherub Monthly Sourceform data.
 */
class CMPreview extends CFormModel
{
	public $name;
	public $addr1;
	public $addr2;
	public $addr3;
	public $town;
	public $county;
	public $postcode;
	public $title;
	public $surname;
	public $firstname;
	public $sex;	// If no sex is supplied, then the following baby_dob, is a due date
	public $baby_dob;	
	public $lead_ignore=false;
	public $lead_date;
	public $lead_type;
	public $import=true;
	public $duplicate=NULL;
	public $update=false;

	private static $map = array(
	 'name',
	 'addr1',
	 'addr2',
	 'addr3',
	 'town',
	 'county',
	 'postcode',
	 'title',
	 'surname',
	 'firstname',
	 'sex',
	 'baby_dob',
	 );
	 
	/*
	 * 
	 */
	public function setFieldValue($col, $value)
	{
		$field = self::$map[$col]; // Map the column to our model
		
		if ($field == "firstname")
			$value = ucfirst(strtolower($value));
			
		if ($field == "baby_dob") {
			
			if (strlen($value) == 0) {
				$value = NULL;
			} else if (strlen($value) < 10) {
				// Check if any slashes
				if (!strrchr($value, '/')) {
					// No slashes, so ensure leading zeros and reformat
					$value = '0'.$value;
					$value = substr($value, -8);
					
					$day = substr($value, 0, 2);
					$month = substr($value, 2, 2);
					$year = substr($value, -4);
					
					$value = $year.'-'.$month.'-'.$day;
	
				} else {
					//$value = "bad date";
					$value = NULL;
				}
			} else {
				// Assume in standard format dd/mm/yyyy
				$day = substr($value, 0, 2);
				$month = substr($value, 3, 2);
				$year = substr($value, -4);
				
				$value = $year.'-'.$month.'-'.$day;
			}
		}
			
		// Set the value in out model
		$this->$field = $value;
	}
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('name,addr1,addr2,addr3,town,county,postcode,title,surname,firstname,lead_ignore,lead_date, lead_type, sex, baby_dob, import', 'required'),
		);
	}

}
?>