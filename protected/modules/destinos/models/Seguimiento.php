<?php

/**
 * This is the model class for table "{{seguimiento}}".
 *
 * The followings are the available columns in table '{{seguimiento}}':
 * @property integer $id
 * @property string $id_telefono
 * @property string $latitud
 * @property string $longitud
 * @property string $altitud
 * @property string $velocidad
 * @property string $time
 * @property string $time_host
 */
class Seguimiento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Seguimiento the static model class
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
		return '{{seguimiento}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_telefono, latitud, longitud, altitud, velocidad, time, time_host', 'required'),
			array('id_telefono, latitud, longitud, altitud, velocidad, time, time_host', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_telefono, latitud, longitud, altitud, velocidad, time, time_host', 'safe', 'on'=>'search'),
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
			'id_telefono' => 'Id Telefono',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
			'altitud' => 'Altitud',
			'velocidad' => 'Velocidad',
			'time' => 'Time',
			'time_host' => 'Time Host',
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
		$criteria->compare('id_telefono',$this->id_telefono,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('longitud',$this->longitud,true);
		$criteria->compare('altitud',$this->altitud,true);
		$criteria->compare('velocidad',$this->velocidad,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('time_host',$this->time_host,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}