<?php

/**
 * This is the model class for table "{{taxi}}".
 *
 * The followings are the available columns in table '{{taxi}}':
 * @property integer $id
 * @property integer $id_vehiculo
 * @property integer $id_propietario
 * @property integer $id_tipo_propietario
 */
class Taxi extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Taxi the static model class
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
		return '{{taxi}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_vehiculo, id_propietario, id_tipo_propietario', 'required'),
			array('id_vehiculo, id_propietario, id_tipo_propietario', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_vehiculo, id_propietario, id_tipo_propietario', 'safe', 'on'=>'search'),
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
			'id_vehiculo' => 'Id Vehiculo',
			'id_propietario' => 'Id Propietario',
			'id_tipo_propietario' => 'Id Tipo Propietario',
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
		$criteria->compare('id_vehiculo',$this->id_vehiculo);
		$criteria->compare('id_propietario',$this->id_propietario);
		$criteria->compare('id_tipo_propietario',$this->id_tipo_propietario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}