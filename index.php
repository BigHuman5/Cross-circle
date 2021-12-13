<?php
session_start();
$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];
$path = explode("/", $requestUri);
$CatURL = $path[1];
$path = explode("?", $CatURL);
if ($CatURL == "") {
    include "php/view/indexView.php";
    die();
} 
elseif ($path[0] == "game") {
    include "php/view/game.php";
    die();
}

elseif ($path[0] == "question"){ 
    include "php/logic/answer.php";
    die();
}

elseif ($path[0] == "statics"){ 
    include "php/view/statics.php";
    die();
}

else{
    include "php/errors/error404.php";
    die();
}
?>
