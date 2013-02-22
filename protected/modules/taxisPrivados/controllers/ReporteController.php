<?php

class ReporteController extends TPController {

    public function actionIndex() {
        $pedidos = $this->pedidos();
        $this->render('index', array(
            'pedidos' => $pedidos['pedidos'],
            'empresas' => $this->empresas,
            'vehiculos' => $pedidos['vehiculos'],
            'selected' => $pedidos['selected'],
        ));
    }
    
    public function actionPedidos() {
        $pedidos = $this->pedidos();
        
        $this->render('pedidos', array(
            'pedidos' => $pedidos['pedidos'],
            'empresas' => $this->empresas,
            'vehiculos' => $pedidos['vehiculos'],
            'selected' => $pedidos['selected'],
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
    private function pedidos() {
        $selected = array('fechaInicio' => '', 'fechaFin' => '', 'empresa' => '', 'vehiculo' => '', 'estado' => '');
        $pedidos = array();
        if (isset($_POST['empresa'])) {
            $selected['empresa'] = $_POST['empresa'];
            $selected['fechaInicio'] = $_POST['fechaInicio'];
            $selected['fechaFin'] = $_POST['fechaFin'];
            $selected['vehiculo'] = $_POST['vehiculo'];
            $selected['estado'] = $_POST['estado'];

            $query = 'hora_inicio >=:hora_inicio AND hora_fin <=:hora_fin';
            $params[':hora_inicio'] = $_POST['fechaInicio'];
            $params[':hora_fin'] = $_POST['fechaFin'] . ' 23:59:59';

            if ($_POST['empresa'] != '') {
                $query .=' AND empresa.id=:id_empresa';
                $params[':id_empresa'] = $_POST['empresa'];
            }
            if ($_POST['vehiculo'] != '') {
                $query .=' AND vehiculo.id=:id_vehiculo';
                $params[':id_vehiculo'] = $_POST['vehiculo'];
            }
            if ($_POST['estado'] != '') {
                $query .=' AND pedido.id_estado=:id_estado';
                $params[':id_estado'] = $_POST['estado'];
            }

            $reservas = PedidoReserva::model()->with('peticion', 'pedido', 'direccionesCompletas', 'empresa', 'vehiculo', 'valor')->findAll($query, $params);
        } else {
            $reservas = PedidoReserva::model()->with('peticion', 'pedido', 'direccionesCompletas', 'empresa', 'vehiculo', 'valor')->findAll();
        }
        foreach ($reservas as $key => $reserva) {

            $pedidos[$reserva->id_pedido]['fecha'] = $reserva->hora_inicio;
            $pedidos[$reserva->id_pedido]['empresa'] = $reserva->empresa->nombre;
            $pedidos[$reserva->id_pedido]['vehiculo'] = $reserva->vehiculo->placa;
            $pedidos[$reserva->id_pedido]['valorEmpresa'] = $reserva->valor->valor_empresa;
            $pedidos[$reserva->id_pedido]['valorVehiculo'] = $reserva->valor->valor_vehiculo;
            $pedidos[$reserva->id_pedido]['ruta'] = $reserva->valor->ruta;
            $pedidos[$reserva->id_pedido]['estado'] = $reserva->pedido->id_estado;
            $pedidos[$reserva->id_pedido]['peticion'] = $reserva->peticion->id;

            foreach ($reserva->direccionesCompletas as $keyDir => $direccion) {
                if ($direccion->id_user != '0') {
                    $pasajero = Profile::model()->find('user_id=:id_user', array(':id_user' => $direccion->id_user));
                    $pedidos[$reserva->id_pedido]['pasajeros'][$pasajero->user_id] = "{$pasajero->firstname} {$pasajero->lastname}";
                }
            }
        }
        $vehiculos = Vehiculo::model()->findAll();
        $rsp['vehiculos'] = $vehiculos;
        $rsp['pedidos'] = $pedidos;
        $rsp['selected'] = $selected;
        
        return $rsp;
    }
    public function actionAExcel() {
        header("Content-type: application/vnd.ms-excel; name='excel'");
        header("Content-Disposition: filename=reporte.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $_POST["contenido"];
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