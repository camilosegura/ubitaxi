<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionSavePos() {
            
            $seguimiento = new SeguimientoController('seguimiento',$this->module);
            $idPos = $seguimiento->actionCreateCar();
            if($idPos){
                $id_telefono = $_GET["Seguimiento"]["id_telefono"];
                $vehiculo = new VehiculoController('vehiculo', $this->module);
                if($vehiculo->actionUpdateCar($idPos, $id_telefono)){
                    $rsp["success"] = true;
                    echo json_encode($rsp);
                }
            }
        }
}