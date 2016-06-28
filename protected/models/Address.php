<?php

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $id
 * @property string $company_name
 * @property string $addr_line1
 * @property string $addr_line2
 * @property string $addr_line3
 * @property string $town
 * @property string $county
 * @property string $postcode
 * @property string $landline
 * @property integer $primary_contact_id
 * @property string $date_added
 * @property string $lead_type
 * @property string $lead_date
 * @property string $last_contact 
 *
 * The followings are the available model relations:
 * @property Contact[] $contacts
 */
class Address extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Address the static model class
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
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('primary_contact_id, lead_ignore', 'numerical', 'integerOnly'=>true),
			array('company_name', 'length', 'max'=>128),
			array('addr1, addr2, addr3, town, county', 'length', 'max'=>64),
			array('postcode, lead_type', 'length', 'max'=>16),
			array('landline', 'length', 'max'=>20),
			array('date_added, lead_date, last_contact', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_name, addr1, addr2, addr3, town, county, postcode, landline, primary_contact_id, date_added, lead_type, lead_date, lead_ignore', 'safe', 'on'=>'search'),
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
			'members' => array(self::HAS_MANY, 'Contact', 'address_id'), // all the people at the address
			'shoots' => array(self::HAS_MANY, 'Shoot', 'address_id'), // all the shoots for this address
			'appointments' => array(self::HAS_MANY, 'Appointment', 'address_id'), // all the appointments for this address
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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
			'lead_ignore' => 'Lead Ignore',
			'last_contact' => 'Last Contact Date',			
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
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('addr1',$this->addr_line1,true);
		$criteria->compare('addr2',$this->addr_line2,true);
		$criteria->compare('addr3',$this->addr_line3,true);
		$criteria->compare('town',$this->town,true);
		$criteria->compare('county',$this->county,true);
		$criteria->compare('postcode',$this->postcode,true);
		$criteria->compare('landline',$this->landline,true);
		$criteria->compare('primary_contact_id',$this->primary_contact_id);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('lead_type',$this->lead_type,true);
		$criteria->compare('lead_date',$this->lead_date,true);
		$criteria->compare('lead_ignore',$this->lead_ignore,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function behaviors(){
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'date_added',
				'updateAttribute' => NULL,
			)
		);
	}

	public function cherubs_update($attrs)
	{
		$this->addr1 = $attrs['addr1'];
		$this->addr2 = $attrs['addr2'];
		$this->addr3 = $attrs['addr3'];
		$this->town = $attrs['town'];
		$this->county = $attrs['county'];
		$this->postcode = $attrs['postcode'];
		$this->lead_type = $attrs['lead_type'];
		$this->lead_date = $attrs['lead_date'];
		$this->lead_ignore = $attrs['lead_ignore'];
	}
	
	public function save_cherub_monthly($validate = false)
	{
//		$this->lead_type = 'CHERUB_M';
		return self::save($validate);	
	}
	
	public function beforeSave()
	{
		if (parent::beforeSave()) {
			
			if ($this->lead_date == '' || strcmp($this->lead_date, '0000-00-00') == 0)
				$this->lead_date = NULL;

			if ($this->last_contact == '' || strcmp($this->last_contact, '0000-00-00') == 0)
				$this->last_contact = NULL;
								
			if (strlen($this->landline) > 0)
				$this->landline = CrmHelper::formatPhone($this->landline);
		}
		return true;
	}

	// Callled when we send marketing info to our contact	
	public function contactedNow()
	{
		$this->last_contact = new CDbExpression('NOW()');
		$this->save();
	}
	
	// Render an addresses primary contact
	public function renderPrimaryContact($data, $row = NULL)
	{	
		$result = Contact::getPrimaryContact($data->id);	
		if ($result)
			return $result->name;
		else
			return "&nbsp;";
	}
	
	public function renderPCName($data, $row = NULL)
	{	
		return Address::renderPrimaryContact($data, $row);
	}	
	public function renderPCTitle($data, $row = NULL)
	{	
		$result = Contact::getPrimaryContact($data->id);	
		if ($result)
			return $result->title;
		else
			return "&nbsp;";
	}
	public function renderPCSurname($data, $row = NULL)
	{	
		$result = Contact::getPrimaryContact($data->id);	
		if ($result)
			return $result->surname;
		else
			return "&nbsp;";
	}
	public function renderPCFirstname($data, $row = NULL)
	{	
		$result = Contact::getPrimaryContact($data->id);	
		if ($result)
			return $result->firstname;
		else
			return "&nbsp;";
	}			
/*
	public function beforeSave()
	{
		if ($this->isNewRecord) {
			// Set the date added to today
			$this->date_added = new CDbExpression('NOW()');
		}
		return true;
	}
*/
}