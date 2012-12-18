<?php

/**
 * This is the model class for table "{{vehiculo}}".
 *
 * The followings are the available columns in table '{{vehiculo}}':
 * @property integer $id
 * @property integer $tipo
 * @property string $placa
 * @property integer $id_conductor
 * @property integer $id_seguimiento
 * @property string $id_telefono
 * @property integer $estado
 * @property integer $id_pedido
 */
class Vehiculo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vehiculo the static model class
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
		return '{{vehiculo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo, placa, id_conductor, id_seguimiento, id_telefono', 'required'),
			array('tipo, id_conductor, id_seguimiento, estado, id_pedido', 'numerical', 'integerOnly'=>true),
			array('placa', 'length', 'max'=>30),
			array('id_telefono', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tipo, placa, id_conductor, id_seguimiento, id_telefono, estado, id_pedido', 'safe', 'on'=>'search'),
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
                    'ultimoseguimiento' =>array(self::BELONGS_TO, 'Seguimiento', 'id_seguimiento'),
                    'pedido' => array(self::BELONGS_TO, 'Pedido', 'id_pedido'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tipo' => 'Tipo',
			'placa' => 'Placa',
			'id_conductor' => 'Id Conductor',
			'id_seguimiento' => 'Id Seguimiento',
			'id_telefono' => 'Id Telefono',
			'estado' => 'Estado',
			'id_pedido' => 'Id Pedido',
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
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('placa',$this->placa,true);
		$criteria->compare('id_conductor',$this->id_conductor);
		$criteria->compare('id_seguimiento',$this->id_seguimiento);
		$criteria->compare('id_telefono',$this->id_telefono,true);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('id_pedido',$this->id_pedido);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}