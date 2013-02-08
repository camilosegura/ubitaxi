<?php

/**
 * This is the model class for table "{{pedido_tp_valor}}".
 *
 * The followings are the available columns in table '{{pedido_tp_valor}}':
 * @property integer $id
 * @property integer $id_pedido
 * @property string $valor_empresa
 * @property string $valor_vehiculo
 * @property string $ruta
 */
class PedidoTpValor extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PedidoTpValor the static model class
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
		return '{{pedido_tp_valor}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_pedido', 'required'),
			array('id_pedido', 'numerical', 'integerOnly'=>true),
			array('valor_empresa, valor_vehiculo, ruta', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_pedido, valor_empresa, valor_vehiculo, ruta', 'safe', 'on'=>'search'),
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
			'id_pedido' => 'Id Pedido',
			'valor_empresa' => 'Valor Empresa',
			'valor_vehiculo' => 'Valor Vehiculo',
			'ruta' => 'Ruta',
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
		$criteria->compare('valor_empresa',$this->valor_empresa,true);
		$criteria->compare('valor_vehiculo',$this->valor_vehiculo,true);
		$criteria->compare('ruta',$this->ruta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}