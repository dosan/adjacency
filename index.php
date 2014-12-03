
<?php
session_start();

require 'app/libs/Session.php';
require 'app/config/config.php';
require 'app/libs/mainFunctions.php';
require 'app/libs/Controller.php';
require 'app/libs/Lang.php';
require 'app/libs/App.php';
// run the Application
$app = new App();