<?php

class VehiculoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            /*
              'accessControl', // perform access control for CRUD operations
              'postOnly + delete', // we only allow deletion via POST request
             * 
             */
            'rights'
        );
    }
    public function allowedActions() {
        return 'getid';
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Vehiculo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Vehiculo'])) {
            $model->attributes = $_POST['Vehiculo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Vehiculo'])) {
            $model->attributes = $_POST['Vehiculo'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model from car parameters.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdateCar($id, $id_vehiculo) {

        $model = Vehiculo::model()->findByPk($id_vehiculo);

        $model->id_seguimiento = $id;
        if ($model->save()) {
            return true;
        }

        $rsp["success"] = false;
        echo json_encode($rsp);
        return false;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Vehiculo');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Vehiculo('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Vehiculo']))
            $model->attributes = $_GET['Vehiculo'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionGetId() {
        $id_telefono = $_GET["id_telefono"];
        $model = Vehiculo::model()->find(array(
            'condition' => 'id_telefono=:id_telefono',
            'params' => array(':id_telefono' => $id_telefono),
                ));
        if(is_null($model)){
            $rsp['success'] = false;
        }else{
            $rsp['success'] = true;
            $rsp["id"] = $model->id;
        }                   
        echo json_encode($rsp);
    }

    public function getMasCerca($latitud, $longitud, $radio) {

        $seguimiento = Yii::app()->db->createCommand()
                ->select("v.id AS vid, latitud, longitud, ( 3959 * acos( cos( radians($latitud) ) * cos( radians( latitud ) ) * cos( radians( longitud ) - radians($longitud) ) + sin( radians($latitud) ) * sin( radians( latitud ) ) ) ) AS distance")
                ->from('tbl_vehiculo v')
                ->join('tbl_seguimiento s', 'v.id_seguimiento=s.id')
                ->where('estado=0 AND id_pedido=0', array(':estado' => 0))
                ->having('distance < 10000')
                ->limit('1')
                ->order('distance ASC')
                ->queryAll();
        return $seguimiento;
    }

    public function actionGetPedido() {
        $model = $this->loadModel($_GET['id_vehiculo']);

        if ($model->estado == 0) {
            $pedido = Pedido::model()->findByPk($model->id_pedido);
            $rsp['id_pedido'] = $model->id_pedido;
            $rsp['p_do'] = $pedido->direccion_origen;
            $rsp['lat'] = $pedido->latitud;
            $rsp['lng'] = $pedido->latitud;
        } else {
            $rsp['id_pedido'] = 0;
        }


        echo json_encode($rsp);
    }

    public function actionGeLastState() {
        $model = Vehiculo::model()->with('pedido')->findByPk($_GET["idv"], "id_conductor=:id_conductor", array(':id_conductor' => Yii::app()->user->id));
        if (!is_null($model)) {            
            $rsp["vehiculo"] = $model->attributes;
            $rsp["pedido"] = $model->pedido->attributes;
            $rsp["success"] = true;
        }  else {
            $rsp["success"] = false;
        }

        echo json_encode($rsp);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Vehiculo::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'vehiculo-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
