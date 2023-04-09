<?php
    function SavePoints($user_id, $levelNum, $points, $connection)
    {
        $query = "SELECT * FROM points WHERE user_id = '$user_id' AND levelNum = '$levelNum'";
        $result = mysqli_query($connection, $query);

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if(mysqli_num_rows($result))
        {
            $foundResult = mysqli_fetch_assoc($result);
            $points_id = $foundResult['id'];
            $query = "UPDATE points SET way = '$points' WHERE id = '$points_id'";
        }
        else
        {
            $query = "INSERT into points (user_id, levelNum, way) VALUES ('$user_id', '$levelNum', '$points')";
        }
    
        $result = mysqli_query($connection, $query);
        return $result;
    }

    function TakePoints($user_id, $levelNum, &$json, $connection)
    {
        $query = "SELECT * FROM points WHERE user_id = '$user_id' AND levelNum = '$levelNum'";
        $result = mysqli_query($connection, $query);

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if(mysqli_num_rows($result))
        {
            $foundResult = mysqli_fetch_assoc($result);
            $json = $foundResult['way'];

            return true;
        }
        else
        {
            return false;
        }
    }

    function TakeNearWay($levelNum, $levelName, $playerTime, &$json ,$connection){
        $time = $playerTime;
        $foundWay = "";
        $jsonWays = "";
        $jsonWays = $jsonWays.'{"ways":[';

        for($n = 0; $n < 5; $n += 1){
            $time = $time - 0.2;

            $query = "SELECT * FROM levelstimes WHERE $levelName < $time AND $levelName > $time - $time/5 limit 1";
    
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
            $result = mysqli_query($connection, $query);
    
            if(mysqli_num_rows($result))
            {
                if($n != 5 && $n != 0){
                    $jsonWays = $jsonWays.",";
                    $foundWay = "";
                }

                $foundResult = mysqli_fetch_assoc($result);
                $user_id = $foundResult['user_id'];
                $time = $foundResult[$levelName];
    
                TakePoints($user_id, $levelNum, $foundWay, $connection);
                $jsonWays = $jsonWays. $foundWay;
            }
            else
            {
                break;
            }
        }


        $jsonWays = $jsonWays.']}';
        $json = $jsonWays;

        return true;
    }
?>