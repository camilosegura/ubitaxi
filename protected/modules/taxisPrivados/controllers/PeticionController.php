<?php

class PeticionController extends TPController {

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
            'rights', /*
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
    public function actionCreate() {
        $model = new Peticion;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Peticion'])) {
            $model->attributes = $_POST['Peticion'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionNuevo() {
        $hasPedido['success'] = false;
        if (isset($_POST['empresa'])) {
            $direccion = Direccion::model()->findByPk($_POST['direccionSalida']);

            $peticion = new Peticion;
            $peticion->hora_empresa = $_POST['horaEmpresa'];
            $peticion->id_empresa = $_POST['empresa'];
            $peticion->estado = 0;
            $peticion->sentido = $_POST['sentido'];
            $peticion->observaciones = $_POST['observaciones'];
            $peticion->time = date("Y-m-d H:i:s");
            $peticion->id_usuario = Yii::app()->user->id;

            if ($peticion->save()) {
                $this->nuevoDireccion($_POST['direccionEmpresa'], $peticion->id, 1);
                $this->nuevoDireccion($_POST['pasajeros'], $peticion->id, 0);
                $hasPeticion['success'] = true;
                $hasPeticion['id'] = $peticion->id;
            }
        }
        $this->render('nuevo', array(
            'empresas' => $this->empresas,
            'peticion' => $hasPeticion)
        );
    }

    public function actionVer() {
        
    }

    public function actionEditar() {
        if (isset($_GET['id'])) {
            $peticion = Peticion::model()->with('peticionDireccion', 'direcciones', 'empresa', 'reservas')->findByPk($_GET['id']);
            if (!is_null($peticion)) {
                foreach ($peticion->direcciones as $key => $direccion) {
                    if ($direccion->id_user == '0') {
                        $empresaDir[$direccion->id] = $direccion->direccion;
                    } else {
                        $pasajeroDir[$direccion->id] = $direccion->direccion;
                    }
                }
                foreach ($peticion->reservas as $key => $reserva) {

                    $pedidos[$reserva->id_pedido]['inicio'] = $reserva->hora_inicio;
                    $pedidos[$reserva->id_pedido]['fin'] = $reserva->hora_fin;
                    $pedidos[$reserva->id_pedido]['idVehiculo'] = $reserva->id_vehiculo;
                    $vehiculo = Vehiculo::model()->findByPk($reserva->id_vehiculo);
                    $pedidos[$reserva->id_pedido]['placaVehiculo'] = $vehiculo->placa;
                    $direccionesPedido = PedidoReserva::model()->with('direccionesCompletas')->find('t.id_pedido=:id_pedido', array(':id_pedido' => $reserva->id_pedido));

                    foreach ($direccionesPedido->direccionesCompletas as $key => $direccion) {

                        if ($direccion->id_user == '0') {
                            $pedidos[$reserva->id_pedido]['empresaDir'][$direccion->id] = $direccion->direccion;
                        } else {
                            $pedidos[$reserva->id_pedido]['pasajeroDir'][$direccion->id] = $direccion->direccion;
                            unset($pasajeroDir[$direccion->id]);
                        }
                    }
                }
                $this->render('editar', array(
                    'peticion' => $peticion,
                    'empresaDir' => $empresaDir,
                    'pasajeroDir' => $pasajeroDir,
                    'pedidos' => $pedidos)
                );
            }
        }
    }

    private function nuevoDireccion($direcciones, $idPeticion, $tipo) {
        foreach ($direcciones as $key => $idDireccion) {
            $peticionDireccion = new PeticionDireccion;
            $peticionDireccion->id_direccion = $idDireccion;
            $peticionDireccion->id_peticion = $idPeticion;
            $peticionDireccion->tipo = $tipo;
            $peticionDireccion->save();
        }
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

        if (isset($_POST['Peticion'])) {
            $model->attributes = $_POST['Peticion'];
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
        $dataProvider = new CActiveDataProvider('Peticion');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Peticion('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Peticion']))
            $model->attributes = $_GET['Peticion'];

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
        $model = Peticion::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'peticion-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
