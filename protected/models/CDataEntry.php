<?php
/**
 * CDataEntry class.
 * CDataEntry is the data structure for the related form. 
 * It mirrors the paper Cherubs data collection forms and is used to entry historical data
 *
 */
class CDataEntry extends CFormModel
{
	public $address;
	public $contact;
	public $shoots;
	public $appointment;
	
	static $appt_type = array('0' => 'SHOOT', '1' => 'VIEW', '2' => 'COLLECT');

	public function __construct()
	{
		parent::__construct();
		$this->address = new Address;
		$this->contact['mum'] = new Contact;
		$this->contact['dad'] = new Contact;
		$this->contact['child1'] = new Contact;
		
		$this->shoots = NULL;
		$this->appointment = NULL;
	}
	
	public function load($address_id)
	{
		$result = Address::model()->findByPk($address_id);

		$shoot_count = 0;
		
		if ($result) {
			$this->address = $result;
		
			$result = Contact::model()->find('address_id=:id AND role=\'PARENT\' AND sex=\'FEMALE\'', array(':id'=>$address_id));
			if ($result)
				$this->contact['mum'] = $result;
				
			$result = Contact::model()->find('address_id=:id AND role=\'PARENT\' AND sex=\'MALE\'', array(':id'=>$address_id));
			if ($result)
				$this->contact['dad'] = $result;
//	echo "<p>dad</p><pre>"; print_r($result); echo "</pre>";				
				
			// Get the youngest child
			$result = Contact::model()->find('address_id=:id AND role=\'CHILD\' ORDER BY dob DESC', array(':id'=>$address_id));						
			if ($result)
				$this->contact['child1'] = $result;
				
			// Find shoots
			$result = Shoot::model()->findAll('address_id=:id AND type LIKE \'CH%\' ORDER BY type ASC', array(':id'=>$address_id));
			
			foreach ($result as $i => $r) {
				$this->shoots[$i] = $r; 
				$shoot_count++;
			}
	//echo "<p>shoots</p><pre>"; print_r($this->shoots); echo "</pre>";				
			
			if ($shoot_count > 0) {	
				foreach ($this->shoots as $s => $shoot) {
					$result = Appointment::model()->findAll('address_id=:id AND owner_type_id=\'SHOOT\' AND owner_id=:sid ORDER BY apt_date ASC', array(':id'=>$address_id,':sid'=>$shoot->id));
		//				echo "<p>Appointments result</p><pre>"; print_r($result); echo "</pre>";	
		
					$appt_count = 0;
					foreach ($result as $i => $r) {
						$this->appointment[$s][$i] = $r; 
						$appt_count++;
		//					echo "<p>Appointments result [$s][$i]</p><pre>"; print_r($r); echo "</pre>";
					}
					
					// Create an needed extra appointment records for the form
					$new_appts = 3 - $appt_count;
					if ($new_appts < 1)
						$new_appts = 1;
						
					for ($a = $appt_count; $a < $appt_count + $new_appts; $a++) {
						$this->appointment[$s][$a] = new Appointment;
						$this->appointment[$s][$a]->type = ($a <=2) ? self::$appt_type[$a] : NULL;
					}	
				}
			}
		}
		
		// Create an needed extra shoot records for the form
		$new_shoots = 3 - $shoot_count;
		if ($new_shoots < 1)
			$new_shoots = 1;
				
		for ($s = $shoot_count; $s < $shoot_count + $new_shoots; $s++) {
			$this->shoots[$s] = new Shoot;
			
			// Brand new shoots have 3 appointments presented
			for ($a = 0; $a < 3 ; $a++) {
				$this->appointment[$s][$a] = new Appointment;
				$this->appointment[$s][$a]->type = self::$appt_type[$a];
			}
		}
//			echo "<p>Appointments result</p><pre>"; print_r($this->appointment); echo "</pre>";	
	}
	
