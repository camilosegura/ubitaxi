<?php

class UsuarioController extends Controller {

    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'rights',
        );
    }

    public function allowedActions() {
        return 'index, guest, hacerPedido';
    }

    public function actionGuest() {
        $this->render('guest');
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogged() {
        $this->render('logged');
    }

    public function actionHacerPedido() {
        $idUser = 0;
        if (Yii::app()->user->isGuest) {
            $user = User::model()->find("email=:email", array(':email' => $_POST["email"]));
            if (is_null($user)) {
                $parts = explode("@", $_POST["email"]);
                $userName = $parts[0];
                $_POST["User"]["username"] = $userName;
                $_POST["User"]["password"] = 123456;
                $_POST["User"]["email"] = $_POST["email"];
                
                $_POST["Profile"]["firstname"] = $_POST["nombre"];
                $_POST["Profile"]["lastname"] = "Usuario";
                $_POST["Profile"]["nacimiento"] = "2012-10-10";
                $_POST["Profile"]["celular"] = $_POST["celular"];
                $_POST["Profile"]["ciudad"] = "Bogotá";
                $_POST["Profile"]["direccion"] = $_POST["direccion"];
                $idUser = $this->register();
            } else {
                $idUser = $user->id;
            }
        } else {
            $idUser = Yii::app()->user->id;
        }

        $_POST['Pedido']['id_estado'] = 0;
        $_POST['Pedido']['id_pasajero'] = $idUser;
        $_POST['Pedido']['time'] = time();
        $_POST['Pedido']['direccion_origen'] = $_POST["direccion"];
        $_POST['Pedido']['latitud'] = $_POST["latitud"];
        $_POST['Pedido']['longitud'] = $_POST["longitud"];
        $_POST['Pedido']['id_operador'] = 0;

        $pedido = new PedidoController("pedido", "ubi");
        $rsp["id_pedido"] = $pedido->actionCreateUser();

        echo json_encode($rsp);
    }

    private function register() {
        $model = new User;
        $profile = new Profile;
                
        $model->attributes = $_POST['User'];
        $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
        if ($model->validate() && $profile->validate()) {
            echo "validate";
            $soucePassword = $model->password;
            $model->activkey = UserModule::encrypting(microtime() . $model->password);
            $model->password = UserModule::encrypting($model->password);            
            $model->superuser = 0;
            $model->status = ((Yii::app()->getModule("user")->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

            if ($model->save()) {
                Rights::assign('Cliente', $model->id);
                $profile->user_id = $model->id;
                $profile->save();
                if (Yii::app()->getModule("user")->sendActivationMail) {
                    $activation_url = $this->createAbsoluteUrl('/user/activation/activation', array("activkey" => $model->activkey, "email" => $model->email));
                    UserModule::sendMail($model->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                }

                if ((Yii::app()->getModule("user")->loginNotActiv || (Yii::app()->getModule("user")->activeAfterRegister && Yii::app()->getModule("user")->sendActivationMail == false)) && Yii::app()->getModule("user")->autoLogin) {
                    $identity = new UserIdentity($model->username, $soucePassword);
                    $identity->authenticate();
                    Yii::app()->user->login($identity, 0);
                } else {
                    if (!Yii::app()->getModule("user")->activeAfterRegister && !Yii::app()->getModule("user")->sendActivationMail) {
                        Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                    } elseif (Yii::app()->getModule("user")->activeAfterRegister && Yii::app()->getModule("user")->sendActivationMail == false) {
                        Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->getModule("user")->loginUrl))));
                    } elseif (Yii::app()->getModule("user")->loginNotActiv) {
                        Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
                    } else {
                        Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email."));
                    }
                }
                return $model->id;
            }
        } else{
            $rsp["success"] = false;
            $rsp["user"]=$model->getErrors();
            $rsp["profile"]=$profile->getErrors();
            echo json_encode($rsp);
            return false;                                                
            
        }
            $profile->validate();
    }

    // Uncomment the following methods and override them if needed
    /*
      public function filters()
      {
      // return the filter configuration for this controller, e.g.:
      return array(
      'inlineFilterName',
      array(
      'class'=>'path.to.FilterClass',
      'propertyName'=>'propertyValue',
      ),
      );
      }

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