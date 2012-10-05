<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Ubicaciòn y asignaciòn de carros.">
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>        
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/bootstrap.min.css" rel="stylesheet">        
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/styles.css" rel="stylesheet">
        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/img/favicon.ico" type="image/x-icon" />
    </head>

    <body>
        
        <header class="navbar navbar-inverse navbar-fixed-top">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <!-- <img class="hidden-desktop" src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/img/logo-photomd.png"> -->
            <nav class="nav-collapse collapse span10 main-wrapper" id="main-menu">
                <ul class="nav">
                    <li id="homelink"><a rel="external" href="/">Inicio</a></li>
                    <li id="aboutlink"><a rel="external" href="/">Nosotros</a></li>                                            
                    <li id="contactlink"><a rel="external" href="/">Contáctenos</a></li>
                    <li id="contactlink"><a rel="external" href="/">Cómo Pedir su Taxi</a></li>
                	<?php
                	if(Yii::app()->user->isGuest){
                	?>
                		<li id="loginlink"><a rel="external" href="/user/login">Ingresar</a></li>
                	<?php 
                	}else{
                	?>
                		<li id="logoutlink"><a rel="external" href="/">Salir (<?php echo Yii::app()->user->name; ?>)</a></li>
                	<?php 
                	}
                	
                	?>                        
                    
                    
                </ul>		       
            </nav>
        </header>

        <div id="wrapper" class="container-fluid span10 main-wrapper">
            <?php echo $content; ?>
        </div>

        <footer>
            <div class="container-fluid span10 main-wrapper">                
                <div class="span3">
                    <h5>ubitaxi.co</h5>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>                        
                    </ul>
                </div>
                <div class="span3">
                    <h5>Contacto y Soporte</h5>
                    <ul>
                        <li><a href="#">Contactenos</a></li>
                    </ul>
                    <hr>
                    <h5>Dirección y Teléfonos</h5>
                    <ul>
                        <li>Calle xxxxxx</li>
                        <li>Teléfono. (+57) (1) 5435345</li>
                        <li>Cel: (+57) (1) 5353442342</li>
                        <li>contacto@ubitaxi.co</li>
                        <li>Bogotá D.C. - Colombia</li>
                    </ul>
                </div>
                <div class="span3">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Términos de Uso de la Pagina WEB Polítcas de Privacidad</a></li>
                    </ul>
                </div>
            </div>
        </footer>

        <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/jquery-1.8.2.min.js"></script>
        <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/bootstrap.min.js"></script>
		<!-- <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/main.js"></script> -->
    </body>
</html>