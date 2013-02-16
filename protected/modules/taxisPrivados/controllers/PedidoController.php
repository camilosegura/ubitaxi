<?php

class PedidoController extends TPController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionListar() {
        $this->render('listar');
    }

    public function actionNuevo() {
        $hasPedido['success'] = false;
        if (isset($_POST['empresa'])) {
            $direccion = Direccion::model()->findByPk($_POST['direccionSalida']);

            $pedido = new Pedido;
            $pedido->id_estado = 0;
            $pedido->id_pasajero = 0;
            $pedido->time = time();
            $pedido->direccion_origen = $direccion->direccion;
            $pedido->latitud = $direccion->latitud;
            $pedido->longitud = $direccion->longitud;
            $pedido->id_operador = 1;
            $pedido->save();

            //var_dump($pedido->getErrors());
            $vehiculo = new VehiculoController("vehiculo", "destinos");
            $disponibles = $vehiculo->getMasCerca($direccion->latitud, $direccion->longitud, 10);
            $this->pedidoAssign($disponibles, $pedido->id);

            $emPedido = new EmpresaPedido;
            $emPedido->id_empresa = $_POST['empresa'];
            $emPedido->id_pedido = $pedido->id;
            $emPedido->personas = $_POST['numPasajeros'];
            $emPedido->destinos = $_POST['numDestinos'];
            $emPedido->hora_inicio = date('Y-m-d') . " {$_POST['horaSalida']}:00";
            $emPedido->direcciones = serialize($_POST['pasajeros']);
            $emPedido->save();

            $hasPedido['success'] = true;
            $hasPedido['id'] = $pedido->id;
            //var_dump($emPedido->getErrors());
        }
        $this->render('nuevo', array(
            'empresas' => $this->empresas,
            'pedido' => $hasPedido)
        );
    }

    public function actionPeticionNuevo() {

        if (isset($_GET['idPeticion']) && !strlen($_GET['id'])) {
            $model = new Pedido;
            $model->id_estado = 9;
            $model->id_pasajero = 0;
            $model->time = time();
            $model->direccion_origen = 0;
            $model->latitud = 0;
            $model->longitud = 0;
            $model->id_operador = 1;
            if ($model->save()) {
                $peticionPedido = new PeticionPedido;
                $peticionPedido->id_pedido = $model->id;
                $peticionPedido->id_peticion = $_GET['idPeticion'];
                $peticionPedido->save();

                $peticion = Peticion::model()->findByPk($_GET['idPeticion']);

                $pedidoReserva = new PedidoReserva;
                $pedidoReserva->id_pedido = $model->id;
                $pedidoReserva->id_vehiculo = $_GET['idVehiculo'];
                $pedidoReserva->estado = 0;
                if ($peticion->sentido == '0') {
                    $pedidoReserva->hora_inicio = $peticion->hora_empresa;
                    $pedidoReserva->hora_fin = $_GET['fin'];
                } else {
                    $pedidoReserva->hora_inicio = $_GET['fin'];
                    $pedidoReserva->hora_fin = $peticion->hora_empresa;
                }
                $pedidoReserva->save();

                $this->setPedidoDireccion($_GET['dirPasa'], 0, $model->id);
                $this->setPedidoDireccion($_GET['dirEmp'], 1, $model->id);
                $rsp['success'] = true;
                $rsp['id'] = $model->id;
            } else {
                $rsp['success'] = false;
            }
        } else {
            $rsp['success'] = false;
        }
        echo json_encode($rsp);
    }

    public function actionPeticionEditar() {
        if (isset($_GET['idPeticion']) && isset($_GET['id'])) {
            $peticion = Peticion::model()->findByPk($_GET['idPeticion']);

            $pedidoReserva = PedidoReserva::model()->find('id_pedido=:id_pedido', array(':id_pedido' => $_GET['id']));
            $pedidoReserva->id_vehiculo = $_GET['idVehiculo'];
            if ($peticion->sentido == '0') {
                $pedidoReserva->hora_fin = $_GET['fin'];
            } else {
                $pedidoReserva->hora_inicio = $_GET['fin'];
            }
            if ($pedidoReserva->save()) {
                PedidoDireccion::model()->deleteAll('id_pedido=:id_pedido', array(':id_pedido' => $_GET['id']));
                $this->setPedidoDireccion($_GET['dirPasa'], 0, $_GET['id']);
                $this->setPedidoDireccion($_GET['dirEmp'], 1, $_GET['id']);
                $rsp['success'] = true;
            } else {
                $rsp['success'] = false;
            }
        } else {
            $rsp['success'] = false;
        }

        echo json_encode($rsp);
    }

    public function actionPeticionEliminar() {
        if (isset($_GET['id'])) {
            PedidoDireccion::model()->deleteAll('id_pedido=:id_pedido', array(':id_pedido' => $_GET['id']));
            Pedido::model()->deleteByPk($_GET['id']);
            PedidoReserva::model()->deleteAll('id_pedido=:id_pedido', array(':id_pedido' => $_GET['id']));
            PeticionPedido::model()->deleteAll('id_pedido=:id_pedido', array(':id_pedido' => $_GET['id']));
            $rsp['success'] = true;
        } else {
            $rsp['success'] = false;
        }

        echo json_encode($rsp);
    }

    private function setPedidoDireccion($direcciones, $tipo, $idPedido) {
        foreach ($direcciones as $key => $direccion) {
            $pedidoDireccion = new PedidoDireccion;
            $pedidoDireccion->id_direccion = $direccion;
            $pedidoDireccion->id_pedido = $idPedido;
            $pedidoDireccion->tipo = $tipo;
            $pedidoDireccion->save();
        }
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

    public function actionVer() {

        $this->render('ver');
    }

    public function actionAceptar() {
        $pedido = Pedido::model()->findByPk($_GET['id_pedido']);
        if ($pedido->id_estado === '0') {

            $vehiculo = Vehiculo::model()->findByPk($_GET['id_vehiculo']);
            $vehiculo->estado = 1;
            if ($vehiculo->save()) {
                $pedido->id_estado = 1;
                $pedido->tiempo_llegar = 0;
                $pedido->save();
                Vehiculo::model()->updateAll(array('id_pedido' => 0), 'id_pedido=:id_pedido AND estado = 0', array(':id_pedido' => $_GET['id_pedido']));
                $empresaPedido = EmpresaPedido::model()->find('id_pedido=:id_pedido', array(':id_pedido' => $_GET['id_pedido']));
                $rsp['direccion'] = $pedido->direccion_origen;
                $rsp["lat"] = $pedido->latitud;
                $rsp["lng"] = $pedido->longitud;
                $rsp['msg'] = 'Hora de recogida ' . $empresaPedido->hora_inicio . '.  El pasajero lo espera en ' . $pedido->direccion_origen;
                $rsp['success'] = true;
                $rsp['hora_inicio'] = $empresaPedido->hora_inicio;

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

    public function actionIniciar() {

        $pedido = Pedido::model()->findByPk($_GET["id_pedido"]);

        if (!is_null($pedido)) {

            $pedidoVehiculo = new PedidoVehiculo();
            $pedidoVehiculo->id_pedido = $_GET["id_pedido"];
            $pedidoVehiculo->id_vehiculo = $_GET["id_vehiculo"];
            $pedidoVehiculo->time = time();
            $pedidoVehiculo->save();

            $model = Pedido::model()->findByPk($_GET["id_pedido"]);
            $model->id_estado = 3;
            $model->save();

            $empresaPedido = EmpresaPedido::model()->find('id_pedido=:id_pedido', array(':id_pedido' => $_GET["id_pedido"]));
            $empresaPedido->personas_vehiculo = $_GET['pasajeros'];
            $empresaPedido->save();

            $direccionesId = unserialize($empresaPedido->direcciones);
            $direcciones = Direccion::model()->findAll('id IN (' . implode(',', $direccionesId) . ')');
            foreach ($direcciones as $key => $direccion) {
                $rsp['direcciones'][$direccion->id]['direccion'] = $direccion->direccion;
                $rsp['direcciones'][$direccion->id]['latitud'] = $direccion->latitud;
                $rsp['direcciones'][$direccion->id]['longitud'] = $direccion->longitud;
                $rsp['direcciones'][$direccion->id]['id_usuario'] = $direccion->id_user;
            }
            $rsp['dir'] = $direcciones[0]->latitud;

            $rsp["success"] = true;
            $rsp["msg"] = "Iniciando el recorrido";
            $rsp["id"] = $pedidoVehiculo->id;
        } else {
            $rsp["success"] = false;
            $rsp["msg"] = "El pedido no es correcto";
        }
        echo json_encode($rsp);
    }

    public function actionGetReservasVehiculo() {
        $pedidos = array();
        $rsp = array();
        $ahora = date("Y-m-d H:i:s");
        $reservas = PedidoReserva::model()->with('direccionesCompletas', 'empresa')->findAll(array('condition' => 'id_vehiculo=:id_vehiculo AND (hora_inicio > :ahora OR :ahora BETWEEN hora_inicio AND hora_fin)',
            'order' => 'hora_inicio ASC',
            'params' => array(':id_vehiculo' => $_GET['id_vehiculo'], ':ahora' => $ahora)));
        if (count($reservas)) {
            foreach ($reservas as $keyRev => $reserva) {
                foreach ($reserva->direccionesCompletas as $key => $direccion) {
                    if ($direccion->id_user == '0') {
                        $pedidos[$reserva->id_pedido]['empresaDir'][$direccion->id]['direccion'] = str_replace(array('Cundinamarca, Colombia', ', Bogota, Colombia', ', Colombia'), '', $direccion->direccion);
                        $pedidos[$reserva->id_pedido]['empresaDir'][$direccion->id]['latitud'] = $direccion->latitud;
                        $pedidos[$reserva->id_pedido]['empresaDir'][$direccion->id]['longitud'] = $direccion->longitud;
                    } else {
                        $pasajero = Profile::model()->find("user_id=:user_id", array(':user_id' => $direccion->id_user));
                        $pedidos[$reserva->id_pedido]['pasajeroDir'][$direccion->id]['nombre_pasajero'] = "{$pasajero->firstname} {$pasajero->lastname}";
                        $pedidos[$reserva->id_pedido]['pasajeroDir'][$direccion->id]['direccion'] = str_replace(array('Cundinamarca, Colombia', ', Bogota, Colombia', ', Colombia'), '', $direccion->direccion);
                        $pedidos[$reserva->id_pedido]['pasajeroDir'][$direccion->id]['latitud'] = $direccion->latitud;
                        $pedidos[$reserva->id_pedido]['pasajeroDir'][$direccion->id]['longitud'] = $direccion->longitud;
                        $pedidoConfirmacion = PedidoConfirmacion::model()->find('id_pedido=:id_pedido AND id_direccion=:id_direccion', array(':id_pedido' => $reserva->id_pedido, ':id_direccion' => $direccion->id));
                        $pedidos[$reserva->id_pedido]['pasajeroDir'][$direccion->id]['confirmado'] = !is_null($pedidoConfirmacion);
                    }
                    $peticion = Peticion::model()->with('peticionPedidos')->find('id_pedido=:id_pedido', array(':id_pedido' => $reserva->id_pedido));
                    $pedidos[$reserva->id_pedido]['sentido'] = $peticion->sentido;
                    $pedidos[$reserva->id_pedido]['inicio'] = $reserva->hora_inicio;
                    $pedidos[$reserva->id_pedido]['fin'] = $reserva->hora_fin;
                    $pedidos[$reserva->id_pedido]['orden'] = $keyRev;
                    $pedidos[$reserva->id_pedido]['empresa'] = $reserva->empresa->nombre;
                }
            }
            $rsp['success'] = true;
            $rsp['pedidos'] = $pedidos;
        } else {
            $rsp['success'] = false;
        }
        ksort($rsp);
        echo json_encode($rsp);
    }

    public function actionSetConfirmacion() {
        $rsp = array();
        $pedidoConfirmacion = PedidoConfirmacion::model()->find('id_pedido=:id_pedido AND id_direccion=:id_direccion', array(':id_pedido' => $_GET['idPedido'], ':id_direccion' => $_GET['idDir']));
        $pedido = Pedido::model()->findByPk($_GET['idPedido']);

        if (is_null($pedidoConfirmacion)) {
            $pedidoConfirmacion = new PedidoConfirmacion;
            $pedidoConfirmacion->id_direccion = $_GET['idDir'];
            $pedidoConfirmacion->id_pedido = $_GET['idPedido'];
            if ($pedidoConfirmacion->save()) {
                $pedido->id_estado = 3;
                $pedido->save();
                $rsp['success'] = true;
            } else {
                $rsp['success'] = false;
            }
        } else {
            if ($_GET['check'] == 'false') {
                $pedidoConfirmacion->delete();
                $pedidoConfirmaciones = PedidoConfirmacion::model()->findAll('id_pedido=:id_pedido', array(':id_pedido' => $_GET['idPedido']));
                if (!count($pedidoConfirmaciones)) {
                    $pedido->id_estado = 9;
                    $pedido->save();
                }
            } else if (isset($_GET['pass'])) {
                $pedidoConfirmacion->pasajero_confirmacion = 1;
                if ($pedidoConfirmacion->save()) {
                    $rsp['success'] = true;
                }
            } else {
                $rsp['success'] = false;
            }
        }
        echo json_encode($rsp);
    }

    public function actionBorrarConfirmacion() {
        PedidoConfirmacion::model()->deleteAll('id_pedido=:id_pedido AND id_direccion=:id_direccion', array(':id_pedido' => $_GET['idPedido'], ':id_direccion' => $_GET['idDir']));
        $pedidoConfirmaciones = PedidoConfirmacion::model()->findAll('id_pedido=:id_pedido', array(':id_pedido' => $_GET['idPedido']));
        if (!count($pedidoConfirmaciones)) {
            $pedido = Pedido::model()->findByPk($_GET['idPedido']);
            $pedido->id_estado = 9;
            $pedido->save();
        }
    }

    public function actionActualizarEstado() {
        $rsp = array();
        $model = Pedido::model()->findByPk($_GET['id']);
        if (is_null($model)) {
            $rsp['success'] = false;
        } else {
            $model->id_estado = $_GET['estado'];
            if ($model->save()) {
                $rsp['success'] = true;
            } else {
                $rsp['success'] = false;
            }
        }
        echo json_encode($rsp);
    }

    // Uncomment the following methods and override them if needed

    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'rights',
                /*
                  'inlineFilterName',
                  array(
                  'class'=>'path.to.FilterClass',
                  'propertyName'=>'propertyValue',
                  ),
                 * 
                 */
        );
    }

    /*
      public function actions()
      {
      // return external action classes, e.g.:
      return array(
      'action1'=>'path.to.ActionClass',
      'action2'=>array(
      'class'=>'path.to.AnotherActionClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }
     */
}