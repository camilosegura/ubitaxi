<?php

/**
 * This is the model class for table "{{carrera_comentario}}".
 *
 * The followings are the available columns in table '{{carrera_comentario}}':
 * @property integer $id
 * @property integer $id_carrera
 * @property string $comentario
 * @property integer $id_tipo_comentario
 */
class CarreraComentario extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CarreraComentario the static model class
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
		return '{{carrera_comentario}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_carrera, comentario, id_tipo_comentario', 'required'),
			array('id_carrera, id_tipo_comentario', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_carrera, comentario, id_tipo_comentario', 'safe', 'on'=>'search'),
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
			'comentario' => 'Comentario',
			'id_tipo_comentario' => 'Id Tipo Comentario',
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
		$criteria->compare('comentario',$this->comentario,true);
		$criteria->compare('id_tipo_comentario',$this->id_tipo_comentario);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}