<?php

class UsuarioController extends TPController {

    public function actionIndex() {
        $url = "/user/logout";
        if (!Yii::app()->user->isGuest) {
            $url = "/taxisPrivados/usuario/router";
        }
        $this->redirect($url);
    }

    public function actionRouter() {
        $roles = Rights::getAssignedRoles(Yii::app()->user->Id);
        $count = count($roles);
        $url = "";
        if ($count > 1) {
            
        } else {
            foreach ($roles as $key => $role) {

                switch ($role->name) {
                    case "Admin":
                        $url = "/user/profile";
                        break;
                    case "AdminOperador":
                        $url = "/taxisPrivados/admin";
                        break;
                    case "Empresa":
                        $url = "/taxisPrivados/pedido/nuevo";
                        break;
                    default:
                        $url = "/user/logout";
                        break;
                }
                $this->redirect($url);
            }
        }
    }

    public function actionNuevoAdministrador() {
        $model = new User;
        $id = $this->nuevoUsuario();
        if (is_int((int) $id) && !is_array($id)) {
            $this->postNuevo($id);
            Rights::assign("Empresa", $id);
        } else {
            $model->addErrors($id);
        }
        $this->render('nuevoAdministrador', array(
            'model' => $model,
            'empresas' => $this->empresas,
        ));
    }

    public function actionNuevoCoordinador() {
        $model = new User;
        $empresas = array();
        $id = $this->nuevoUsuario();
        if (is_int((int) $id) && !is_array($id)) {
            foreach ($_POST['empresa'] as $key => $idEmpresa) {
                $this->setEmpresaUsuario($id, $idEmpresa);
            }
            Rights::assign("CoordinadorOperador", $id);
        } else {
            $model->addErrors($id);
        }
        $empresa = Empresa::model()->findAll();
        foreach ($empresa as $key => $emp) {
            $empresas[$emp->id] = $emp->nombre;
        }
        $this->render('nuevoCoordinador', array(
            'model' => $model,
            'empresas' => $empresas,
        ));
    }

    public function actionNuevoPasajero() {
        $model = new User;
        $id = $this->nuevoUsuario();
        if (is_int((int) $id) && !is_array($id)) {
            $this->postNuevo($id);
        } else {
            $model->addErrors($id);
        }
        $this->render('nuevoPasajero', array(
            'model' => $model,
            'empresas' => $this->empresas,
        ));
    }

    public function actionNuevoConductor() {
        $vehiculo = array();
        $model = new User;
        $id = $this->nuevoUsuario();
        if (is_int((int) $id) && !is_array($id)) {
            $setVehiculo = new ConductorVehiculo;
            $setVehiculo->id_conductor = $id;
            $setVehiculo->id_vehiculo = $_POST['vehiculo'];
            $setVehiculo->save();

            $currentVehiculo = Vehiculo::model()->findByPk($_POST['vehiculo']);
            $currentVehiculo->id_conductor = $id;
            $currentVehiculo->save();

            Rights::assign("Chofer", $id);
        } else {
            $model->addErrors($id);
        }
        $vehiculos = OperadorVehiculo::model()->with('vehiculo')->findAll('id_operador=:id_operador', array(':id_operador' => 1));
        if (!empty($vehiculos)) {
            foreach ($vehiculos as $key => $veh) {
                $vehiculo[$veh->id_vehiculo] = $veh->vehiculo->placa;
            }
        }
        $this->render('nuevoConductor', array(
            'model' => $model,
            'vehiculo' => $vehiculo,
        ));
    }

    private function postNuevo($id) {
        $this->setEmpresaUsuario($id, $_POST['empresa']);
        return $this->setDireccion($id, "{$_POST['direccionTexto']} {$_POST['direccionNumero']} {$_POST['direccionCompl']}, {$_POST['ciudad']}", $_POST['latitud'], $_POST['longitud']);
    }

    private function setDireccion($id, $dir, $latitud, $longitud) {
        $direccion = new Direccion;
        $direccion->id_user = $id;
        $direccion->direccion = $dir;
        $direccion->latitud = $latitud;
        $direccion->longitud = $longitud;

        if ($direccion->save()) {
            return $direccion->id;
        } else {
            return $direccion->getErrors();
        }
    }

    private function setEmpresaUsuario($idUser, $idEmpresa) {
        $pasajero = new EmpresaUsuario;
        $pasajero->id_usuario = $idUser;
        $pasajero->id_empresa = $idEmpresa;
        $pasajero->save();
    }

