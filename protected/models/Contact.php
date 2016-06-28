<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property integer $id
 * @property string $sex
 * @property string $role
 * @property string $title
 * @property string $fname
 * @property string $lname
 * @property string $name
 * @property integer $address_id
 * @property string $dob
 * @property string $email_address
 * @property integer $newsletter_signup
 * @property integer $primary_contact
 * @property string $mobile_phone
 * @property string pref_contact_method
 * @property string $due_date
 * @property string $notes
 *
 * The followings are the available model relations:
 * @property Address $address
 */
class Contact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Contact the static model class
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
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('address_id, newsletter_signup, primary_contact, wmg_cherub', 'numerical', 'integerOnly'=>true),
			array('sex, role, pref_contact_method', 'length', 'max'=>16),
			array('title, firstname, surname, mobile_phone', 'length', 'max'=>45),
			array('name', 'length', 'max'=>92),
			array('email_address', 'length', 'max'=>128),
			array('dob, notes, due_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, sex, role, title, firstname, surname, name, address_id, dob, due_date, email_address, newsletter_signup, primary_contact, mobile_phone, pref_contact_method, notes', 'safe', 'on'=>'search'),
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
			'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'sex' => 'Sex',
			'role' => 'Role',
			'title' => 'Title',
			'firstname' => 'First Name',
			'surname' => 'Last Name',
			'name' => 'Name',
			'address_id' => 'Address',
			'dob' => 'Date of Birth',
			'wmg_cherub' => 'Watch Me Grow Cherub',
			'email_address' => 'Email Address',
			'newsletter_signup' => 'Newsletter Signup',
			'primary_contact' => 'Primary Contact',
			'mobile_phone' => 'Mobile Phone',
			'pref_contact_method' => 'Preferred contact method',
			'due_date' => 'Due Date',
			'notes' => 'Notes',
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
		$criteria->compare('firstname',$this->fname,true);
		$criteria->compare('lastname',$this->lname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dob',$this->dob,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('mobile_phone',$this->mobile_phone,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
	{
		if (parent::beforeSave()) {
			// Create the "name" field
			$this->name = sprintf("%s %s", $this->firstname, $this->surname);
			
			if ($this->dob == '' || strcmp($this->dob, '0000-00-00') == 0)
				$this->dob = NULL;
				
			if ($this->due_date == '' || strcmp($this->due_date, '0000-00-00') == 0)
				$this->due_date = NULL;
	
				
			if (strlen($this->mobile_phone) > 0)
				$this->mobile_phone = CrmHelper::formatPhone($this->mobile_phone);
		}
		return true;
	}
		
	
	public function save_cherub_monthly($validate = false)
	{
		return self::save($validate);	
	}
	
	public function getContactByName($firstname, $surname)
	{
		$result = Contact::model()->find('firstname=:firstname AND surname=:surname', array(':firstname'=>$firstname, ':surname'=>$surname));
		return $result;
	}
	
	// Use the address_id to find the primary contact, called when you have an appointment/task to render
	//
/*	public function renderPrimaryContact($data, $row = NULL)
	{	
		$result = Contact::getPrimaryContact($data->id);	
		if ($result)
			return $result->name;
		else
			return "&nbsp;";
	}
*/
	public function renderPrimaryContact($address_id)
	{
		$result = Contact::getPrimaryContact($address_id);	
		if ($result)
			return $result->name;
		else
			return "&nbsp;";		
	}
	
	public function getPrimaryContactId($address_id)
	{
		$result = Contact::getPrimaryContact($address_id);
		if ($result)
			return $result->id;
		else
			return NULL;		
	}
	
	public function getPrimaryContact($address_id)
	{
		$result = Contact::model()->find('address_id=:id AND primary_contact=1', array(':id'=>$address_id));
		return $result;
	}

	// Return a list of contacts with a birthday today
	public static function birthdayToday()
	{				
		$result = new CActiveDataProvider('Contact', array(
			'criteria'=>array(
				'condition'=>'DAYOFYEAR( curdate( ) ) = DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) ) AND address.lead_ignore = 0',
				'order'=>'name ASC',
				'join'=>'JOIN `address` ON `address_id` = `address`.`id`'
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		return $result;		
	}
			
	// Return a list of contacts with a birthday today
	public static function birthdaySoon($days = 14)
	{
		$result = new CActiveDataProvider('Contact', array(
			'criteria'=>array(
				'condition'=>'
					DAYOFYEAR( curdate( ) ) <= DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) ) AND
					DAYOFYEAR( curdate( ) ) + :days >= DAYOFYEAR( DATE_ADD( dob, INTERVAL( YEAR( NOW( ) ) - YEAR( dob ) ) YEAR ) ) AND
					address.lead_ignore = 0',
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
}