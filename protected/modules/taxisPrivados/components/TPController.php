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

    /**
     *
     * @var type array se guarda un arreglo con las empresas relacionadas a los usuarios, 
     * las key del array son los ID de las empresas
     */
    public $empresas = array();

    /**
     *
     * @var type Array con los roles del usuario
     */
    public $roles = array();

    //put your code here
    public function init() {
        Yii::app()->theme = 'taxisPrivados';
        $emp = array();
        if (!Yii::app()->user->isGuest) {
            $this->roles = array_keys(Rights::getAssignedRoles(Yii::app()->user->Id));
            if (in_array('AdminOperador', $this->roles)) {
                $emp = Empresa::model()->findAll();
            } else {
                $emp = Empresa::model()->with('usuario')->findAll('usuario.id_usuario=:id_usuario', array(':id_usuario' => Yii::app()->user->id));
            }
            foreach ($emp as $key => $empresa) {
                $this->empresas[$empresa->id] = $empresa->nombre;
            }            
        }

        parent::init();
    }

}

?>
