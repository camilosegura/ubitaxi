<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TPController
 *
 * @author camilo
 */
class TPController extends Controller {

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();
    public $empresaId;
    public $empresaNombre;
    public $roles;

    //put your code here
    public function init() {
        Yii::app()->theme = 'taxisPrivados';
        $this->roles = array_keys(Rights::getAssignedRoles(Yii::app()->user->Id));
        Yii::app()->user->checkAccess('account');
        if (Yii::app()->user->isSuperuser) {
            $this->empresaId = 0;
        } else {
            
        }                
        parent::init();
    }

}

?>
