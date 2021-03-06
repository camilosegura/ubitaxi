<?php

class VehiculoController extends TPController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'rights',
                /*
                  'accessControl', // perform access control for CRUD operations
                  'postOnly + delete', // we only allow deletion via POST request
                 * 
                 */
        );
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
    public function actionNuevo() {
        $model = new Vehiculo;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Vehiculo'])) {
            $model->attributes = $_POST['Vehiculo'];
            $model->tipo = 0;
            $model->placa = $_POST['Vehiculo']['placa'];
            $model->id_telefono = $_POST['Vehiculo']['id_telefono'];
            $model->id_conductor = 0;
            $model->id_pedido = 0;
            $model->id_seguimiento = 0;
            $model->estado = 0;
            if ($model->save()) {
                $operador = new OperadorVehiculo;
                $operador->id_operador = 1;
                $operador->id_vehiculo = $model->id;
                $operador->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
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
    public function actionActualizar($id) {
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
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionBorrar($id) {
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
    
    public function actionLibres() {
        $vehiculos = Vehiculo::model()->findAll('id NOT IN (SELECT id_vehiculo FROM tbl_pedido_reserva WHERE 
            ((hora_inicio >= :hora_inicio AND hora_inicio < :hora_fin) OR 
            (hora_fin > :hora_inicio AND hora_fin <= :hora_fin) OR 
            (hora_inicio <= :hora_inicio AND hora_fin >= :hora_fin)) AND tbl_pedido_reserva.id_pedido NOT LIKE :id_pedido)', 
                array(':hora_inicio'=> $_GET['horaInicio'], ':hora_fin'=>$_GET['horaFin'], ':id_pedido' => $_GET['idPedido']));
        $rsp = array();
        if(count($vehiculos)){
            $rsp['success'] = true;
            foreach ($vehiculos as $key => $vehiculo) {
                $rsp['libres'][$vehiculo->id] = $vehiculo->placa;
            }
        }else{
            $rsp['success'] = false;
        }
        echo json_encode($rsp);
    }
    public function actionListar() {
        $model = Vehiculo::model()->findAll();
        $this->render('listar', array(
            'model' => $model,
        ));
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
