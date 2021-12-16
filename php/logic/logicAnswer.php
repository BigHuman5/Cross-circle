<?php

function checkBD($link)
{
    $s_id=session_id();
    for($i=3;$i<=7;$i=$i+2)
    {
        for($x=0;$x<=3;$x++) 
        {
            $count_who_win[$i][$x] = 0;
            $count_who_win_you[$i][$x] = 0;
        }
        $query = "select who_win,COUNT(who_win) from statics WHERE type=$i GROUP by who_win";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
        while ($row = mysqli_fetch_array($result))
        {
            $count_who_win[$i][$row['who_win']] = $row['COUNT(who_win)'];
        }
        $query = "select who_win,COUNT(who_win) from statics WHERE type=$i and id_session = '$s_id' GROUP by who_win";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
        while ($row = mysqli_fetch_array($result))
        {
            $count_who_win_you[$i][$row['who_win']] = $row['COUNT(who_win)'];
        }
    }

    $json=
    [
        "g3c" => $count_who_win[3][0],
        "g3h" => $count_who_win[3][1],
        "g3d" => $count_who_win[3][3],
        "g5c" => $count_who_win[5][0],
        "g5h" => $count_who_win[5][1],
        "g5d" => $count_who_win[5][3],
        "g7c" => $count_who_win[7][0],
        "g7h" => $count_who_win[7][1],
        "g7d" => $count_who_win[7][3],
        "y3c" => $count_who_win_you[3][0],
        "y3h" => $count_who_win_you[3][1],
        "y3d" => $count_who_win_you[3][3],
        "y5c" => $count_who_win_you[5][0],
        "y5h" => $count_who_win_you[5][1],
        "y5d" => $count_who_win_you[5][3],
        "y7c" => $count_who_win_you[7][0],
        "y7h" => $count_who_win_you[7][1],
        "y7d" => $count_who_win_you[7][3],
    ];
    return $json;
}

function editBD($link)
{
    $query = "SELECT max(id) from actual_games";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    $row = mysqli_fetch_array($result);
    $max_id=$row[0];
    $id=$max_id-100;
    if($id>=0)
    {
        $query = "DELETE FROM actual_games WHERE id<=$id";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
    }
    $query = "SELECT max(id) from actual_games";
    $result = mysqli_query($link,$query) or die(mysqli_error($link));
    $row = mysqli_fetch_array($result);
    $max_id=$row[0];
    $id=$max_id-100;
    if($id>=0)
    {
        $query = "DELETE FROM actual_moves WHERE id<=$id;";
        $result = mysqli_query($link,$query) or die(mysqli_error($link));
    }
}

function answerState()
{
    include $_SERVER['DOCUMENT_ROOT'].'/php/bd.php';
    editBD($link);
    return checkBD($link);
}
?>