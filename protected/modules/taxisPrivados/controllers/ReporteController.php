<?php

class ReporteController extends TPController {

    public function actionIndex() {
        $selected = array('fechaInicio'=>'', 'fechaFin'=>'', 'empresa'=>'', 'vehiculo'=>'');
        if (isset($_POST['empresa'])) {
            $selected['empresa'] = $_POST['empresa'];
            $selected['fechaInicio'] = $_POST['fechaInicio'];
            $selected['fechaFin'] = $_POST['fechaFin'];
            $selected['vehiculo'] = $_POST['vehiculo'];
            
            $query = 'hora_inicio >=:hora_inicio AND hora_fin <=:hora_fin';
            $params[':hora_inicio'] = $_POST['fechaInicio'];
            $params[':hora_fin'] = $_POST['fechaFin'].' 23:59:59';
            
            if($_POST['empresa'] != '')
            {
                $query .=' AND empresa.id=:id_empresa';
                $params[':id_empresa'] = $_POST['empresa'];
            }
            if($_POST['vehiculo'] != '')
            {
                $query .=' AND vehiculo.id=:id_vehiculo';
                $params[':id_vehiculo'] = $_POST['vehiculo'];
            }
                        
            $reservas = PedidoReserva::model()->with('direccionesCompletas', 'empresa', 'vehiculo', 'valor')->findAll($query, $params);
        } else {
            $reservas = PedidoReserva::model()->with('direccionesCompletas', 'empresa', 'vehiculo', 'valor')->findAll();
        }
        foreach ($reservas as $key => $reserva) {

            $pedidos[$reserva->id_pedido]['fecha'] = $reserva->hora_inicio;
            $pedidos[$reserva->id_pedido]['empresa'] = $reserva->empresa->nombre;
            $pedidos[$reserva->id_pedido]['vehiculo'] = $reserva->vehiculo->placa;
            $pedidos[$reserva->id_pedido]['valorEmpresa'] = $reserva->valor->valor_empresa;
            $pedidos[$reserva->id_pedido]['valorVehiculo'] = $reserva->valor->valor_vehiculo;
            $pedidos[$reserva->id_pedido]['ruta'] = $reserva->valor->ruta;

            foreach ($reserva->direccionesCompletas as $keyDir => $direccion) {
                if ($direccion->id_user != '0') {
                    $pasajero = Profile::model()->find('user_id=:id_user', array(':id_user' => $direccion->id_user));
                    $pedidos[$reserva->id_pedido]['pasajeros'][$pasajero->user_id] = "{$pasajero->firstname} {$pasajero->lastname}";
                }
            }
        }
        $vehiculos = Vehiculo::model()->findAll();
        $this->render('index', array(
            'pedidos' => $pedidos,
            'empresas' => $this->empresas,
            'vehiculos' => $vehiculos,
            'selected' => $selected,
        ));
    }

    public function actionActualizar() {


        if (isset($_GET['pedido'])) {
            foreach ($_GET['pedido'] as $key => $pedido) {

                $valor = PedidoTpValor::model()->find('id_pedido=:id_pedido', array(':id_pedido' => $key));
                if (is_null($valor)) {
                    $valor = new PedidoTpValor;
                }
                $valor->id_pedido = $key;
                $valor->valor_empresa = $pedido['valorEmpresa'];
                $valor->valor_vehiculo = $pedido['valorVehiculo'];
                $valor->ruta = $pedido['ruta'];
                $valor->save();
            }
            $rsp['success'] = true;
            echo json_encode($rsp);
        }
    }

    // Uncomment the following methods and override them if needed

    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'rights', /*
                  array(
                  'class'=>'path.to.FilterClass',
                  'propertyName'=>'propertyValue',
                  ), */
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