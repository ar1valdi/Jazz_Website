<?php
require_once 'business.php';
function build_response($view, $model){
    if (strpos($view, 'redirect: ') === 0){
        $url = substr($view, strlen('redirect: '));
        $getData = array_to_get($model);
       // printf($_SESSION['errMsg']);
       // printf($url.'?'.$getData);
        header("Location: ".$url.'?'.$getData);
        exit;
    }
    else {
        render($view, $model);
    }
}

function render($view_name, $model){
    extract($model);
    include '../views/' . $view_name . '.php';
}
?>