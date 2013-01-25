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
        
        if(isset($_GET['idPeticion']) && !strlen($_GET['id'])){
            $model = new Pedido;
            $model->id_estado = 9;
            $model->id_pasajero = 0;
            $model->time = time();
            $model->direccion_origen = 0;
            $model->latitud = 0;
            $model->longitud = 0;
            $model->id_operador = 1;
            if($model->save()){                
                $peticionPedido = new PeticionPedido;
                $peticionPedido->id_pedido = $model->id;
                $peticionPedido->id_peticion = $_GET['idPeticion'];
                $peticionPedido->save();
                
                $peticion = Peticion::model()->findByPk($_GET['idPeticion']);
                
                $pedidoReserva = new PedidoReserva;
                $pedidoReserva->id_pedido = $model->id;
                $pedidoReserva->id_vehiculo = $_GET['idVehiculo'];
                $pedidoReserva->estado = 0;
                if($peticion->sentido == '0'){
                    $pedidoReserva->hora_inicio = $peticion->hora_empresa;
                    $pedidoReserva->hora_fin = $_GET['fin'];
                }else{
                    $pedidoReserva->hora_inicio = $_GET['fin'];
                    $pedidoReserva->hora_fin = $peticion->hora_empresa;
                }            
                $pedidoReserva->save();
                
                foreach ($_GET['dirPasa'] as $key => $direccion) {
                    $pedidoDireccion = new PedidoDireccion;
                    $pedidoDireccion->id_direccion = $direccion;
                    $pedidoDireccion->id_pedido = $model->id;
                    $pedidoDireccion->save();
                }
                foreach ($_GET['dirEmp'] as $key => $direccion) {
                    $pedidoDireccion = new PedidoDireccion;
                    $pedidoDireccion->id_direccion = $direccion;
                    $pedidoDireccion->id_pedido = $model->id;
                    $pedidoDireccion->save();
                }
                $rsp['success'] = true;
                $rsp['id'] = $model->id;
            }else{
                $rsp['success'] = false;
            }            
        }else{
            $rsp['success'] = false;
        }        
        echo json_encode($rsp);
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
            $rsp["msg"] = "El pedido no es correcta";
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