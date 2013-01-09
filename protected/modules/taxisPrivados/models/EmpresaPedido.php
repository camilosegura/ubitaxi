<?php

/**
 * This is the model class for table "{{empresa_pedido}}".
 *
 * The followings are the available columns in table '{{empresa_pedido}}':
 * @property integer $id
 * @property integer $id_empresa
 * @property integer $id_pedido
 * @property integer $personas
 * @property integer $destinos
 * @property string $hora_inicio
 * @property string $direcciones
 */
class EmpresaPedido extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EmpresaPedido the static model class
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
		return '{{empresa_pedido}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_empresa, id_pedido, personas, destinos, hora_inicio, direcciones', 'required'),
			array('id_empresa, id_pedido, personas, destinos', 'numerical', 'integerOnly'=>true),
			array('direcciones', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_empresa, id_pedido, personas, destinos, hora_inicio, direcciones', 'safe', 'on'=>'search'),
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
			'id_empresa' => 'Id Empresa',
			'id_pedido' => 'Id Pedido',
			'personas' => 'Personas',
			'destinos' => 'Destinos',
			'hora_inicio' => 'Hora Inicio',
			'direcciones' => 'Direcciones',
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
		$criteria->compare('id_empresa',$this->id_empresa);
		$criteria->compare('id_pedido',$this->id_pedido);
		$criteria->compare('personas',$this->personas);
		$criteria->compare('destinos',$this->destinos);
		$criteria->compare('hora_inicio',$this->hora_inicio,true);
		$criteria->compare('direcciones',$this->direcciones,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}