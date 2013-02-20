<?php

/**
 * This is the model class for table "{{peticion}}".
 *
 * The followings are the available columns in table '{{peticion}}':
 * @property integer $id
 * @property string $time
 * @property string $hora_empresa
 * @property integer $id_empresa
 * @property integer $estado
 * @property integer $sentido
 * @property string $observaciones
 * @property integer $id_usuario
 */
class Peticion extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Peticion the static model class
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
		return '{{peticion}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('time, hora_empresa, id_empresa, estado, sentido, id_usuario', 'required'),
			array('id_empresa, estado, sentido, id_usuario', 'numerical', 'integerOnly'=>true),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, time, hora_empresa, id_empresa, estado, sentido, observaciones, id_usuario', 'safe', 'on'=>'search'),
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
                    'peticionDireccion'=>array(self::HAS_MANY, 'PeticionDireccion', 'id_peticion'),
                    'direcciones'=>array(self::HAS_MANY, 'Direccion', array('id_direccion'=>'id'), 'through'=>'peticionDireccion'),
                    'empresa'=>array(self::BELONGS_TO, 'Empresa', 'id_empresa'),
                    'peticionPedidos'=>array(self::HAS_MANY, 'PeticionPedido', 'id_peticion'),
                    'reservas' => array(self::HAS_MANY, 'PedidoReserva', array('id_pedido'=>'id_pedido'), 'through'=>'peticionPedidos'),
                    'direccionesPedido' => array(self::HAS_MANY, 'PedidoDireccion', array('id'=>'id_pedido'), 'through'=>'pedidos'),
                    'direccionesPedidoCompletas' => array(self::HAS_MANY, 'Direccion', array('id_direccion'=>'id'), 'through'=>'direccionesPedido'),
                    'peticionConfirmacion' => array(self::HAS_MANY, 'PedidoConfirmacion', array('id_pedido'=>'id_pedido'), 'through'=>'peticionPedidos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'time' => 'Time',
			'hora_empresa' => 'Hora Empresa',
			'id_empresa' => 'Id Empresa',
			'estado' => 'Estado',
			'sentido' => 'Sentido',
			'observaciones' => 'Observaciones',
			'id_usuario' => 'Id Usuario',
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
		$criteria->compare('time',$this->time,true);
		$criteria->compare('hora_empresa',$this->hora_empresa,true);
		$criteria->compare('id_empresa',$this->id_empresa);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('sentido',$this->sentido);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('id_usuario',$this->id_usuario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}