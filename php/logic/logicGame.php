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

    3 - ничья
    4 - игра идёт
*/
function checkMove($positionNumber,$link)
{
    $s_id=session_id();
    //$query = "SELECT id_session,position FROM actual_moves WHERE id_session = '$s_id' && position = '$positionNumber';";
    $query = "SELECT id_session,position FROM actual_moves WHERE id_session = 'fad' && position = '$positionNumber';";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    if(mysqli_num_rows($result) != 0)
    {
        return printJSON(0,0,0);
    }
    else 
    {
        editBD(1,$positionNumber,0);
    }
}

function checkBD()
{
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
    //  $query = "SELECT g.type,g.lvl, m.id, m.id_session, m.who_move, m.position FROM actual_moves m, actual_games g WHERE m.id_session = '$s_id' && g.id_session = m.id_session GROUP by m.id, g.type";
    $query = "SELECT g.type, g.lvl, m.id, m.id_session, m.who_move, m.position FROM actual_moves m, actual_games g WHERE m.id_session = 'fad' && g.id_session = m.id_session GROUP by m.id, g.type, g.lvl ORDER BY m.position";
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

function editBD($type,$info,$who_win)
{
    $s_id=session_id();
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
    if(($type == 0) || ($type == 1)) //Добавление новой позиции от компьютера и человека
    {
    //  $query = "INSERT actual_moves(id_session,who_move,position) VALUES ('$s_id',$type,$info)";
    $query = "INSERT actual_moves(id_session,who_move,position) VALUES ('fad',$type,$info)";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    }
    elseif($type == 3) //Ничья или победа кого
    {
        $answer = checkBD();
        while ($row = mysqli_fetch_array($answer))
        {
            $anType = $row['type'];
            $lvl = $row['lvl'];
        }
        //$query = "INSERT statics(id_session,type,lvl,who_win) VALUES ('$s_id',$anType,$lvl,$who_win)";
        $query = "INSERT statics(id_session,type,lvl,who_win) VALUES ('fad',$anType,$lvl,$who_win)";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));

        $query = "DELETE FROM actual_games WHERE id_session = 'fad';";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));

        $query = "DELETE FROM actual_moves WHERE id_session = 'fad';";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
    }
}

