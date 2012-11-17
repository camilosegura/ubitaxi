<?php

class PedidoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(/*
              'accessControl', // perform access control for CRUD operations
              'postOnly + delete', // we only allow deletion via POST request
             * 
             */
            'rights'
        );
    }

    public function allowedActions() {
        return 'createUser';
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
        $model = new Pedido;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Pedido'])) {
            $model->attributes = $_POST['Pedido'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionCreateUser() {
        $model = new Pedido;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Pedido'])) {
            $model->attributes = $_POST['Pedido'];
            if ($model->save()) {
                $vehiculo = new VehiculoController("vehiculo", "destinos");
                $disponibles = $vehiculo->getMasCerca($_GET["latitud"], $_GET["longitud"], 10);
                $this->pedidoAssign($disponibles, $model->id);
                return $model->id;
            }
        }
        var_dump($model->getErrors());

        return false;
    }

    private function pedidoAssign($disponibles, $idPedido) {

        foreach ($disponibles as $key => $disponible) {

            $asignacion = array('id_pedido' => $idPedido, 'id_vehiculo' => $disponible["vid"], 'time' => time());

            $asignar = new PedidoAsignacion();
            $asignar->attributes = $asignacion;
            if ($asignar->save()) {
                $vehiculo = Vehiculo::model()->findByPk($disponible["vid"]);
                $vehiculo->id_pedido = $idPedido;
                $vehiculo->save();
            }
        }
    }

    public function actionRechazar() {
        $vehiculo = Vehiculo::model()->findByPk($_GET['id_vehiculo']);
        $vehiculo->id_pedido = 0;
        $vehiculo->save();
        $rsp["success"] = true;
        $rsp["msg"] = "El pedido se ha cancelado";
        echo json_encode($rsp);
    }

    public function actionAceptar() {
        $pedido = Pedido::model()->findByPk($_GET['id_pedido']);
        if ($pedido->id_estado === '0') {

            $vehiculo = Vehiculo::model()->findByPk($_GET['id_vehiculo']);
            $vehiculo->estado = 1;
            if ($vehiculo->save()) {
                $pedido->id_estado = 1;
                $pedido->save();
                Vehiculo::model()->updateAll(array('id_pedido' => 0), 'id_pedido=:id_pedido AND estado = 0', array(':id_pedido' => $_GET['id_pedido']));
                $rsp['direccion'] = $pedido->direccion_origen;
                $rsp["lat"] = $pedido->latitud;
                $rsp["lng"] = $pedido->longitud;
                $rsp['msg'] = 'El pasajero lo espera en ' . $pedido->direccion_origen;
                $rsp['success'] = true;

                $cliente = User::model()->with('profile')->findByPk($pedido->id_pasajero);
                $clave = substr($cliente->profile->celular, -4);
                $message = new YiiMailMessage;
                $message->setBody("La clave es {$clave}", 'text/html');
                $message->subject = 'Confirmación de Taxi';
                $message->addTo($cliente->email);
                $message->from = Yii::app()->params['adminEmail'];
                Yii::app()->mail->send($message);

                $rsp['id_pa'] = $pedido->id_pasajero;
                echo json_encode($rsp);
                return true;
            }
        }
        $rsp['success'] = false;
        $rsp['msg'] = 'El pedido ya fue asignado';

        echo json_encode($rsp);
        //echo 'sdsd';
        //return false;
    }

    public function actionSefue() {
        $model = Pedido::model()->findByPk($_GET["id_pedido"]);
        $model->id_estado = 2;
        $model->save();

        $vehiculo = Vehiculo::model()->findByPk($_GET["id_vehiculo"]);
        $vehiculo->estado = 0;
        $vehiculo->id_pedido = 0;
        $vehiculo->save();

        $rsp["success"] = true;
        $rsp["msg"] = "Reporte exitoso";

        echo json_encode($rsp);
    }

    public function actionIniciar() {

        $pedido = Pedido::model()->with('uprofile')->findByPk($_GET["id_pedido"]);
        //$pedido = Pedido::model()->findByPk($_GET["id_pedido"]);
       $clave = substr($pedido->uprofile->celular, -4);
        if ($clave == $_GET["clave"]) {

            $pedidoVehiculo = new PedidoVehiculo();
            $pedidoVehiculo->id_pedido = $_GET["id_pedido"];
            $pedidoVehiculo->id_vehiculo = $_GET["id_vehiculo"];
            $pedidoVehiculo->time = time();
            $pedidoVehiculo->save();

            $model = Pedido::model()->findByPk($_GET["id_pedido"]);
            $model->id_estado = 3;
            $model->save();

            $rsp["success"] = true;
            $rsp["msg"] = "Iniciando el recorrido";
            $rsp["id"] = $pedidoVehiculo->id;
        }else{
            $rsp["success"] = false;
            $rsp["msg"] = "La clave no es correcta";
        }
          
         
        
        echo json_encode($rsp);
    }

    public function actionLlegada() {

        $pedidoVehiculo = PedidoVehiculo::model()->findByPk($_GET["id_pv"]);
        $pedidoVehiculo->valor = $_GET["val"];
        $pedidoVehiculo->unidades = $_GET["uni"];
        $pedidoVehiculo->latitud = $_GET["lat"];
        $pedidoVehiculo->longitud = $_GET["lng"];
        $pedidoVehiculo->save();

        $model = Pedido::model()->findByPk($_GET["id_pedido"]);
        $model->id_estado = 4;
        $model->save();

        $vehiculo = Vehiculo::model()->findByPk($_GET["id_vehiculo"]);
        $vehiculo->id_pedido = 0;
        $vehiculo->estado = 0;
        $vehiculo->save();

        $rsp["success"] = true;
        $rsp["msg"] = "Gracias por su viaje";
        echo json_encode($rsp);
    }

    public function actionMensajeUsuario() {
        $cliente = User::model()->findByPk($_GET["id_pa"]);

        $message = new YiiMailMessage;
        $message->setBody($_GET["msg"], 'text/html');
        $message->subject = 'Mensaje del taxista';
        $message->addTo($cliente->email);
        $message->from = Yii::app()->params['adminEmail'];
        Yii::app()->mail->send($message);

        $rsp["success"] = true;
        $rsp["msg"] = "Su mensaje se ha enviado";
        echo json_encode($rsp);
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

        if (isset($_POST['Pedido'])) {
            $model->attributes = $_POST['Pedido'];
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
        $dataProvider = new CActiveDataProvider('Pedido');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Pedido('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pedido']))
            $model->attributes = $_GET['Pedido'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Pedido::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pedido-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
