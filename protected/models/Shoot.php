<?php

/**
 * This is the model class for table "shoot".
 *
 * The followings are the available columns in table 'shoot':
 * @property integer $id
 * @property string $type
 * @property string $location_type
 * @property integer $location_address_id
 * @property string $description
 * @property integer $address_id
 * @property string $date_added
 *
 * The followings are the available model relations:
 * @property Address $address
 * @property Address $locationAddress
 */
class Shoot extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Shoot the static model class
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
		return 'shoot';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location_address_id, address_id, revenue', 'numerical', 'integerOnly'=>true),
			array('type, location_type', 'length', 'max'=>16),
			array('type', 'required'),
			array('description, date_last_revenue', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, location_type, location_address_id, description, address_id, date_last_revenue', 'safe', 'on'=>'search'),
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
			'locationAddress' => array(self::BELONGS_TO, 'Address', 'location_address_id'),
			'appointments' => array(self::HAS_MANY, 'Appointment', 'owner_id',
								'condition'=>"appointments.owner_type_id='SHOOT'"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'location_type' => 'Location Type',
			'location_address_id' => 'Location Address',
			'description' => 'Description',
			'address_id' => 'Address',
			'date_added' => 'Date Added',
			'revenue' => 'Revenue To Date',
			'date_last_revenue' => 'Date Last Revenue',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('location_type',$this->location_type,true);
		$criteria->compare('location_address_id',$this->location_address_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('address_id',$this->address_id);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('revenue',$this->revenue);
		$criteria->compare('date_last_revenue',$this->date_last_revenue,true);	

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function summaryDescription($id)
	{
		$shoot = $this->findByPk($id);
		if (!$shoot)
			return ('ERROR -  Shoot not found ID=$id');
		
		$s = Enum::getLabel("ShootType",$shoot->type);
		$s .= ', ';
		$s .= Enum::getLabel("ShootLocationType",$shoot->location_type);
		return $s;
	}
	
	public function beforeSave()
	{
		if (parent::beforeSave()) {
			
			if ($this->date_last_revenue == '' || strcmp($this->date_last_revenue, '0000-00-00') == 0)
				$this->date_last_revenue = NULL;
				
		}
		return true;
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
}