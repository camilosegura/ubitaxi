<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Ubicaciòn y asignaciòn de carros.">        
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/jquery.mobile-1.2.0.min.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/css/styles.css" rel="stylesheet">
        <link rel="shortcut icon" href="<?php echo Yii::app()->theme->getBaseUrl(); ?>/img/favicon.ico" type="image/x-icon" />
        
        <script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>        
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-1.8.2.min.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/geolocation.js"></script>
        <script src="<?php echo Yii::app()->baseUrl; ?>/js/pasajero.js"></script>
        <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/mobile.js"></script>
        <script src="<?php echo Yii::app()->theme->getBaseUrl(); ?>/js/jquery.mobile-1.2.0.min.js"></script>
    </head>
    <body> 
        <?php echo $content; ?>        
    </body>
</html>