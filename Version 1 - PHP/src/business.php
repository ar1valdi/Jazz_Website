<?php
require_once '../../vendor/autoload.php'; 
use MongoDB\BSON\ObjectID;

if (!function_exists('str_contains')) {
    function str_contains($haystack, $needle) {
        return $needle !== '' && strpos($haystack, $needle) !== false;
    }
}

function get_db(){
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]
    );
    $db = $mongo->wai;
    return $db;
}

function addToSession($add, $delete){
    if(!(isset($_SESSION['remImg']))){
        $_SESSION['remImg'] = [];
    }

    foreach($add as $e){
        $index = array_search($e, $_SESSION['remImg']);
        if ($index === false) {
            array_push($_SESSION['remImg'], $e);
        }
    }

    foreach($delete as $e){
        $index = array_search($e, $_SESSION['remImg']);
        if (!($index === false)){
            unset($_SESSION['remImg'][$index]);
        }
    }

    $temp = $_SESSION['remImg'];
    $_SESSION['remImg'] = array_values($temp);
}

function loginMechanism($login, $pass, &$errMsg){
    $query = ['login' => $login];
    $db = get_db();
    $record = $db->users->findOne($query);
    if ($record === NULL) {
        $errMsg = 'Niepoprawna nazwa użytkownika!'; 
        return false;
    }
    if (password_verify($pass, $record['password'])){
        session_regenerate_id();
        $_SESSION['userID'] = $record['_id'];
        $errMsg = 'Zalogowano!';
        return true;
    }
    $errMsg = 'Niepoprawne hasło!';
    return false;
}

function DeleteImg($idU){
    try{
        $db = get_db();
        $db->zdjecia->deleteOne(['_id' => new ObjectID($idU)]);
        return true;
    }
    catch( Exception $e) { return $e; }
}

function DeleteUser($idU){
    try{
        $db = get_db();
        $db->users->deleteOne(['_id' => new ObjectID($idU)]);
        return true;
    }
    catch( Exception $e) { return $e; }
}

function loginUsed($login){
    $db = get_db();
    $query = ['login' => $login];
    $user = $db->users->findOne($query);
    if ($user) {return true;}
    return false;
}

function addUser($mail, $login, $pass){
    $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
    $record = [
        'login' => $login,
        'email' => $mail,
        'password' => $hash_pass,
    ];
    $db = get_db();
    $wynik = $db->users->insertOne($record);
    return $wynik;
}

function uploadImg($file, $watermark, $tytul, $autor, &$errMsg){
    $fileSize = $file['size'];
    $fileType =  $file['type'];
    $fileError = $file['error'];
    $fileName = basename($file['name']);
    $fileTmpName = $file['tmp_name'];
    $privacy = 'public';
    if(isset($_POST['privacy']) && $_POST['privacy'] == 'private'){ $privacy = $_SESSION['userID']; }
    $maxSize = 1024*1024;

    $uploadfile = $_SERVER['DOCUMENT_ROOT']."/images/original/";
    $temp = array_diff(scandir($uploadfile), array('.','..'));
    $newFilename = (count($temp) + 1) . substr($fileName, strrpos($fileName, '.'));
    $uploadfile = $uploadfile . $newFilename;

    if (($fileError == "UPLOAD_ERR_OK") && !($watermark === ""))
    {
        if ($fileSize > $maxSize){ $errMsg = "Przesłany plik jest za duży"; }

        if (!(($fileType === "image/png") || ($fileType === "image/jpeg"))){
            if(!($errMsg === "")) { $errMsg = $errMsg."</br>"; }
            $errMsg = $errMsg."Przesłany plik ma zły typ";
        }

        if ($errMsg === ""){
            if (move_uploaded_file($fileTmpName, $uploadfile)){
                $db = get_db();

                $zdjecie = [
                    'nazwa' => $newFilename,
                    'tytul' => $tytul,
                    'autor' => $autor,
                    'privacy' => $privacy
                ];

                $db->zdjecia->insertOne($zdjecie);
                return true;
            } else {
                $errMsg = $errMsg."Błąd przesłania pliku ".$uploadfile; }
        }
    }
    else if (!($file['error'] == "UPLOAD_ERR_OK") && ($file['size'] === 0) && !($watermark === "")){
        $errMsg = "Przesłany plik jest za duży";

        if (strlen($fileName) >= 5){
            if(strrpos($fileName, '.png') == strlen($fileName) - 4) 
                { $fileType = "image/png";}
            else if(strrpos($fileName, '.jpg') == strlen($fileName) - 4) 
                { $fileType = "image/jpeg";}
            else if(strrpos($fileName, '.jpeg') == strlen($fileName) - 5) 
                { $fileType = "image/jpeg";}
        }

        if (!(($fileType === "image/png") || ($fileType === "image/jpeg"))){
            if(!($errMsg === "")) { $errMsg = $errMsg."</br>"; }
            $errMsg = $errMsg."Przesłany plik ma zły typ".$fileType;
        }

    }
    else{
        $errMsg = "Nie wybrano wszystkich parametrów";
    }
    
    return false;
}

