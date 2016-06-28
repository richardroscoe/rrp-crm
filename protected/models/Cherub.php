<?php

/**
 * This is the model class for table "cherub".
 *
 * The followings are the available columns in table 'cherub':
 * @property integer $id
 * @property string $date_upload_data
 * @property string $lead_type
 */
class Cherub extends CActiveRecord
{
	private $_all_leads = NULL; // Excluding ignored ones
	private $_active_leads = array(); // Leads with a DUE appointment
	private $_warm_leads = array(); // Leads to send letters to

	
	public function loadLeads()
	{
//		echo "<p>ID = $this->id</p>";
		
		$criteria=new CDbCriteria;
		$criteria->condition='lead_date=:lead_date AND lead_type=:lead_type AND lead_ignore = 0';
		$criteria->params=array(':lead_date'=>$this->date_upload_data, ':lead_type'=>$this->lead_type);
		
		$this->_all_leads = Address::model()->with('appointments')->findAll($criteria);

//echo "<p>ALL LEADS</p>";
//echo "<pre>"; print_r($this->_all_leads); echo "</pre>";		
//echo "<p>END -ALL LEADS</p>";
	
		// Next process all the leads, anc check if they have a due appointment, add them to the appropriate list.
		
		foreach ($this->_all_leads as $i => $lead) {
//			echo "<p>LEAD $i</p>";
//			echo "<pre>"; print_r($lead); echo "</pre>";
//			echo "<p>Lead Address Id $lead->id</p>";
			
			$due = FALSE;
			
			foreach ($lead->appointments as $appt) {
				if ($appt->state == 'DUE') {
					$due = TRUE;
					break;
				}
			}
			
			if ($due) {
				$this->_active_leads[] = $lead;
//				echo "<p>Lead Address Id $lead->id DUE</p>";
			} else {
				$this->_warm_leads[] = $lead;
//				echo "<p>Lead Address Id $lead->id WARM</p>";
			}
		}				
	}

	public function getActiveLeads()
	{
		return $this->_active_leads;
	}
	
	public function getWarmLeads()
	{
		return $this->_warm_leads;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Cherub the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cherub';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_upload_data, lead_type', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, date_upload_data', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'date_upload_data' => 'Date Upload Data',
			'lead_type' => 'Lead Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	// Return a list of WMG contacts with a specified age
	//
	// So specify older than $minWeeks old, younger than $maxWeeks
	//
	public static function leadsByAge($minWeeks=14, $maxWeeks=18, $days = 14)
	{
//		$result = self::model()->findAll(array(
//					'condition'=>'DAYOFYEAR( curdate( ) ) <= DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) )
//AND DAYOFYEAR( curdate( ) ) + :days >= DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) )',
//					'order'=>'name ASC',
//					'params'=>array(':days'=>$days),
//					));
		$result = new CActiveDataProvider('Contact', array(
			'criteria'=>array(
				'condition'=>'DAYOFYEAR( curdate( ) ) <= DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) )
AND DAYOFYEAR( curdate( ) ) + :days >= DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) ) AND address.lead_ignore = 0',
				'order'=>'dob ASC',
				'params'=>array(':days'=>$days),
				'join'=>'JOIN `address` ON `address_id` = `address`.`id`'
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));					
		return $result;		
	}		
	
	
	/*
	    a) Booked - contacts that have a due appoinment for a WMG1, not ignored      
    
    b) Letter 1 Leads - those that are in the target age range, that don't have a WMG1 appoinment and haven't yet been contacted recently    
    	target age: 13-16 weeks
        contacted recently: last_contact > 1 month ago
        not ignored
        
    c) Letter 2 Leads - those that are in the target age range, that have been contacted recently and don't have a WMG1 appointment.
    	target age: 13-16 weeks
        contacted recently: last_contact > 2 weeks ago and last_contact < 3 month ago
        not ignored
        
    d) Young - those leads that are too young
    	age < 13 weeks
        not ignored
		
		*/
		
