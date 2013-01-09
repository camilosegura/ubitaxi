<?php

class PedidoController extends TPController {

    public function actionIndex() {
        $this->render('index');
    }

    public function actionListar() {
        $this->render('listar');
    }

    public function actionNuevo() {
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
            //var_dump($emPedido->getErrors());
        }
        $this->render('nuevo', array('empresas' => $this->empresas));
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