function createTable($link)
{
    $result = checkBD($link);
    while ($row = mysqli_fetch_array($result))
    {
        $type = $row['type'];
        $lvl = $row['lvl'];
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
    $table[0][1]=$lvl;
    return $table;
}

function checkWinner($link)
{
    $table = createTable($link);
    $type = $table[0][0];
    if($type == 3) $how=2;
    else $how=3;
    $howrepeat=0;
    $json = "";
    for($i=0;$i<=1;$i++)
    {
        // Горизонтально
        for($p=1;$p<=$type;$p++)
        {
            for($z=1;$z<$type;$z++)
            {
                $w=$z+1;
                    if (($table[$p][$z] == $i) && ($table[$p][$w] == $i))
                    {
                        $n=$p*10+$z;
                        if($howrepeat == 0) $json="$n";
                        else $json="$json, $n";
                        if($w == $type)  {$n=$p*10+$w; $json="$json, $n"; } 
                        $howrepeat++;
                        if($howrepeat == $how)   return printJSON(1,$json,$i);
                    }
                    else { $howrepeat=0; $json = ""; }
            }
            $howrepeat=0; $json = "";
        }
        // Вертикально
        for($p=1;$p<=$type;$p++)
        {
            for($z=1;$z<$type;$z++)
            {
                $w=$z+1;
                    if (($table[$z][$p] == $i) && ($table[$w][$p] == $i))
                    {
                        $n=$z*10+$p;
                        if($howrepeat == 0) $json="$n";
                        else $json="$json, $n";
                        if($w == $type)  {$n=$w*10+$p; $json="$json, $n"; } 
                        $howrepeat++;
                        if($howrepeat == $how) return printJSON(1,$json,$i);
                        
                    }
                    else { $howrepeat=0; $json = ""; }
            }
            $howrepeat=0; $json = "";
        }

        // Наклон слева направо
        $while = 1;
        if($type != 3) $x=$type-3;
        else $x=1;
        $y=1;
        $lol=0;
        if($type != 3) $startpositionx=$type-3;
        else $startpositionx=1;
        $st=2;
        while($while != 3)
        {
            $xn=$x+1;
            $yn=$y+1;
            if (($table[$y][$x] == $i) && ($table[$yn][$xn] == $i))
            {
                $n=$y*10+$x;
                if($howrepeat == 0) $json="$n";
                else $json="$json, $n";
                $howrepeat++;
                if($howrepeat == $how)  
                {
                    $n=$yn*10+$xn;
                    $json="$json, $n";
                    return printJSON(1,$json,$i);
                } 
            }
            $x++;
            $y++;
            $lol++;
            if(($xn >= $type) || ($yn >= $type)) {
                if($type == 3) $while = 3;
                if($while == 1){ 
                    $startpositionx--;
                    $x = $startpositionx;  
                    $y = 1;
                    if($x == 1) $while = 2;
                }
                elseif($while == 2)
                {
                    $x = 1;
                    $y = $st;
                    if($y == $type-2) $while = 3;
                    $st++;
                }
                $howrepeat=0; $json = "";
            }
        }
        
        // Наклон справа налево//
        $while = 1;
        if($type != 3) $x=4;
        else $x=1;
        $y=1;
        $lol=0;
        if($type != 3) $startpositionx=4;
        else $startpositionx=1;
        $st=2;
        while($while != 3)
        {
            $xn=$x-1;
            $yn=$y+1;
            if($xn == 0 || $yn == 0) break;
            if (($table[$y][$x] == $i) && ($table[$yn][$xn] == $i))
            {
                $n=$y*10+$x;
                if($howrepeat == 0) $json="$n";
                else $json="$json, $n";
                $howrepeat++;
                if($howrepeat == $how)  
                {
                    $n=$yn*10+$xn;
                    $json="$json, $n";
                    return printJSON(1,$json,$i);
                } 
            }
            //echo nl2br("$y | $x | $yn | $xn\n",false);
            $x--;
            $y++;
            $lol++;
            if(($xn >= $type) || ($yn >= $type) || ($xn == 1)) {
                if($type == 3) $while = 3;
                if($while == 1){ 
                    $startpositionx++;
                    $x = $startpositionx;  
                    $y = 1;
                    if($yn == $type) $while = 2;
                }
                if($while == 2)
                {
                    $x = $type;
                    $y = $st;
                    if($xn == $type-3) $while = 3;
                    $st++;
                }
                $howrepeat=0; $json = "";
            }
        }
    }
}

function checkDraw($link)
{
    $table = createTable($link);
    $type = $table[0][0];
    for($y=1;$y<=$type;$y++)
    {
        for($x=1;$x<=$type;$x++)
        {
            if($table[$y][$x] == 2) 
            {
                return false;
            }
        }
    }
    return printJSON(1,0,3);
}

function newposition($link)
{
    $table = createTable($link);
    $type = $table[0][0];
    $lvl = $table[0][1];
    if($lvl == 1)
    {
        $while=0;
        while($while==0)
        {
            $x = rand(1,$type);
            $y = rand(1,$type);
            if($table[$y][$x] == 2)
            {
                $newpos = $y*10+$x;
                $while = 1;
            }
        }
    } 
    editBD(0,$newpos,0);
    return printJSON(1,0,4);
}

function printJSON($type,$json,$info)
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
        if(isset($position[0])) $position0 = implode(",", $position[0]);
        else $position0=0;
        if(isset($position[1])) $position1 = implode(",", $position[1]);
        else $position1=0;
        $json = [
            'type' => $type[0],
            'move_1' => $position0,
            'move_2' => $position1,
            'who_win' => 4,
            'win' => 0
        ];
        return $json;
    }
    elseif ($type == 1) // Новая или ничья
    {
        $result = checkBD();
        if($json != 0) editBD(3,$json,$info);
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
            'who_win' => $info,
            'win' => $json
        ];
        return $json;
    }
}

function checkLogic($seatnumber,$linenumber)
{
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
    $positionNumber = $linenumber*10+$seatnumber;

    $answer = checkMove($positionNumber,$link);

    if($answer != null) return $answer;

    $answer = checkWinner($link);
    if($answer == true) return $answer;

    $answer = checkDraw($link);
    if($answer == 1) 
    {
        editBD(3,0,3);
        return $answer;
    }

    $newpos = newposition($link);

    $answer = checkWinner($link);
    if($answer == true) return $answer;

    $answer = checkDraw($link);
    if($answer == 1) 
    {
        editBD(4,0,3);
        return $answer;
    }
    return $newpos;
}
?>