<?php

/**
 * This is the model class for table "task_tmpl".
 *
 * The followings are the available columns in table 'task_tmpl':
 * @property integer $id
 * @property string $cat
 * @property string $description
 * @property integer $priority
 * @property integer $owner_type_id
 * @property string $state
 * @property string $due_date_spec
 * @property integer $reminder
 * @property string $reminder_spec
 * @property string $notes
 */
class TaskTmpl extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return TaskTmpl the static model class
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
		return 'task_tmpl';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, priority, owner_type_id, reminder', 'numerical', 'integerOnly'=>true),
			array('cat, state, due_date_spec, reminder_spec', 'length', 'max'=>16),
			array('description, notes', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cat, description, priority, owner_type_id, state, due_date_spec, reminder, reminder_spec, notes', 'safe', 'on'=>'search'),
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
			'cat' => 'Cat',
			'description' => 'Description',
			'priority' => 'Priority',
			'owner_type_id' => 'Owner Type',
			'state' => 'State',
			'due_date_spec' => 'Due Date Spec',
			'reminder' => 'Reminder',
			'reminder_spec' => 'Reminder Spec',
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
		$criteria->compare('cat',$this->cat,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('owner_type_id',$this->owner_type_id);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('due_date_spec',$this->due_date_spec,true);
		$criteria->compare('reminder',$this->reminder);
		$criteria->compare('reminder_spec',$this->reminder_spec,true);
		$criteria->compare('notes',$this->notes,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}