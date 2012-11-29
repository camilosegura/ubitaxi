<?php

class UsuarioController extends Controller {

    public $mobile;

    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'rights',
        );
    }

    private function mobile() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4)));
    }

    public function allowedActions() {
        return 'index, guest, hacerPedido, loginCar, logoutCar, login, registration, captcha, activation';
    }

    public function actionGuest() {
        if ($this->mobile()) {
            Yii::app()->theme = 'mobile';
            $this->render('guest_mobile');
        } else {
            $this->render('guest');
        }
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionLogged() {
        $direccion = Direccion::model()->findAll("id_user=:id_user", array(":id_user" => Yii::app()->user->id));
        if ($this->mobile()) {
            Yii::app()->theme = 'mobile';
            $this->render('logged_mobile', array('direccion' => $direccion, 'historial' => $this->getHistory()));
        } else {
            $this->render('logged');
        }
    }

    private function getHistory() {
        return $pedido = Pedido::model()->with('finalizado')->findAll("id_pasajero=:id_pasajero"
                , array(':id_pasajero' => Yii::app()->user->id));
    }

    public function actionHacerPedido() {
        $idUser = 0;
        if (Yii::app()->user->isGuest) {
            $user = User::model()->find("email=:email", array(':email' => $_GET["email"]));
            if (is_null($user)) {
                $parts = explode("@", $_GET["email"]);
                $userName = $parts[0];
                $_POST["User"]["username"] = $userName;
                $_POST["User"]["password"] = 123456;
                $_POST["User"]["email"] = $_GET["email"];

                $_POST["Profile"]["firstname"] = $_GET["nombre"];
                $_POST["Profile"]["lastname"] = "Usuario";
                $_POST["Profile"]["nacimiento"] = "2012-10-10";
                $_POST["Profile"]["celular"] = $_GET["celular"];
                $_POST["Profile"]["ciudad"] = "Bogotá";
                $_POST["Profile"]["direccion"] = $_GET["direccion"];
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
        $_POST['Pedido']['direccion_origen'] = $_GET["direccion"];
        $_POST['Pedido']['latitud'] = $_GET["latitud"];
        $_POST['Pedido']['longitud'] = $_GET["longitud"];
        $_POST['Pedido']['id_operador'] = 0;

        $pedido = new PedidoController("pedido", "ubi");
        $rsp["id_pedido"] = $pedido->actionCreateUser();
        $rsp["msg"] = "Se ha asignado un Taxi,  por favor revise el correo {$_GET["email"]}";
        $this->sendPedidoMail($_GET["email"], $rsp["id_pedido"]);
        echo json_encode($rsp);
    }

    public function actionHacerPedidoLogged() {
        $direccion = Direccion::model()->findByPk($_GET["idDir"]);
        $user = User::model()->findByPk(Yii::app()->user->id);
        $_GET["direccion"] = $direccion->direccion;
        $_GET["email"] = $user->email;
        $_GET["latitud"] = $direccion->latitud;
        $_GET["longitud"] = $direccion->longitud;
        $this->actionHacerPedido();
    }

    private function sendPedidoMail($mail, $pedido) {
        $urlPedido = $this->createAbsoluteUrl("usuario/pedido", array('idp'=>$pedido));
        $message = new YiiMailMessage;
        $message->setBody("Entregue la siguiente clave al taxista <span>{$clave}</span>.<br>Por favor revise el estado de su pedido en <a href='{$urlPedido}'>{$urlPedido}</a>", 'text/html');
        $message->subject = 'Confirmación de Taxi';
        $message->addTo($mail);
        $message->from = Yii::app()->params['adminEmail'];
        
        Yii::app()->mail->send($message);
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
        } else {
            $rsp["success"] = false;
            $rsp["user"] = $model->getErrors();
            $rsp["profile"] = $profile->getErrors();
            echo json_encode($rsp);
            return false;
        }
        $profile->validate();
    }

    public function actionLoginCar() {
        $rsp['guest'] = Yii::app()->user->isGuest;
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_GET['username'])) {
                $model->attributes = $_GET['password'];
                $model->username = $_GET['username'];
                $model->password = $_GET['password'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $this->lastViset();
                    $rsp["success"] = true;
                    echo json_encode($rsp);
                    exit();
                }
            }
            // display the login form
            $rsp["success"] = false;
            echo json_encode($rsp);
            exit();
        } else {
            $rsp["success"] = true;
            echo json_encode($rsp);
            exit();
        }
    }

    private function lastViset() {
        $lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
        $lastVisit->lastvisit = time();
        $lastVisit->save();
    }

    public function actionLogoutCar() {
        Yii::app()->user->logout();
    }

    public function actionLogin() {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                Yii::app()->getModule('user');
                if ($model->validate()) {
                    Yii::app()->controller->module->rememberMeTime = Yii::app()->getModule('user')->rememberMeTime;
                    $user = new LoginController('login', 'user');
                    $user->lastViset();
                    $this->redirect('/destinos/router');
                }
            }
            // display the login form
            if ($this->mobile()) {
                Yii::app()->theme = 'mobile';
                $this->render('login_mobile');
            } else {
                $this->render('guest');
            }
        }
        else
            $this->redirect('/destinos/router');
    }

    public function actionAgregarDireccion() {
        $direccion = new Direccion();
        $direccion->id_user = Yii::app()->user->id;
        $direccion->latitud = $_GET["lat"];
        $direccion->longitud = $_GET["lng"];
        $direccion->direccion = $_GET["dir"];
        $direccion->save();
        $rsp["id"] = $direccion->id;
        echo json_encode($rsp);
    }

    public function actionGetDireccion() {
        $direccion = Direccion::model()->findByPk($_GET["idDir"], "id_user=:id_user", array(":id_user" => Yii::app()->user->id));
        $rsp["lat"] = $direccion->latitud;
        $rsp["lng"] = $direccion->longitud;
        echo json_encode($rsp);
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
        );
    }

    /**
     * Registration user
     */
    public function actionRegistration() {
        $model = new RegistrationForm;
        $profile = new Profile;
        $profile->regMode = true;

        // ajax validator
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'registration-form') {
            echo UActiveForm::validate(array($model, $profile));
            Yii::app()->end();
        }

        if (Yii::app()->user->id) {
            $this->redirect('/destinos/router');
        } else {
            if (isset($_POST['RegistrationForm'])) {
                $model->attributes = $_POST['RegistrationForm'];
                $profile->attributes = ((isset($_POST['Profile']) ? $_POST['Profile'] : array()));
                if ($model->validate() && $profile->validate()) {
                    $soucePassword = $model->password;
                    $model->activkey = UserModule::encrypting(microtime() . $model->password);
                    $model->password = UserModule::encrypting($model->password);
                    $model->verifyPassword = UserModule::encrypting($model->verifyPassword);
                    $model->superuser = 0;
                    $model->status = ((Yii::app()->getModule('user')->activeAfterRegister) ? User::STATUS_ACTIVE : User::STATUS_NOACTIVE);

                    if ($model->save()) {
                        Rights::assign('Cliente', $model->id);
                        $profile->user_id = $model->id;
                        $profile->save();
                        if (Yii::app()->getModule('user')->sendActivationMail) {
                            $activation_url = $this->createAbsoluteUrl('/ubi/usuario/activation', array("activkey" => $model->activkey, "email" => $model->email));
                            UserModule::sendMail($model->email, UserModule::t("You registered from {site_name}", array('{site_name}' => Yii::app()->name)), UserModule::t("Please activate you account go to {activation_url}", array('{activation_url}' => $activation_url)));
                        }

                        if ((Yii::app()->getModule('user')->loginNotActiv || (Yii::app()->getModule('user')->activeAfterRegister && Yii::app()->getModule('user')->sendActivationMail == false)) && Yii::app()->getModule('user')->autoLogin) {
                            $identity = new UserIdentity($model->username, $soucePassword);
                            $identity->authenticate();
                            Yii::app()->user->login($identity, 0);
                            $this->redirect(Yii::app()->getModule('user')->returnUrl);
                        } else {
                            if (!Yii::app()->getModule('user')->activeAfterRegister && !Yii::app()->getModule('user')->sendActivationMail) {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
                            } elseif (Yii::app()->getModule('user')->activeAfterRegister && Yii::app()->getModule('user')->sendActivationMail == false) {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please {{login}}.", array('{{login}}' => CHtml::link(UserModule::t('Login'), Yii::app()->getModule('user')->loginUrl))));
                            } elseif (Yii::app()->getModule('user')->loginNotActiv) {
                                Yii::app()->user->setFlash('registration', UserModule::t("Thank you for your registration. Please check your email or login."));
                            } else {
                                Yii::app()->user->setFlash('registration', UserModule::t("Gracias por registrarse. Por favor revise su correo."));
                            }
                            $this->refresh();
                        }
                    }
                }
                else
                    $profile->validate();
            }
            if ($this->mobile()) {
                Yii::app()->theme = 'mobile';
                $this->render('registration_mobile', array('model' => $model, 'profile' => $profile));
            } else {
                $this->render('guest');
            }
        }
    }

    /**
     * Activation user account
     */
    public function actionActivation() {
        $mobile = "";
        if ($this->mobile()) {
            Yii::app()->theme = 'mobile';
            $mobile = "_mobile";
        }
        $email = $_GET['email'];
        $activkey = $_GET['activkey'];
        if ($email && $activkey) {
            $find = User::model()->notsafe()->findByAttributes(array('email' => $email));
            if (isset($find) && $find->status) {
                $this->render('/user/message', array('content' => 'Su cuenta está activa', 'continue' => $this->createAbsoluteUrl('/ubi/usuario/login')));
            } elseif (isset($find->activkey) && ($find->activkey == $activkey)) {
                $find->activkey = UserModule::encrypting(microtime());
                $find->status = 1;
                $find->save();
                $this->render('activation' . $mobile, array('content' => "Su cuenta se ha activado", 'continue' => $this->createAbsoluteUrl('/ubi/usuario/login')));
            } else {
                $this->render('/user/message', array('title' => UserModule::t("User activation"), 'content' => UserModule::t("Incorrect activation URL.")));
            }
        } else {
            $this->render('/user/message', array('title' => UserModule::t("User activation"), 'content' => UserModule::t("Incorrect activation URL.")));
        }
    }

    public function actionGetPedido() {
        if (isset($_GET["est"]) && $_GET["est"] == "activo") {
            $pedido = Pedido::model()->findAll("(id_estado = 0 OR id_estado = 1) AND id_pasajero=:id_pasajero", array(':id_pasajero' => Yii::app()->user->id));
            rsort($pedido);
            foreach ($pedido as $key => $ped) {
                $rsp[] = $ped->attributes;
            }
            echo json_encode($rsp);
        }
    }

    public function actionPedido() {
        $pedido = Pedido::model()->findByPk($_GET["idp"]);
        if ($this->mobile()) {
            Yii::app()->theme = 'mobile';
            $this->render('pedido_activo_mobile', array('pedido' => $pedido));
        } else {
            $this->render('guest');
        }
    }

    public function actionCancelarPedido() {
        $pedido = Pedido::model()->findByPk($_GET["id"], "id_pasajero=:id_pasajero", array(':id_pasajero' => Yii::app()->user->id));
        $pedido->id_estado = 5;
        if ($pedido->save()) {
            $rsp["est"] = 5;
            $rsp["success"] = true;
            echo json_encode($rsp);
        } else {
            $rsp["success"] = false;
            echo json_encode($rsp);
        }
    }

    public function actionEnviarMensaje() {
        $comentario = new PedidoComentario();
        $comentario->attributes = $_GET["PedidoComentario"];
        $comentario->save();
        $rsp["success"] = true;
        echo json_encode($rsp);
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