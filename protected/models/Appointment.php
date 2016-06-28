<?php

/**
 * This is the model class for table "appointment".
 *
 * The followings are the available columns in table 'appointment':
 * @property integer $id
 * @property string $apt_date
 * @property integer $duration
 * @property string $type
 * @property string $state
 * @property integer $address_id
 * @property string $owner_type_id
 * @property integer $owner_id
 * @property string $description
 * @property string $confirmation_sent
 * @property string $reminder_date
 * @property string $reminder_spec
 * @property string $reminder_sent
 * @property string $date_added
 * @property string $notes
 */
class Appointment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Appointment the static model class
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
		return 'appointment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('duration, address_id, owner_id', 'numerical', 'integerOnly'=>true),
			array('type, state, owner_type_id, reminder_spec', 'length', 'max'=>16),
			array('apt_date, description, confirmation_sent, reminder_date, reminder_sent, notes', 'safe'),
			array('type', 'required'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, apt_date, duration, type, state, address_id, owner_type_id, owner_id, description, confirmation_sent, reminder_date, reminder_sent, reminder_spec, notes', 'safe', 'on'=>'search'),
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
			// If the owner is a shoot, here's the relation
			'shoot' => array(self::BELONGS_TO, 'Shoot', 'owner_id'),
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
			'apt_date' => 'Apt Date',
			'duration' => 'Duration',
			'type' => 'Type',
			'state' => 'State',
			'address_id' => 'Address',
			'owner_type_id' => 'Owner Type',
			'owner_id' => 'Owner',
			'description' => 'Description',
			'confirmation_sent' => 'Confirmation Sent',
			'reminder_date' => 'Reminder Date',
			'reminder_spec' => 'Reminder Spec',
			'reminder_sent' => 'Reminder Sent',
			'date_added' => 'Date Added',
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
		$criteria->compare('apt_date',$this->apt_date,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('address_id',$this->address_id);
		$criteria->compare('owner_type_id',$this->owner_type_id,true);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('confirmation_sent',$this->confirmation_sent,true);
		$criteria->compare('reminder_date',$this->reminder_date,true);
		$criteria->compare('reminder_spec',$this->reminder_spec,true);
		$criteria->compare('reminder_sent',$this->reminder_sent,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('notes',$this->notes,true);

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
		
	public function beforeSave()
	{
		if (parent::beforeSave()) {		
			if ($this->reminder_date == '')
				$this->reminder_date = NULL;
			if ($this->apt_date == '')
				$this->apt_date = NULL;
			if ($this->reminder_sent == '')
				$this->reminder_sent = NULL;
			if ($this->confirmation_sent == '')
				$this->confirmation_sent = NULL;

//DEBUG - Leave this until we have appointment templates				
			if (strlen($this->reminder_spec) == 0) {
				$this->reminder_spec = "-2 day";
			}
			
			// Caclulate reminders
			if (strlen($this->reminder_spec) > 0 && $this->apt_date && !$this->reminder_sent) {			
				$this->reminder_date = CrmHelper::parseTimeSpec($this->reminder_spec, $this->apt_date, false);
			}
//			echo "<p>before save - reminder_sent = $this->reminder_sent</p>";	
		}
		return true;
	}
	
	public static function nextNDays($days)
	{
		$dataProvider=new CActiveDataProvider('Appointment', array(
			'criteria'=>array(
				'condition'=>'apt_date >= CURDATE() AND apt_date <= DATE_ADD(CURDATE(),INTERVAL :days DAY) AND (state=\'DUE\' OR state=\'TBC\')',
				'order'=>'apt_date ASC',
				'params'=>array(':days' => $days),
			),
			'pagination'=>array(
				'pageSize'=>15,
			),
		));
		return $dataProvider;
	}

	public static function nextAppts($num)
	{
		$dataProvider=new CActiveDataProvider('Appointment', array(
			'criteria'=>array(
				'condition'=>'apt_date >= CURDATE() AND (state=\'DUE\' OR state=\'TBC\')',
				'order'=>'apt_date ASC',
//				'params'=>array(':days' => $days),
			),
			'pagination'=>array(
				'pageSize'=>15,
			),
		));
		return $dataProvider;
	}
	
	public static function overDue()
	{
		$dataProvider=new CActiveDataProvider('Appointment', array(
			'criteria'=>array(
				'condition'=>'apt_date < CURDATE() AND (state=\'DUE\' OR state=\'TBC\')',
				'order'=>'apt_date ASC',
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		return $dataProvider;
	}
	
	// Find due appointments with reminders that need to be sent
	public static function dueReminders()
	{
		$result = self::model()->findAll(array(
					'condition'=>'reminder_date IS NOT NULL AND reminder_date < NOW() AND reminder_sent IS NULL AND state=\'DUE\'',
					'order'=>'reminder_date ASC',
					));
		return $result;
	}
	
	//
	// Called periodically by CrmFilter to allow us to send out appointment reminders
	//
	public static function reminders()
	{
		Yii::trace("Called", "application.appointment.reminders");
		
		$reminders = self::dueReminders();
		
		if (!$reminders)
			return;
			
		foreach ($reminders as $appt) {

			$contact = Contact::getPrimaryContact($appt->address->id);
			if (!$contact)
				continue;
							
			// Get the template based on owner and appt type.
			// We need the letter template with category == shoot->type and subcat == appointment->type
			// $shoot_type, $appointment_type, $subject_sex = NULL
			if ($appt->owner_type_id == 'SHOOT')
				$subcat = $appt->shoot->type;
			else
				$subcat = $appt->owner_type_id;
							
			// Prefer sending reminders by text
			if (strlen($contact->mobile_phone) > 0) {
				$media = 'TXT';
				$sendfunc = 'sendTxt';
				$to = $contact->mobile_phone;
			} elseif (strlen($contact->email_address) > 0) {
				$media = 'EMAIL';
				$sendfunc = 'sendEmail';
				$to = $contact->email_address;
			} else {
				$media = NULL;
				// Can't sent auto reminder
			}
			Yii::trace("Appointment reminder, appointment type $appt->type, owner_type_id $appt->owner_type_id", "application.appointment.reminders");
				
			$letter = Letter::getReminder($media, $appt->type, $subcat,  NULL);
			
			if ($letter) {
				// Replace :name :datetime etc
				$letter->body = str_replace(array(':name', ':datetime'), array($contact->firstname, CrmHelper::dateTimeOutput($appt->apt_date)), $letter->body);

				Yii::trace("Letter Body: $letter->body", "application.appointment.reminders");		
				
				CrmHelper::$sendfunc($letter, $to, $contact->name);
				
				// Update the appointment's reminder sent field.
				$appt->reminder_sent = new CDbExpression('NOW()');
				$appt->save(false);								
			} else {
				Yii::log("Contact: $contact->name - No letter found Reminder (appointment id= $appt->id, media=$media, cat=$appt->type, subcat=$subcat)", "warning", "application.appointment.reminders");
			}
		}
	}
	
	// Render an appointments primary contact
	public function renderPrimaryContact($data, $row = NULL)
	{	
		$result = Contact::getPrimaryContact($data->address_id);	
		if ($result)
			return $result->name;
		else
			return "&nbsp;";
	}
	
	// DEBUG - This function is used to cause a save() on all appointments that don't have a reminder, it allows 
	//         reminder date to be updated
	public static function saveDues()
	{
		$appts = self::model()->findAll(array(
					'condition'=>'reminder_date IS NULL AND reminder_sent IS NULL AND state=\'DUE\'',
					'order'=>'reminder_date ASC',
					));		
		foreach ($appts as $appt) {
			$appt->save(false);	
		}
	}
}