<?php

class RouterController extends Controller
{
	public function actionIndex()
	{
            
            
         $roles = Rights::getAssignedRoles(Yii::app()->user->Id);
        $count = count($roles);
        
        if ($count > 1) {
            
        } else {           
            foreach ($roles as $key => $role) {                
                $this->redirect($this->getUrlRole($role->name));
            }
        }    
            		
	}

        

    private function getUrlRole($role) {
        $url = "";
        switch ($role) {
            case "Admin":
                $url = "/user/profile";
                break;
            case "Chofer":
                $url = "/ubi/taxi/control.html";
                break;
            case "Cliente":
                $url = "/ubi/usuario/logged.html";
                break;
            default:
                break;
        }
        return $url;
    }
        
	// Uncomment the following methods and override them if needed
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(/*
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
                 */
                    'rights',
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