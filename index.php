<?php
//session_start();
$requestUri = $_SERVER["REQUEST_URI"];
$requestMethod = $_SERVER["REQUEST_METHOD"];
$path = explode("/", $requestUri);
$CatURL = $path[1];
if ($CatURL == "") {
    include "indexView.php";
    die();
}

if ($CatURL == "game") {
    include "indexView.php";
    die();
}
?>