function showPrzeladowane($nazwa){
    $db = get_db();
    $imgs = $db->zdjecia->find();
    $returnImgs = "<section>";
    $i = 1;
    foreach($imgs as $img){
        if(str_contains($img['tytul'], $nazwa)){
            if ((isset($_SESSION['userID']) && $img['privacy'] == $_SESSION['userID']) || $img['privacy'] == 'public'){
                $privacy = "";
                if(!($img['privacy'] == 'public')){
                    $privacy = '<span style="color: green">Prywatne</span><br/>';
                }

                $returnImgs .= '<div class="ramkaImg" style="flex:1"><a href="images/watermark/' . $img['nazwa'] . '"><img src="images/miniature/' . $img['nazwa'] . '" alt="obrazek"/></a>'.$privacy.$img['tytul'].'<br/>'.$img['autor'].'</div>';
                $i++;
                if($i==6){
                    $returnImgs .= '</section><section>';
                    $i=1;
                }
            }
        }
    }

    $fillLayout = "";
    if(!($i==1)){
        $fillerSize = 6 - $i;
        for ($iter = 0; $iter < $fillerSize; $iter++) {
            $fillLayout = $fillLayout.'<div style="flex: 1; padding: 10px;"></div>';
        }
    }

    $returnImgs .= $fillLayout."</section>";
    return $returnImgs;
}

function createForwardButton($actSite, $dest){
    $newSite = $actSite + 1;
    return '<form method="GET" action="/'.$dest.'" style="float: left;">
    <input type="hidden" name="site" value="'.$newSite.'"/>
    <input type="submit" value="Następna strona"/>
    </form>';
}

function createBackButton($actSite, $dest){
    $newSite = $actSite - 1;
    return '<form method="GET" action="/'.$dest.'" style="float: left;">
    <input type="hidden" name="site" value="'.$newSite.'"/>
    <input type="submit" value="Poprzednia strona"/>
    </form>';
}

function showOwnGallery($site, &$isMore, &$fillLayout){
    $imgDir = './images/miniature/';
    $imgs = $_SESSION['remImg'];
    $returnImages = [];

    for ($iter = $site*5-5; $iter < $site*5; $iter++){
        if (!isset($imgs[$iter])) {break;}

        $imgSrcBig = './images/watermark/'.$imgs[$iter];
        $imgSrc = $imgDir.$imgs[$iter];

        $db = get_db();
        $query = ['nazwa' => $imgs[$iter]];
        $doc = $db->zdjecia->findOne($query);

        $returnImages[$iter] = '<a href="'.$imgSrcBig.'" target="_blank"><img src="'.$imgSrc.'" alt="obrazek"></a>'.$doc['tytul'].'</br>'.$doc['autor'].'<br/><input type="checkbox" name="'.$doc['nazwa'].'"/>';
    }

    if (isset($imgs[$site * 5]) && ($imgs[$site * 5] != "")) {$isMore = true; }

    $fillerSize = 5 - sizeof($returnImages);
    for ($iter = 0; $iter < $fillerSize; $iter++) {
        $fillLayout = $fillLayout.'<div style="flex: 1; padding: 10px;"></div>';
    }
    return $returnImages;
    
}

function userLogin(&$user){
    if (isset($_SESSION['userID'])){
        $db = get_db();
        $query = ['_id' => new ObjectID($_SESSION['userID'])];
        $user = $db->users->findOne($query)['login'];
        return true;
    }
    return false;
}

