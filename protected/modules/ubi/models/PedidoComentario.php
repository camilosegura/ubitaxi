<?php

/**
 * This is the model class for table "{{pedido_comentario}}".
 *
 * The followings are the available columns in table '{{pedido_comentario}}':
 * @property integer $id
 * @property integer $id_pedido
 * @property string $comentario
 * @property integer $id_tipo_comentario
 * @property integer $estado
 */
class PedidoComentario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PedidoComentario the static model class
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
		return '{{pedido_comentario}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pedido, comentario, id_tipo_comentario', 'required'),
			array('id_pedido, id_tipo_comentario, estado', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_pedido, comentario, id_tipo_comentario, estado', 'safe', 'on'=>'search'),
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
                     'pedido' => array(self::BELONGS_TO, 'Pedido', 'id_pedido'),
                    'pedidoVehiculo'=> array(self::HAS_ONE, 'PedidoVehiculo', array('id'=>'id_pedido'), 'through'=>'pedido'),	
                    'vehiculo'=> array(self::HAS_ONE, 'Vehiculo', array('id'=>'id_pedido'), 'through'=>'pedido'), 
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
			'comentario' => 'Comentario',
			'id_tipo_comentario' => 'Id Tipo Comentario',
			'estado' => 'Estado',
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
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('id_tipo_comentario',$this->id_tipo_comentario);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}