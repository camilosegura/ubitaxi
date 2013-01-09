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
        if (is_int((int) $id)) {
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

    public function actionNuevoPasajero() {
        $model = new User;
        $id = $this->nuevoUsuario();
        if (is_int((int) $id)) {
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
        if (is_int((int) $id)) {
            $setVehiculo = new ConductorVehiculo;
            $setVehiculo->id_conductor = $id;
            $setVehiculo->id_vehiculo = $_POST['vehiculo'];
            $setVehiculo->save();
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
        $pasajero = new EmpresaUsuario;
        $pasajero->id_usuario = $id;
        $pasajero->id_empresa = $_POST['empresa'];
        $pasajero->save();

        $direccion = new Direccion;
        $direccion->id_user = $id;
        $direccion->direccion = "{$_POST['direccionTexto']} {$_POST['direccionNumero']} {$_POST['direccionCompl']} {$_POST['ciudad']}";
        $direccion->latitud = $_POST['latitud'];
        $direccion->longitud = $_POST['longitud'];
        $direccion->save();
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
                $model->activkey = UserModule::encrypting(microtime() . $model->password);

                if ($model->validate()) {
                    $model->password = UserModule::encrypting($model->password);
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