	public function save()
	{
		// See what we have got and what needs to be done
		
		//Shouldn't need to play with Address
//		echo "<p>Save the address</p>";
		$this->address->save(false);
		
		//Shouldn't need to play with Contact['mum']
//		echo "<p>Save Mum</p>";
		$this->contact['mum']->save(false);
		
		// Dad
//echo "<p>contact dad</p><pre>"; print_r($this->contact['dad']); echo "</pre>";
		
		$this->contact['dad']->firstname = trim($this->contact['dad']->firstname);
		if (strlen($this->contact['dad']->firstname) > 0 || strlen($this->contact['dad']->surname) > 0 || $this->contact['dad']->id) {
//			echo "<p>DAD here</p>";
			
			if (!$this->contact['dad']->id) {
//				echo "<p>Create DAD (isNew =".($this->contact['dad']->getIsNewRecord() ? 'YES' : 'FALSE').")</p>";
				$this->contact['dad']->address_id = $this->address->id;
				// set other fields
				$this->contact['dad']->sex = 'MALE';
				$this->contact['dad']->role = 'PARENT';
			}
//			echo "<p>DAD</p><pre>";print_r($this->contact['dad']);echo "</pre>";
			if ($this->contact['dad']->save(false)) {
//				echo "<p>Save Okay!</p>";
			} else {
				echo "<p>Errors</p>";
			}
			
//			echo "<p>DAD id = ".$this->contact['dad']->id."</p>";
		}
		
		$this->contact['child1']->firstname = trim($this->contact['child1']->firstname);
		if (strlen($this->contact['child1']->firstname) > 0 || strlen($this->contact['child1']->surname) > 0 || $this->contact['child1']->id) {
//			echo "<p>Save child1</p><pre>";print_r($this->contact['child1']);echo "</pre>";
			
			if (!$this->contact['child1']->id) {
				$this->contact['child1']->address_id = $this->address->id;
				$this->contact['child1']->role = 'CHILD';
				$this->contact['child1']->wmg_cherub = 1;
			}
			$this->contact['child1']->save(false);
		}
		
		// If we have appointments for a shoot, save or create an associated shoot database object ... save associcated appointments ...
		
		foreach ($this->shoots as $i => $shoot) {
			
//			echo "<p>shoot id = $shoot->id</p>";

			$shoot_saved = 0;
						
			// if we have appointments, create/update/save them
			foreach ($this->appointment[$i] as $ai => $appt) {
				
				$appt->apt_date = trim($appt->apt_date);
				$appt->notes = trim($appt->notes);
				
				if ($appt->id > 0) {
					$appt->save(false);
				} elseif (strlen($appt->apt_date) + strlen($appt->notes) > 0) {
					// A new appointment record
					if (!$shoot->id) {
						if (!$shoot->type)
							$shoot->type = 'CH'.($i + 1);
						$shoot->location_type = 'STUDIO';
						//$shoot->description = 'Cherub '.($i + 1);
						$shoot->address_id = $this->address->id;
						$shoot->save(false);	
						$shoot_saved = 1;
					}
					$appt->address_id = $this->address->id;
					$appt->owner_type_id = 'SHOOT';
					$appt->owner_id = $shoot->id;
				
					$appt->save(false);
//					echo "<p>Have appt [$i] [$ai], id = $appt->id</p>";
					
//					echo "<p>shoot</p><pre>"; print_r($shoot); echo "</pre>";
				}
			}
			
			if (!$shoot_saved && $shoot->id)
				$shoot->save(false);
		}
	}
	
	public function getAttributes($attrs)
	{
//		echo "<p>attrs</p><pre>"; print_r($attrs); echo "</pre>";

					
		$this->address->attributes = $attrs['Address'];
		
//echo "<p>this->address</p><pre>"; print_r($this->address); echo "</pre>";
		
		foreach ($attrs['Contact'] as $k => $v)
			$this->contact[$k]->attributes = $v;
	

//echo "<p>this->contact</p><pre>"; print_r($this->contact); echo "</pre>";
		
		foreach ($attrs['Shoot'] as $k => $v)
			$this->shoots[$k]->attributes = $v;
		
//echo "<p>getAttributes - this->shoots</p><pre>"; print_r($this->shoots); echo "</pre>";		
		
		foreach ($attrs['Appointment'] as $k => $v) {
			foreach ($v as $i => $j) {
				$this->appointment[$k][$i]->attributes = $j;
			}
		}
//		echo "<p>this</p><pre>"; print_r($this); echo "</pre>";
	}
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('addr1', 'required'),
		);
	}
	
		/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'address_id' => 'ID',
			'company_name' => 'Company Name',
			'addr1' => 'Address Line1',
			'addr2' => 'Address Line2',
			'addr3' => 'Address Line3',
			'town' => 'Town',
			'county' => 'County',
			'postcode' => 'Postcode',
			'landline' => 'Landline',
			'primary_contact_id' => 'Primary Contact',
			'date_added' => 'Date Added',
			'lead_type' => 'Lead Type',
			'lead_date' => 'Lead Date',
			// Mum
			'mum_id' => 'ID',
			'mum_sex' => 'Sex',
			'mum_role' => 'Role',
			'mum_title' => 'Title',
			'mum_fname' => 'First Name',
			'mum_lname' => 'Last Name',
			'mum_name' => 'Name',
			'mum_address_id' => 'Address',
			'mum_dob' => 'Date of Birth',
			'mum_email_address' => 'Email Address',
			'mum_newsletter_signup' => 'Newsletter Signup',
			'mum_primary_contact' => 'Primary Contact',
			'mum_mobile_phone' => 'Mobile Phone',
			'mum_due_date' => 'Due Date',
			'mum_notes' => 'Notes',
			//Dad
			'dad_id' => 'ID',
			'dad_sex' => 'Sex',
			'dad_role' => 'Role',
			'dad_title' => 'Title',
			'dad_fname' => 'First Name',
			'dad_lname' => 'Last Name',
			'dad_name' => 'Name',
			'dad_address_id' => 'Address',
			'dad_dob' => 'Date of Birth',
			'dad_email_address' => 'Email Address',
			'dad_newsletter_signup' => 'Newsletter Signup',
			'dad_primary_contact' => 'Primary Contact',
			'dad_mobile_phone' => 'Mobile Phone',
			'dad_notes' => 'Notes',
			//Child1
			'child1_id' => 'ID',
			'child1_sex' => 'Sex',
			'child1_role' => 'Role',
			'child1_title' => 'Title',
			'child1_fname' => 'First Name',
			'child1_lname' => 'Last Name',
			'child1_name' => 'Name',
			'child1_address_id' => 'Address',
			'child1_dob' => 'Date of Birth',
			'child1_wmg_cherub' => 'WMG Cherub',
			'child1_email_address' => 'Email Address',
			'child1_newsletter_signup' => 'Newsletter Signup',
			'child1_primary_contact' => 'Primary Contact',
			'child1_mobile_phone' => 'Mobile Phone',
			'child1_notes' => 'Notes',			
		);
	}
}
?>