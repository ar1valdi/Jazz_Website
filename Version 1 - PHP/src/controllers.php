<?php
    require_once('business.php');

function search(&$model){
    return 'search_view';
}

function przeladuj(&$model){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (isset($_POST['nazwa'])){
            $nazwa = $_POST['nazwa'];
            $imgs = showPrzeladowane($nazwa);
        }
    }
    $model['imgs'] = $imgs;
    return 'przeladuj_view';
}

function login(&$model){
    $errMsg = "";
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['login']) && isset($_POST['password'])){
            $login = $_POST['login'];
            $pass = $_POST['password'];

            if(loginMechanism($login, $pass, $errMsg)){
                $_SESSION['errMsg'] = $errMsg;
                return 'redirect: /';
            }  
            $_SESSION['errMsg'] = $errMsg;
            return 'redirect: login';
        }
    }
    else{
        if(isset($_SESSION['errMsg'])){
            $errMsg = $_SESSION['errMsg'];
            unset($_SESSION['errMsg']);
        }
    }
    
    $model['errMsg'] = $errMsg;
    return 'login_view';
}

function register(&$model){
    $errMsg = "";
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['email']) && isset($_POST['login']) && isset($_POST['password']) && isset($_POST['rPassword'])){
            $mail = $_POST['email'];
            $login = $_POST['login'];
            $password = $_POST['password'];
            $rPassword = $_POST['rPassword'];
            
            if (!($password === $rPassword)) {
                $errMsg = "Wprowadzone hasła się różnią!";
                $_SESSION['errMsg'] = $errMsg;
                return 'redirect: register';
            }
                
            if(!(loginUsed($login))){
                if(addUser($mail, $login, $password)){
                    return 'redirect: login';
                }
                $errMsg = "Nie udało się dodać użytkownika";
            }
            else{
                $errMsg = "Wprowadzony login jest zajęty!";
                $_SESSION['errMsg'] = $errMsg;
                return 'redirect: register';
            }
        }
    }
    else{
        if(isset($_SESSION['errMsg'])){
            $errMsg = $_SESSION['errMsg'];
            unset($_SESSION['errMsg']);
        }
    }

    $model['errMsg'] = $errMsg;
    return 'register_view';
}

function galeria(&$model)
{
    $errMsg = "";
    $imgTable = [];
    $fillLayout = "";
    $goForward = "";
    $goBack = "";
    $user = "";
    userLogin($user);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        if ((isset($_FILES['sentPic'])) && (isset($_POST['znakWodny'])) && (isset($_POST['autor'])) && (isset($_POST['tytul']))) {
            $sentFile = $_FILES['sentPic'];
            $watermark = $_POST['znakWodny'];
            $tytul = $_POST['tytul'];
            $autor = $_POST['autor'];

            if (uploadImg($sentFile, $watermark, $tytul, $autor, $errMsg)) {
                addWatermark($sentFile, $watermark);
                createMiniature($sentFile);
            }

            $isMore = false;
            $imgTable = showImages(1, $isMore, $fillLayout, []);
            
            if ($isMore){ $goForward = createForwardButton(1, 'galeria'); }
            
            $_SESSION['errMsg'] = $errMsg;
            return 'redirect: galeria';
        }

    } else {
        if (isset($_GET['site'])) { $actSite = $_GET['site']; }
        else { $actSite = 1;}
        if (isset($_SESSION['errMsg'])) { 
            $errMsg = $_SESSION['errMsg']; 
            unset($_SESSION['errMsg']);
        }

        $isMore = false;
        $imgTable = showImages($actSite, $isMore, $fillLayout, []);
        if (!($actSite == 1)) { $goBack = createBackButton($actSite, 'galeria'); } 
        if ($isMore){ $goForward = createForwardButton($actSite, 'galeria'); }
    }

    $model['user'] = $user;
    $model['button'] = $goBack . $goForward;
    $model['fillLayout'] = $fillLayout;
    $model['imgTable'] = $imgTable;
    $model['errMsg'] = $errMsg;
    return 'galeria_view';
}

function remember(&$model){
    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $checked = [];
        $unchecked = [];
        $i = 1;
        while(true){
            $name = 'src' . $i;
            $name2 = 'usrc' . $i;
            
            if (!(isset($_GET[$name2])) && !(isset($_GET[$name]))){
                break;
            }

            if(isset($_GET[$name])){
                array_push($checked, $_GET[$name]);
            }
            
            if (isset($_GET[$name2])) {
                array_push($unchecked, $_GET[$name2]);
            }
            
            
            $i++;
        }
        addToSession($checked, $unchecked);
    }
    return "redirect: own_gallery";
}

function own_gallery(&$model){
    $imgTable = [];
    $isMore = false;
    $fillLayout = "";
    $goForward = "";
    $goBack = "";
    
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_SESSION['remImg'])){
        if (isset($_GET['site'])) { $actSite = $_GET['site']; }
        else { $actSite = 1;}

        $imgTable = showOwnGallery($actSite, $isMore, $fillLayout);
        if (!($actSite == 1)) { $goBack = createBackButton($actSite, 'own_gallery'); } 
        if ($isMore){ $goForward = createForwardButton($actSite, 'own_gallery'); }
    }

    $model['button'] = $goBack . $goForward;
    $model['fillLayout'] = $fillLayout;
    $model['imgTable'] = $imgTable;
    return 'own_gallery_view';
}

function logout(&$model){
    session_destroy();
    session_unset();
    session_start();
    $_SESSION['errMsg'] = 'Wylogowano pomyślnie';
    return 'redirect: /';
}

function index(&$model){
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if (isset($_SESSION['errMsg'])) { 
            $model['errMsg'] = $_SESSION['errMsg'];
            unset($_SESSION['errMsg']);
        }
    }
    return 'index_view';
}

function albumy(&$model){
    return 'albumy_view';
}

function hall(&$model){
    return 'hall_view';
}

function instrumenty(&$model){
    return 'instrumenty_view';
}

function kontakt(&$model){
    return 'kontakt_view';
}

function pass(&$model){
    return 'pass_view';
}

function wes(&$model){
    return 'wes_view'; 
}
?>