<?php

/**
 * This is the model class for table "{{pedido_reserva}}".
 *
 * The followings are the available columns in table '{{pedido_reserva}}':
 * @property integer $id
 * @property integer $id_pedido
 * @property integer $id_vehiculo
 * @property integer $estado
 * @property string $hora_inicio
 * @property string $hora_fin
 */
class PedidoReserva extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PedidoReserva the static model class
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
		return '{{pedido_reserva}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pedido, id_vehiculo, hora_inicio, hora_fin', 'required'),
			array('id_pedido, id_vehiculo, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_pedido, id_vehiculo, estado, hora_inicio, hora_fin', 'safe', 'on'=>'search'),
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
                    'pedido' =>array(self::BELONGS_TO, 'Pedido', 'id_pedido'),
                    'direcciones' =>array(self::HAS_MANY, 'PedidoDireccion', array('id'=>'id_pedido'), 'through'=>'pedido'),
                    'direccionesCompletas' => array(self::HAS_MANY, 'Direccion', array('id_direccion'=>'id'), 'through'=>'direcciones'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_pedido' => 'Id Pedido',
			'id_vehiculo' => 'Id Vehiculo',
			'estado' => 'Estado',
			'hora_inicio' => 'Hora Inicio',
			'hora_fin' => 'Hora Fin',
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
		$criteria->compare('id_pedido',$this->id_pedido);
		$criteria->compare('id_vehiculo',$this->id_vehiculo);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('hora_inicio',$this->hora_inicio,true);
		$criteria->compare('hora_fin',$this->hora_fin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}