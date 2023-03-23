<?php
session_start();
require_once '../routing.php';
require_once '../controllers.php';
require_once '../dispatcher.php';

$action_url = $_GET['action'];

$controller_name = $routing[$action_url];

$model = [];
$view_name = $controller_name($model);

build_response($view_name, $model);
?>