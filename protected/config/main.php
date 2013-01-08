<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Mi Taxi',
    'theme' => 'ubitaxi',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.coordenate.*',
        'application.modules.coordenate.components.*',
        'application.modules.destinos.controllers.*',
        'application.modules.destinos.models.*',
        'application.modules.ubi.controllers.*',
        'application.modules.ubi.models.*',
        'application.modules.user.controllers.*',
        'application.extensions.yii-mail.YiiMailMessage'
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'tracker',
        'destinos',
        'ubi',
        'personal',
        'seguridad',
        'taxisPrivados',
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123456',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => false,
        ),
        'user' => array(
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            //'registrationUrl' => array('/user/registration'),
            'registrationUrl' => array('/ubi/usuario/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            //'loginUrl' => array('/user/login'),
            'loginUrl' => array('/ubi/usuario/login'),
            # page after login
            'returnUrl' => array('/destinos/router'),
            # page after logout
            //'returnLogoutUrl' => array('/user/login'),
            'loginUrl' => array('/ubi/usuario/login'),
        ),
        'rights' => array(
            'install' => false,
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'class' => 'RWebUser',
            'allowAutoLogin' => true,
            //'loginUrl' => array('/user/login'),
            'loginUrl' => array('/ubi/usuario/login'),
        ),
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'urlSuffix' => '.html',
            'showScriptName' => false,
            'rules' => array(
                '' => '/destinos/router',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        /* ^.gViaIz(t%E
         * 1O@qVd]89+t@
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ),
         */
        // uncomment the following to use a MySQL database

        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=hogarsys_ubitaxi',
            //'connectionString' => 'mysql:host=localhost;dbname=Localizador',
            //'emulatePrepare' => true,
            'username' => 'hogarsys_ubitaxi',
            //'username' => 'root',
            'password' => 'NPK?LKbEr~g',
            //  'password' => 'ESPARTAN',
            //'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning,trace',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
        ),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType' => 'php',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'camilosegura@outlook.com',
    ),
);