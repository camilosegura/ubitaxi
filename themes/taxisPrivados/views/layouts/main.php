<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Ubicaciòn y asignaciòn de carros.">
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>        
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/bootstrap.min.css" rel="stylesheet">                
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/ui-lightness/jquery-ui-1.9.2.custom.min.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/styles.css" rel="stylesheet">
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/img/favicon.ico" type="image/x-icon" />
    </head>

    <body>

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>           
                    <!-- <a class="brand" href="./index.html">Mi Empresa</a> -->
                    <nav class="nav-collapse collapse" id="main-menu">
                        <?php
                        
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Inicio', 'url' => array('/taxisPrivados')),
                                array('label' => 'Pedido', 'url' => array('#'), 'items' => array(
                                        array('label' => 'Listar', 'url' => array('#')),
                                        array('label' => 'Nuevo', 'url' => array('#'))
                                    ), 'itemOptions'=>array('class'=>'dropdown-submenu'),
                                ),
                                array('label' => 'Usuarios', 'url' => array('#'), 'items' => array(
                                        array('label' => 'Listar', 'url' => array('#')),
                                        array('label' => 'Nuevo', 'url' => array('#'))
                                    ), 'itemOptions'=>array('class'=>'dropdown-submenu'),
                                ),
                                array('label' => 'Empresas', 'url' => array('#'), 'items' => array(
                                        array('label' => 'Listar', 'url' => array('#')),
                                        array('label' => 'Nueva', 'url' => array('/taxisPrivados/empresa/nueva'))
                                    ), 
                                    'visible' => in_array("AdminOperador", $this->roles),
                                    'itemOptions'=>array('class'=>'dropdown-submenu'),
                                ),
                                array('label' => 'Reportes', 'url' => array('#'), 'visible' => in_array("AdminOperador", $this->roles)),
                                array('label' => 'Salir', 'url' => array('/user/logout')),
                            ),
                            'htmlOptions' => array('class' => 'nav'),
                            'submenuHtmlOptions' => array('class' => 'dropdown-menu menu-down')
                        ));
                        ?>
                    </nav>
                </div>
            </div>
        </div>

        <div id="wrapper" class="container main-wrapper container-background">
            <?php echo $content; ?>
        </div>

        <footer class="">
            <div class="container">                
                <p>Desarrollado por Mi Empresa</p>
            </div>
        </footer>

        <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-1.8.3.min.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/main.js"></script>
    </body>
</html>