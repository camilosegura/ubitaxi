<?php

/**
 * This is the model class for table "{{pedido}}".
 *
 * The followings are the available columns in table '{{pedido}}':
 * @property integer $id
 * @property integer $id_estado
 * @property integer $id_pasajero
 * @property string $time
 * @property string $direccion_origen
 * @property string $latitud
 * @property string $longitud
 * @property integer $id_operador
 */
class Pedido extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pedido the static model class
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
		return '{{pedido}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_estado, id_pasajero, time, direccion_origen, latitud, longitud, id_operador', 'required'),
			array('id_estado, id_pasajero, id_operador', 'numerical', 'integerOnly'=>true),
			array('time, latitud, longitud', 'length', 'max'=>255),
			array('direccion_origen', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_estado, id_pasajero, time, direccion_origen, latitud, longitud, id_operador', 'safe', 'on'=>'search'),
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
			'id_estado' => 'Id Estado',
			'id_pasajero' => 'Id Pasajero',
			'time' => 'Time',
			'direccion_origen' => 'Direccion Origen',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
			'id_operador' => 'Id Operador',
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
		$criteria->compare('id_estado',$this->id_estado);
		$criteria->compare('id_pasajero',$this->id_pasajero);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('direccion_origen',$this->direccion_origen,true);
		$criteria->compare('latitud',$this->latitud,true);
		$criteria->compare('longitud',$this->longitud,true);
		$criteria->compare('id_operador',$this->id_operador);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}