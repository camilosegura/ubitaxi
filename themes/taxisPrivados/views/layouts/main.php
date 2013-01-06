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
        
        <header class="navbar navbar-inverse navbar-fixed-top">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <!-- <img class="hidden-desktop" src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/img/logo-photomd.png"> -->
            <nav class="nav-collapse collapse span10 main-wrapper" id="main-menu">
                <ul class="nav">
                    <?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
                    
                </ul>		       
            </nav>
        </header>
        
        <div id="wrapper" class="container main-wrapper">
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