	public function leadsWMGBooked()
	{
		$criteria=new CDbCriteria;
		$criteria->condition='lead_ignore = 0 AND
						      `shoots`.type = :shoot_type AND
							  `appointments`.type = :appointment_type AND
							  `appointments`.state = :appointment_state AND
							  `appointments`.owner_type_id = "SHOOT" AND
							  `appointments`.owner_id = `shoots`.id';
							  
		$criteria->params=array(':shoot_type' => 'CH1', ':appointment_type'=>'SHOOT', 'appointment_state'=>'DUE');
		
		$booked = Address::model()->with('shoots', 'appointments')->findAll($criteria);	
		return $booked;
	}

//echo "<pre>"; print_r($booked); echo "</pre>";
	/*
	    b) Letter 1 Leads - those that are in the target age range, that don't have a WMG1 appoinment and haven't yet been contacted recently    
    	target age: 13-16 weeks
        contacted recently: last_contact > 1 month ago
        not ignored							  	
	*/
	public function leadsWMGLetter1($minWeeks = 8, $maxWeeks = 14)
	{
		$criteria=new CDbCriteria;
		$criteria->condition='lead_ignore = 0 AND
							  (last_contact IS NULL OR DATEDIFF(DATE_SUB(curdate(), INTERVAL :rec WEEK), last_contact ) > 0)  AND
							  `members`.dob IS NOT NULL AND
							  DATEDIFF(DATE_SUB(NOW(), INTERVAL :minWeeks WEEK), `members`.dob) > 0 AND
							  DATEDIFF(DATE_SUB(NOW(), INTERVAL :maxWeeks WEEK), `members`.dob) <= 0  
						      ';
							  
		$criteria->params=array(':rec'=>(int)4, ':minWeeks'=>$minWeeks, ':maxWeeks'=>$maxWeeks);
		$criteria->order='`members`.dob ASC';
		
		$possLeads = Address::model()->with(/*'shoots',*/ 'appointments', 'members')->findAll($criteria);
		$letter1 = array();
		
		// Now need to sort through these to remove any with appointments
		foreach ($possLeads as $i => $lead) {
			$due = FALSE;
			
			foreach ($lead->appointments as $appt) {
				if ($appt->state == 'DUE' && $appt->type == 'SHOOT') {
					$due = TRUE;
					break;
				}
			}
			if (!$due)
				$letter1[] = $lead;			
		}
		
		return $letter1;		
	}
/*
    c) Letter 2 Leads - those that are in the target age range, that have been contacted recently and don't have a WMG1 appointment.
    	target age: 13-16 weeks
        contacted recently: last_contact > 2 weeks ago and last_contact < 3 month ago
        not ignored
		
		
*/	
	public function leadsWMGLetter2($minWeeks = 4, $maxWeeks = 16, $letter1Weeks = 2)
	{
		$criteria=new CDbCriteria;
		$criteria->condition='lead_ignore = 0 AND
							  
							  last_contact IS NOT NULL AND
							  DATEDIFF(DATE_SUB(NOW(), INTERVAL :letter1Weeks WEEK), last_contact ) > 0  AND
							  DATEDIFF(DATE_SUB(NOW(), INTERVAL 3 MONTH), last_contact ) <= 0  AND
							  
							  `members`.dob IS NOT NULL AND
							  DATEDIFF(DATE_SUB(NOW(), INTERVAL :minWeeks WEEK), `members`.dob) > 0 AND
							  DATEDIFF(DATE_SUB(NOW(), INTERVAL :maxWeeks WEEK), `members`.dob) <= 0  
						      ';
							  
		$criteria->params=array(':letter1Weeks'=>$letter1Weeks, ':minWeeks'=>$minWeeks, ':maxWeeks'=>$maxWeeks);
		$criteria->order='`members`.dob ASC';
		
		$possLeads = Address::model()->with(/*'shoots',*/ 'appointments', 'members')->findAll($criteria);
		$letter2 = array();
		
		// Now need to sort through these to remove any with appointments
		foreach ($possLeads as $i => $lead) {
			$due = FALSE;
			
			foreach ($lead->appointments as $appt) {
				if ($appt->state == 'DUE' && $appt->type == 'SHOOT') {
					$due = TRUE;
					break;
				}
			}
			if (!$due)
				$letter2[] = $lead;			
		}
		
		return $letter2;		
	}
	
	public function leadsWMGYoung($maxWeeks = 8)
	{
		return Cherub::model()->leadsWMGLetter1(0, $maxWeeks);	
	}
	
	public function leadsWMGOld($minWeeks = 16)
	{
	}
	
	public function setExportDate($leads)
	{
		foreach ($leads as $i => $lead) {
				$lead->last_contact = new CDbExpression('NOW()');
//				if ($lead->validate())
					$lead->save();
		}
	}
	
}