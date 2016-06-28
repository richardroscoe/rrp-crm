<?php

/**
 * This is the model class for table "letter".
 *
 * The followings are the available columns in table 'letter':
 * @property integer $id
 * @property string $type
 * @property string $media
 * @property string $cat
 * @property string $subcat
 * @property string $sex
 * @property string $subject
 * @property string $body
 */
class Letter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Letter the static model class
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
		return 'letter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, media', 'required'),
			array('type, media, cat, subcat, sex', 'length', 'max'=>16),
			array('subject', 'length', 'max'=>45),
			array('body', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, media, cat, subcat, sex, subject, body', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'media' => 'Media',
			'cat' => 'Cat',
			'subcat' => 'Subcat',
			'sex' => 'Sex',
			'subject' => 'Subject',
			'body' => 'Body',
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
		$criteria->compare('media',$this->media,true);
		$criteria->compare('cat',$this->cat,true);
		$criteria->compare('subcat',$this->subcat,true);
		$criteria->compare('sex',$this->sex,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	public function beforeSave()
	{
		if (parent::beforeSave()) {
			if (strlen($this->type) == 0) $this->type = NULL;
			if (strlen($this->media) == 0) $this->media = NULL;
			if (strlen($this->cat) == 0) $this->cat = NULL;
			if (strlen($this->subcat) == 0) $this->subcat = NULL;
			if (strlen($this->sex) == 0) $this->sex = NULL;
			if (strlen($this->subject) == 0) $this->subject = NULL;
			if (strlen($this->body) == 0) $this->body = NULL;
		}
		return true;
	}
		
	// Return a reminder letter.
	// Try the most specific, gradually reducing.
	//
	public static function getReminder($media, $appointment_type, $shoot_type, $subject_sex = NULL)
	{
		Yii::trace("getReminder($media, $appointment_type, $shoot_type, $subject_sex)", "application.letter.getreminder");
		$criteria=new CDbCriteria;
		$criteria->condition='type = :type';
		$criteria->params=array(':type'=>'REMINDER');
		
		// Now the tricky bit???
		$criteria->condition.=' AND (media = :media OR media IS NULL)';
		$criteria->params[':media'] = $media;
		
		$criteria->condition.=' AND (cat = :cat OR cat IS NULL)';
		$criteria->params[':cat'] = $appointment_type;
		
		$criteria->condition.=' AND (sex = :sex OR sex IS NULL)';
		$criteria->params[':sex'] = $subject_sex;

		$backup = self::model()->find($criteria);
		
		$criteria->condition.=' AND (subcat = :subcat OR subcat IS NULL)';
		$criteria->params[':subcat'] = $shoot_type;
		
		$specific = self::model()->find($criteria);

		return ($specific != NULL ? $specific : $backup);
	}
}