    public function actionNuevoArchivo() {

        $rsp['pasajeros']['error'] = false;
        $url = "http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=";
        // get a reference to the path of PHPExcel classes 
        $phpExcelPath = Yii::getPathOfAlias('ext.phpexcel.Classes');

        // Turn off our amazing library autoload 
        spl_autoload_unregister(array('YiiBase', 'autoload'));

        //
        // making use of our reference, include the main class
        // when we do this, phpExcel has its own autoload registration
        // procedure (PHPExcel_Autoloader::Register();)
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');

        $objPHPExcel = PHPExcel_IOFactory::load($_FILES["pasajerosExcel"]["tmp_name"]);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        spl_autoload_register(array('YiiBase', 'autoload'));

        unset($sheetData[1]);
        foreach ($sheetData as $key => $row) {
            if (str_replace(' ', '', $row['A']) !== '' && (str_replace(' ', '', $row['B']) !== '' || str_replace(' ', '', $row['C']) !== '' || str_replace(' ', '', $row['E']) !== '')) {
                
                $nombre = ucwords($row['A']);
                $direccion = ucfirst("{$row['B']}, {$row["C"]}, {$row['E']}");
                $usernames = str_split(strtolower("$nombre{$row["D"]}"));
                $username = '';
                foreach ($usernames as $key => $letra) {
                    if (preg_match('/^[A-Za-z0-9_]+$/u', $letra)) {
                        $username .= $letra;
                    }
                }

                $email = "$username@argesys.co";

                $direccionCompleta = str_replace(" ", "+", "{$direccion}, Colombia");
                $getUrl = "{$url}{$direccionCompleta}";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $getUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $json = curl_exec($ch);
                curl_close($ch);

                $respuesta = json_decode($json);

                $_POST['User']['password'] = 123456;
                $_POST['Profile']['firstname'] = "{$nombre}";
                $_POST['Profile']['lastname'] = ".  ";
                $_POST['empresa'] = $_POST['idEmpresa'];
                $_POST['direccionTexto'] = $direccion;
                $_POST['direccionNumero'] = '';
                $_POST['direccionCompl'] = '';
                $_POST['ciudad'] = '';
                $_POST['latitud'] = (isset($respuesta->results[0]->geometry->location->lat)) ? $respuesta->results[0]->geometry->location->lat : 0;
                $_POST['longitud'] = (isset($respuesta->results[0]->geometry->location->lng)) ? $respuesta->results[0]->geometry->location->lng : 0;

                $user = User::model()->find('email=:email', array(':email' => $email));

                if (is_null($user)) {
                    $_POST['User']['username'] = $username;
                    $_POST['User']['email'] = $email;
                    $id = $this->nuevoUsuario();
                    if (is_int((int) $id) && !is_array($id)) {
                        $idDireccion = $this->postNuevo($id);
                        $rsp['pasajeros'][$id]['nombre'] = $nombre;
                        $rsp['pasajeros'][$id]['direccion'] = $direccion;
                        $rsp['pasajeros'][$id]['idDireccion'] = $idDireccion;
                        $rsp['success'] = true;
                    } else {
                        $rsp['errors'][] = $id;
                    }
                } else {
                    $getDireccion = Direccion::model()->find('id_user=:id_user AND direccion =:direccion', array(':id_user' => $user->id, ':direccion' => $direccion));
                    if (is_null($getDireccion)) {
                        $idDireccion = $this->setDireccion($user->id, $direccion, $_POST['latitud'], $_POST['longitud']);
                    } else {
                        $idDireccion = $getDireccion->id;
                    }
                    $rsp['pasajeros'][$user->id]['nombre'] = $nombre;
                    $rsp['pasajeros'][$user->id]['direccion'] = $direccion;
                    $rsp['pasajeros'][$user->id]['idDireccion'] = $idDireccion;
                    $rsp['success'] = true;
                }
            }else{
                $rsp['pasajeros']['error'] = true;
                $rsp['pasajeros']['errores'][] = "Fila $key, Nombre: {$row['A']}";
            }
        }
        echo json_encode($rsp);
    }

    private function nuevoUsuario() {
        $model = new User;
        $profile = new Profile;
        if (isset($_POST['User'])) {
            $usuario = User::model()->find('username=:username OR email=:email', array(':username' => $_POST['User']['username'], ':email' => $_POST['User']['email']));

            if (is_null($usuario)) {
                $model->username = $_POST['User']['username'];
                $model->email = $_POST['User']['email'];
                $model->superuser = 0;
                $model->status = 1;
                $model->activkey = UserModule::encrypting(microtime() . $_POST['User']['password']);

                if ($model->validate()) {
                    $model->password = UserModule::encrypting($_POST['User']['password']);
                    if ($model->save()) {
                        $profile->firstname = $_POST['Profile']['firstname'];
                        $profile->lastname = $_POST['Profile']['lastname'];
                        $profile->user_id = $model->id;
                        $profile->nacimiento = '2000-00-01';
                        $profile->celular = 0;
                        $profile->ciudad = 'Bogotá';
                        $profile->direccion = 'Bogota';
                        $profile->save();
                        return $model->id;
                    }
                }
            } else {
                if ($usuario->username == $_POST['User']['username']) {
                    $model->addError('username', 'Ya existe');
                }
                if ($usuario->username == $_POST['User']['email']) {
                    $model->addError('email', 'Ya existe');
                }
            }
        }

        return $model->getErrors();
    }

    // Uncomment the following methods and override them if needed

    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'rights', /*
                  array(
                  'class' => 'path.to.FilterClass',
                  'propertyName' => 'propertyValue',
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