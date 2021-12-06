<?php

$link = mysqli_connect('127.0.0.1','root','123','web-project');

if(mysqli_connect_errno())
{
    echo 'Ошибка '.mysqli_connect_errno().' : '.mysqli_connect_error();
    exit();
};