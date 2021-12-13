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
        if((explode("?", $requestUri) !== false) && ($CatURL[0] == "game"))
        {
            echo "I am die!";
            die();
        }
        $s_id=session_id();
        if(explode("?", $path[2]) !== false) // Проверка на ошибку.
        {
            $CatURL = explode("?", $path[2]);
        }
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
                    $query = "SELECT * FROM actual_games WHERE id_session = 'fad';";
                    //$query = "SELECT * FROM actual_games WHERE id_session = '$s_id';";
                    $result = mysqli_query($link,$query) or die(mysqli_error($link));
                    if(mysqli_num_rows($result) != 0)
                    {
                        $query = "DELETE FROM actual_games WHERE id_session = 'fad';";
                        //$query = "DELETE FROM actual_games WHERE id_session = '$s_id';";
                        $result = mysqli_query($link,$query) or die(mysqli_error($link));

                        //$query = "DELETE FROM actual_moves WHERE id_session = '$s_id';";
                        $query = "DELETE FROM actual_moves WHERE id_session = 'fad';";
                        $result = mysqli_query($link,$query) or die(mysqli_error($link));
                    }
                    $query = "INSERT INTO actual_games(id_session,type,lvl) values ('fad',$CatURL0[1],$CatURL1[1]);";
                    //$query = "INSERT INTO actual_games(id_session,type,lvl) values ('$s_id',$CatURL0[1],$CatURL1[1]);";
                    $result = mysqli_query($link,$query) or die(mysqli_error($link));
                }
                else header('Location: http://localhos'); // ошибка
            }
            else echo json_encode($json);
        }
        elseif($CatURL[0] == "game")      
        {
            /* Первая просто передаёт значения во фронт сколько рисовать. Вторая уже хода. Юзается для $type */
            $query = "SELECT * FROM actual_games WHERE id_session = 'fad';";
            $result = mysqli_query($link,$query) or die(mysqli_error($link));
            if(mysqli_num_rows($result) != 0)
            {
                while ($row = mysqli_fetch_array($result)) $type = $row['type'];
                $json = [
                    'type' => $type,
                ]; 
            }
            else {
                $json = [
                    'type' => 0,
                ];
            }
            if(count(explode("?", $path[2])) > 1) // Штука нужна передачи того ходов
            {
                $CatURL = explode("?", $path[2]);
                $CatURL = explode("&", $CatURL[1]);
                $seatnumber = explode("=", $CatURL[0]);
                $linenumber = explode("=", $CatURL[1]);
                if($seatnumber[0] == "seatNumber" && $linenumber[0] == "lineNumber") 
                {
                    if($seatnumber[1]>0 && $seatnumber[1]<=$type && $linenumber[1]>0 && $linenumber[1]<=$type)
                    {
                        include 'logicGame.php';
                        $json = checkLogic($seatnumber[1],$linenumber[1]);
                    }
                }
            }
            echo json_encode($json);       
        }
        elseif($CatURL[0] == "state")    
        {
            include 'logicAnswer.php';
            $json = answerState();
            echo json_encode($json);
        }
        else "Bad_52";
    }
    else echo json_encode($json);
?>