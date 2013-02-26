<?php

/**
 * This is the model class for table "{{empresa}}".
 *
 * The followings are the available columns in table '{{empresa}}':
 * @property integer $id
 * @property string $nombre
 */
class Empresa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Empresa the static model class
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
		return '{{empresa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre', 'safe', 'on'=>'search'),
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
                    'usuario' => array(self::HAS_MANY, 'EmpresaUsuario', 'id_empresa'),
                    'usuarioPerfil' => array(self::HAS_MANY, 'Profile', array('id_usuario'=>'user_id'), 'through'=>'usuario'),
                    'usuarioDireccion' => array(self::HAS_MANY, 'Direccion', array('id_usuario'=>'id_user'), 'through'=>'usuario'),
                    'empresaDireccio' => array(self::HAS_MANY, 'EmpresaDireccion', 'id_empresa'),
                    'direccion' => array(self::HAS_MANY, 'Direccion', array('id_direccion'=>'id'), 'through'=>'empresaDireccio'),
                    'usuarios' => array(self::HAS_MANY, 'EmpresaUsuario', 'id_empresa'),
                    'user' => array(self::HAS_MANY, 'User', array('id_usuario'=>'id'), 'through'=>'usuarios'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
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
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}