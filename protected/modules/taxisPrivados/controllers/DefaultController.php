<?php

class DefaultController extends TPController {

    public function actionIndex() {
        if (Yii::app()->user->isGuest) {
            $model = new UserLogin;
            // collect user input data
            if (isset($_POST['UserLogin'])) {
                $model->attributes = $_POST['UserLogin'];
                // validate user input and redirect to previous page if valid
                if ($model->validate()) {
                    $seguimiento = new LoginController('login','user');
                    $seguimiento->lastViset();
                    //$this->lastViset();
                    if (Yii::app()->request->isAjaxRequest) {
                        
                    } else {
                        $this->redirect('taxisPrivados/usuario/router');
                    }
                }
            }
            // display the login form
            $this->render('/usuario/login', array('model' => $model));
        } else {
            $this->redirect('taxisPrivados/usuario/router');
        }
    }

}