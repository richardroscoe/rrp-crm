<?php

/**
 * This is the model class for table "owner".
 *
 * The followings are the available columns in table 'owner':
 * @property string $id
 * @property string $table_name
 * @property string $tmpl_cat_table
 * @property string $tmpl_cat_table_descr
 * @property string $class_name
 */
class Owner extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Owner the static model class
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
		return 'owner';
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
			array('id', 'length', 'max'=>16),
			array('table_name, tmpl_cat_table, tmpl_cat_table_descr, class_name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, table_name, tmpl_cat_table, tmpl_cat_table_descr, class_name', 'safe', 'on'=>'search'),
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
			'table_name' => 'Table Name',
			'tmpl_cat_table' => 'Tmpl Cat Table',
			'tmpl_cat_table_descr' => 'Tmpl Cat Table Descr',
			'class_name' => 'Class Name',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('table_name',$this->table_name,true);
		$criteria->compare('tmpl_cat_table',$this->tmpl_cat_table,true);
		$criteria->compare('tmpl_cat_table_descr',$this->tmpl_cat_table_descr,true);
		$criteria->compare('class_name',$this->class_name,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	//
	// Display the Summary description for an object
	//
	public function renderSummaryDescription($data, $row)
	{
		$owner = self::model()->findByPk($data->owner_type_id);
		
		if (!$owner)
			return ('ERROR - Owner not found');
			
		// So now we have the table entry, call the owner to return the description
		
		$obj = new $owner->class_name;
		
		$result = $obj->summaryDescription($data->owner_id);

		return $result;
	}
		
}