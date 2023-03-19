<?php
    function SavePoints($user_id, $levelNum, $points, $connection)
    {
        $query = "SELECT * FROM points WHERE user_id = '$user_id' AND levelNum = '$levelNum'";
        $result = mysqli_query($connection, $query);

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if(mysqli_num_rows($result)){
            $foundResult = mysqli_fetch_assoc($result);
            $points_id = $foundResult['id'];
            $query = "UPDATE points SET way = '$points' WHERE id = '$points_id'";
        }else{
            $query = "INSERT into points (user_id, levelNum, way) VALUES ('$user_id', '$levelNum', '$points')";
        }
    
        $result = mysqli_query($connection, $query);
        return $result;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>