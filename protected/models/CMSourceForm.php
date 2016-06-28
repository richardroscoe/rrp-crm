<?php
/**
 * CMSource class.
 * CMSource is the data structure for keeping
 * Cherub Monthly Sourceform data. It is used by the '????' action of 'SiteController'.
 */
class CMSourceForm extends CFormModel
{
	public $filename;
	public $month;
	public $year;
	public $lead_type;
	public $fileinfo;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('filename', 'file', 'types'=>'csv', 'maxSize'=>'35000'),
			array('month, year, lead_type', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'filename'=>'File location',
		);
	}
}
?>