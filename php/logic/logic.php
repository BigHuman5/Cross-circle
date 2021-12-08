<?php
/*
    При ходах: 0 - компьютер
               1 - человек
    
    seatnumber = *1
    linenumber = 1*
    positionNumber = число
*/
global $json;
function checkMove($positionNumber,$link)
{
    $s_id=session_id();
    //$query = "SELECT id_session,position FROM actual_moves WHERE id_session = '$s_id' && position = '$positionNumber';";
    $query = "SELECT id_session,position FROM actual_moves WHERE id_session = 'fad' && position = '$positionNumber';";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    if(mysqli_num_rows($result) != 0)
        {
            return printJSON(0,$link,0);
        }
    else true;
}

function checkBD($link)
{
    //  $query = "SELECT g.type, m.id, m.id_session, m.who_move, m.position FROM actual_moves m, actual_games g WHERE m.id_session = '$s_id' && g.id_session = m.id_session GROUP by m.id, g.type";
    $query = "SELECT g.type, m.id, m.id_session, m.who_move, m.position FROM actual_moves m, actual_games g WHERE m.id_session = 'fad' && g.id_session = m.id_session GROUP by m.id, g.type";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    if(mysqli_num_rows($result) == 0)
        {
            echo "I am die!";
            die();
        }
    else 
        {
            return $result;
        }
}

function printJSON($type,$link)
{
    $s_id=session_id();
    if($type == 0) // Если такая позиция уже есть
    {
        $result = checkBD($link);
        $i=0;
        while ($row = mysqli_fetch_array($result))
        {
            $type = $row['type'];
            if($row['who_move'] == 0) $position[0][$i] = $row['position'];
            elseif($row['who_move'] == 1) $position[1][$i] = $row['position'];
            $i++;
        }
        $position0 = implode(",", $position[0]);
        $position1 = implode(",", $position[1]);
        $json = [
            'type' => $type[0],
            'move_1' => $position0,
            'move_2' => $position1,
            'win' => 0
        ];
        return $json;
    }
}

function newposition($link)
{
    $result = checkBD($link);
    echo "Что-то";
}

function checkLogic($seatnumber,$linenumber)
{
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
    $positionNumber = $linenumber*10+$seatnumber;
    $answer = checkMove($positionNumber,$link);
    if($answer != null) return $answer;
    newposition($link);
}
?>