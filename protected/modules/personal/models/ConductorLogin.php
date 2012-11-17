<?php

/**
 * This is the model class for table "{{conductor_login}}".
 *
 * The followings are the available columns in table '{{conductor_login}}':
 * @property integer $id
 * @property integer $id_conductor
 * @property integer $id_tipo_login
 * @property string $time
 */
class ConductorLogin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConductorLogin the static model class
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
		return '{{conductor_login}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_conductor, id_tipo_login, time', 'required'),
			array('id_conductor, id_tipo_login', 'numerical', 'integerOnly'=>true),
			array('time', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_conductor, id_tipo_login, time', 'safe', 'on'=>'search'),
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
			'id_conductor' => 'Id Conductor',
			'id_tipo_login' => 'Id Tipo Login',
			'time' => 'Time',
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
		$criteria->compare('id_conductor',$this->id_conductor);
		$criteria->compare('id_tipo_login',$this->id_tipo_login);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}