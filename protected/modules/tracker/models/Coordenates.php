<?php

/**
 * This is the model class for table "{{coordenates}}".
 *
 * The followings are the available columns in table '{{coordenates}}':
 * @property integer $id
 * @property string $latitude
 * @property string $longitude
 * @property string $altitude
 * @property string $speed
 * @property string $time
 * @property string $timeHost
 * @property string $placa
 */
class Coordenates extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Coordenates the static model class
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
		return '{{coordenates}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('latitude, longitude, altitude, speed, time, placa', 'required'),
			array('latitude, longitude, altitude, speed, time', 'length', 'max'=>255),
			array('placa', 'length', 'max'=>50),
			array('timeHost', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, latitude, longitude, altitude, speed, time, timeHost, placa', 'safe', 'on'=>'search'),
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
			'latitude' => 'Latitude',
			'longitude' => 'Longitude',
			'altitude' => 'Altitude',
			'speed' => 'Speed',
			'time' => 'Time',
			'timeHost' => 'Time Host',
			'placa' => 'Placa',
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
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('altitude',$this->altitude,true);
		$criteria->compare('speed',$this->speed,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('timeHost',$this->timeHost,true);
		$criteria->compare('placa',$this->placa,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}