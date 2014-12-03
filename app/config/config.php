<?php

define('DEVELOPMENT_ENVIRONMENT', true);
define('URL', 'http://localhost/');

// Папка сайта
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'].'/');
define('IMAGES', $_SERVER['DOCUMENT_ROOT'].'/public/img/');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'sandor');
define('DB_USER', 'root');
define('DB_PASS', 'password1');
define('SES_PR' , 'test_task');

define('CONNECTION_FAILED', 'Database connection could not be established.');
define('APP_CONTROL' , 'app/controller/');
define('VIEWS_PATH', 'app/views/');
define('PASS_COM_LIB', "app/libs/password_compatibility_library.php");
define('IMG_PATH' , URL.'public/img/');
define('CSS_PATH' , URL.'public/css/');
