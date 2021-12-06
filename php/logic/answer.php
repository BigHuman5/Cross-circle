<?php
include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
$requestUri = $_SERVER["REQUEST_URI"];
$path = explode("/", $requestUri);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$json = [
    'type' => 0, 'lvl' => 0
];
    if($requestMethod == "GET") // Узнаём что метод гет
    {
        $CatURL = explode("?", $path[2]);
        if($CatURL[0] == "main")
        {
            $CatURL = explode("&", $CatURL[1]);
            $CatURL0 = explode("=", $CatURL[0]);
            $CatURL1 = explode("=", $CatURL[1]);
            if($CatURL0[0] == "type" && $CatURL1[0] == "lvl") 
            {
                if(($CatURL0[1] == 3 || $CatURL0[1] == 5 || $CatURL0[1] == 7) &&
                ($CatURL1[1] == 0 || $CatURL1[1] == 1 || $CatURL1[1] == 2 || $CatURL1[1] == 3))
                {
                    //echo "good";
                    $s_id=session_id();
                    $query = "INSERT INTO actual_games(id_session,type,lvl) values ('$s_id',$CatURL0[1],$CatURL1[1]);";
                    $result = mysqli_query($link,$query) or die(mysqli_error($link));
                }
                else header('Location: http://localhos'); // ошибка
            }
            else echo json_encode($json);
        }
        elseif($CatURL[0] == "game")
        {
            if(strripos($CatURL,"?") == true)
            {
                $CatURL = explode("?", $CatURL);
                $CatURL = explode("&", $CatURL[1]);
                $CatURL0 = explode("=", $CatURL[0]);
                $CatURL1 = explode("=", $CatURL[1]);
                if($CatURL0[0] == "type" && $CatURL1[0] == "lvl") 
                {
                    if(($CatURL0[1] == 3 || $CatURL0[1] == 5 || $CatURL0[1] == 7) &&
                    ($CatURL1[1] == 0 || $CatURL1[1] == 1 || $CatURL1[1] == 2 || $CatURL1[1] == 3))
                    {
                        $json = [
                            'type' => $CatURL0[1], 'lvl' => $CatURL1[1]
                        ];
                    }
                    else $json = [
                        'type' => 0, 'lvl' => 0
                    ];
                }
                echo json_encode($json);
            }
        }
        else "Bad_52";
    }
    else echo json_encode($json);
?>