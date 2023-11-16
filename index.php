<?php 

require_once 'models/UsersModel.php';
require_once 'models/WalletModel.php';
require_once 'models/WalletUserModel.php';
require_once 'views/view.php';
require_once 'controller/AuthController.php';
require_once 'controller/WalletController.php';
require_once 'controller/WalletUserController.php';
require_once 'database/Connection.php';

$db  = new DatabaseConnection();
$model = new UsersModel($db);
$view = new View();
$controller = new AuthController($model, $view);

$controller->handleRequest();