function showImages($site, &$isMore, &$fillLayout, $startTable){
    $db = get_db();
    $loadedImgs = $startTable;
    if($startTable === []){
        $imgDir = './images/miniature/';
        $loadedImgs = array_diff(scandir($imgDir), array('.', '..'));
    }
    $returnImages = [];
    $userID = "";
    if(isset($_SESSION['userID'])){
        $userID = $_SESSION['userID'];
    }

    $temp = array_values($loadedImgs);

    for ($i = 0; $i < count($loadedImgs); $i++){
        $query = ['nazwa' => $temp[$i]];
        $doc = $db->zdjecia->findOne($query);
        if(!($doc['privacy'] === 'public' || $doc['privacy'] == $userID)){
            unset($temp[$i]);
        }
    }

    $loadedImgs = array_values($temp);

    for ($iter = $site * 5 - 5; $iter < $site * 5; $iter++){
       if (isset($loadedImgs[$iter])){
            $imgSrcBig = './images/watermark/'.$loadedImgs[$iter];
            $imgSrc = $imgDir.$loadedImgs[$iter];

            $query = ['nazwa' => $loadedImgs[$iter]];
            $doc = $db->zdjecia->findOne($query);
            $checked = "";
            if(isset($_SESSION['remImg']) && !(array_search($loadedImgs[$iter], $_SESSION['remImg']) === false)){
                $checked = 'checked="true"';
            }
            $p = "";
            if (!($doc['privacy'] === 'public')) {
                $p = '<span style="color:green">Prywatne</span><br/>';}

            $returnImages[$iter] = '<a href="'.$imgSrcBig.'" target="_blank"><img src="'.$imgSrc.'" alt="obrazek"></a>'.$p.$doc['tytul'].'</br>'.$doc['autor'].'<br/><input type="checkbox" name="'.$doc['nazwa'].'"'.$checked.'/>';
    }
        else{
            break;
        }
    }
    if (isset($loadedImgs[$site * 5]) && ($loadedImgs[$site * 5] != "")) {$isMore = true; }

    $fillerSize = 5 - sizeof($returnImages);
    for ($iter = 0; $iter < $fillerSize; $iter++) {
        $fillLayout = $fillLayout.'<div style="flex: 1; padding: 10px;"></div>';
    }

    return $returnImages;
}

function createImage($file, $dir){
    if ($file === "image/png"){
        $image = imagecreatefrompng($dir);
    }
    else{
        $image = imagecreatefromjpeg($dir);
    }
    return $image;
}

function saveImage($image, $dir, $type){
    if ($type === "image/png"){
        imagepng($image, $dir);
        return true;
    }
    else if($type === "image/jpeg"){
        imagejpeg($image, $dir);
        return false;
    }
}

function addWatermark($file, $watermark){
    $dir = $_SERVER['DOCUMENT_ROOT']."/images/original/";
    $temp = array_diff(scandir($dir), array('.','..'));
    $fileName = count($temp).substr($file['name'], strrpos($file['name'], '.'));
    $dir = $dir.$fileName;

    $fileType = mime_content_type($dir);

    $image = createImage($fileType, $dir);
    $fontSize = imagesx($image) / 10;

    imagettftext($image, $fontSize, 45, 7, imagesy($image), 0xFFFFFF, './arial.ttf', $watermark);
    
    saveImage($image, './images/watermark/'.$fileName, $fileType);
    imagedestroy($image);
}

function createMiniature($file){
    $dir = $_SERVER['DOCUMENT_ROOT']."/images/watermark/";
    $temp = array_diff(scandir($dir), array('.','..'));
    $fileName = count($temp).substr($file['name'], strrpos($file['name'], '.'));
    $dir = $dir.$fileName;
    
    $fileType = mime_content_type($dir);

    $image = createImage($fileType, $dir);
    $image_mini = imagecreatetruecolor(200,125);
    imagecopyresampled($image_mini, $image, 0, 0, 0, 0, 200, 125, imagesx($image), imagesy($image));

    saveImage($image_mini, './images/miniature/'.$fileName, $fileType);
    imagedestroy($image);
}

function array_to_get($data){
    $s = "";
    $keys = array_keys($data);
    for ($i = 0; $i < count($data); $i++){
        if(!(is_array($data[$keys[$i]]))){
            $s = $s.$keys[$i].'='.$data[$keys[$i]].'&';
        }
    }

    return $s;
}
?>