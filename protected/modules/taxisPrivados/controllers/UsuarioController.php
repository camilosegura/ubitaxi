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

    // Uncomment the following methods and override them if needed

    public function filters() {
        // return the filter configuration for this controller, e.g.:
        return array(
            'rights',/*
            array(
                'class' => 'path.to.FilterClass',
                'propertyName' => 'propertyValue',
            ),*/
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