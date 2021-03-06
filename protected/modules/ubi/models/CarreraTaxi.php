<?php

/**
 * This is the model class for table "{{carrera_taxi}}".
 *
 * The followings are the available columns in table '{{carrera_taxi}}':
 * @property integer $id
 * @property integer $id_carrera
 * @property integer $id_vehiculo
 * @property string $time
 * @property string $valor
 * @property string $unidades
 * @property string $direccion_destino
 * @property string $latitud
 * @property string $longitud
 */
class CarreraTaxi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarreraTaxi the static model class
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
		return '{{carrera_taxi}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_carrera, id_vehiculo, time, valor, unidades, direccion_destino, latitud, longitud', 'required'),
			array('id_carrera, id_vehiculo', 'numerical', 'integerOnly'=>true),
			array('time, latitud, longitud', 'length', 'max'=>255),
			array('valor', 'length', 'max'=>60),
			array('unidades', 'length', 'max'=>6),
			array('direccion_destino', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_carrera, id_vehiculo, time, valor, unidades, direccion_destino, latitud, longitud', 'safe', 'on'=>'search'),
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
			'id_carrera' => 'Id Carrera',
			'id_vehiculo' => 'Id Vehiculo',
			'time' => 'Time',
			'valor' => 'Valor',
			'unidades' => 'Unidades',
			'direccion_destino' => 'Direccion Destino',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
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
		$criteria->compare('id_carrera',$this->id_carrera);
		$criteria->compare('id_vehiculo',$this->id_vehiculo);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('valor',$this->valor,true);
		$criteria->compare('unidades',$this->unidades,true);
		$criteria->compare('direccion_destino',$this->direccion_destino,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('longitud',$this->longitud,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}