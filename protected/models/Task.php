<?php

/**
 * This is the model class for table "task".
 *
 * The followings are the available columns in table 'task':
 * @property integer $id
 * @property string $description
 * @property integer $priority
 * @property integer $address_id
 * @property string $owner_type_id
 * @property integer $owner_id
 * @property string $state
 * @property string $due_date
 * @property string $due_date_spec
 * @property string $date_added
 * @property string $notes
 */
class Task extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Task the static model class
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
		return 'task';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, date_added', 'required'),
			array('priority, address_id, owner_id', 'numerical', 'integerOnly'=>true),
			array('owner_type_id, state, due_date_spec', 'length', 'max'=>16),
			array('due_date, notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, description, priority, address_id, owner_type_id, owner_id, state, due_date, due_date_spec, date_added, notes', 'safe', 'on'=>'search'),
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
			'description' => 'Description',
			'priority' => 'Priority',
			'address_id' => 'Address',
			'owner_type_id' => 'Owner Type',
			'owner_id' => 'Owner',
			'state' => 'State',
			'due_date' => 'Due Date',
			'due_date_spec' => 'Due Date Spec',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('address_id',$this->address_id);
		$criteria->compare('owner_type_id',$this->owner_type_id,true);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('due_date_spec',$this->due_date_spec,true);
		$criteria->compare('date_added',$this->date_added,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
			
	public static function nextNDays($days)
	{
		$dataProvider=new CActiveDataProvider('Task', array(
			'criteria'=>array(
				'condition'=>'due_date >= CURDATE() AND due_date <= DATE_ADD(CURDATE(),INTERVAL :days DAY)',
				'order'=>'due_date ASC',
				'params'=>array(':days' => $days),
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		return $dataProvider;
	}
	
	public static function overDue()
	{
		$dataProvider=new CActiveDataProvider('Task', array(
			'criteria'=>array(
				'condition'=>'due_date < CURDATE() AND (state=\'DONE\' OR state=\'CANCEL\')',
				'order'=>'due_date ASC',
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));
		return $dataProvider;
	}
}