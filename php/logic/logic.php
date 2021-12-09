<?php
/*
    При ходах: 0 - компьютер
               1 - человек
    
    seatnumber = *1
    linenumber = 1*
    positionNumber = число

    table:
        0 - компьютер
        1 - человек
        2 - пусто
*/
function checkMove($positionNumber,$link)
{
    $s_id=session_id();
    //$query = "SELECT id_session,position FROM actual_moves WHERE id_session = '$s_id' && position = '$positionNumber';";
    $query = "SELECT id_session,position FROM actual_moves WHERE id_session = 'fad' && position = '$positionNumber';";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    if(mysqli_num_rows($result) != 0)
        {
            return printJSON(0);
        }
    else true;
}

function checkBD()
{
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
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

function printJSON($type)
{
    $s_id=session_id();
    if($type == 0) // Если такая позиция уже есть
    {
        $result = checkBD();
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
            'win' => $win
        ];
        return $json;
    }
    
}

function createTable($link)
{
    $result = checkBD($link);
    while ($row = mysqli_fetch_array($result))
    {
        $type = $row['type'];
        if($row['who_move'] == 0) 
        {
            $position[0] = $row['position'];
            $move[0] = $row['who_move'];
            $s = $position[0]%10;
            $f = ($position[0]-$s)/10;
            $table[$f][$s] = $move[0];
        }
        elseif($row['who_move'] == 1) 
        {
            $position[1] = $row['position'];
            $move[1] = $row['who_move'];
            $s = $position[1]%10;
            $f = ($position[1]-$s)/10;
            $table[$f][$s] = $move[1];
        }
    }
        for($z=1;$z<=$type;$z++)
        {
            for($j=1;$j<=$type;$j++)
            {
                if(!isset($table[$z][$j])) $table[$z][$j]=2;
            }
        }
    $table[0][0]=$type;
    return $table;
}

function checkWinner($link)
{
    $table = createTable($link);
    $type = $table[0][0];
    if($type == 3) $how=3;
    else $how=4;
    $howrepeat=0;
    $json = "";
    if($type == 3)  //Если 3х3
    {
        for($i=0;$i<=1;$i++)
        {
            for($p=1;$p<=$how;$p++)
            {
                for($z=1;$z<=$how;$z++)
                {
                    $w=$z+1;
                    if($z==$how) $w=1;
                        if (($table[$p][$z] == $i) && ($table[$p][$w] == $i))
                        {
                            $n=$p*10+$z;
                            //echo "$n | $p | $z | $w ||       ";
                            if($howrepeat == 0) $json="/$n";
                            else $json="$json, $n";
                            $howrepeat++;
                            if($howrepeat == $how) return $json;
                        }
                        else { $howrepeat=0; $json = ""; }
                }
                $howrepeat=0; $json = "";
            }
           // if(($table[1][1] && $table[1][2] && $table[1][3]) == $i) echo $i;
           /* ($table[2][1] && $table[2][2] && $table[2][3]) ||
            ($table[3][1] && $table[3][2] && $table[3][3]) ||
/*
            ($table[1][1] && $table[2][1] && $table[3][1]) ||
            ($table[1][2] && $table[2][2] && $table[3][2]) ||
            ($table[1][3] && $table[2][3] && $table[3][3]) ||

            ($table[1][1] && $table[2][2] && $table[3][3]) ||
            ($table[3][1] && $table[2][2] && $table[1][3]) == $i)
            {
                echo $i;
            }*/
        }
    }
}

function newposition($link)
{
    $result = checkBD();
   // echo "Что-то";
}

function checkLogic($seatnumber,$linenumber)
{
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
    $positionNumber = $linenumber*10+$seatnumber;
    $answer = checkMove($positionNumber,$link);
    if($answer != null) return $answer;
    $answer = checkWinner($link);
    if($answer == true) return $answer;
    //newposition($link);
}
?>