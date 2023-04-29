<?php
    function SaveWay($user_id, $levelNum, $way, $connection)
    {
        $query = "SELECT * FROM ways WHERE user_id = '$user_id' AND levelNum = '$levelNum'";
        $result = mysqli_query($connection, $query);

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if(mysqli_num_rows($result))
        {
            $foundResult = mysqli_fetch_assoc($result);
            $way_id = $foundResult['id'];
            $query = "UPDATE ways SET way = '$way' WHERE id = '$way_id'";
        }
        else
        {
            $query = "INSERT into ways (user_id, levelNum, way) VALUES ('$user_id', '$levelNum', '$way')";
        }
    
        $result = mysqli_query($connection, $query);
        return $result;
    }

    function TakePlayerWay($user_id, $levelNum, &$jsonWay, $connection)
    {
        $query = "SELECT * FROM ways WHERE user_id = '$user_id' AND levelNum = '$levelNum'";
        $result = mysqli_query($connection, $query);

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if(mysqli_num_rows($result))
        {
            $foundResult = mysqli_fetch_assoc($result);
            $jsonWay = $foundResult['way'];

            return true;
        }
        else
        {
            return false;
        }
    }

    function TakeNearWays($levelNum, $levelName, $playerTime, &$jsonWays ,$connection){
        $time = $playerTime;
        $foundWay = "";
        $ways = "";
        $ways = $ways.'{"ways":[';

        for($n = 0; $n < 5; $n += 1){
            $time = $time - 0.2;

            $query = "SELECT * FROM levelstimes WHERE $levelName < $time AND $levelName > $time - $time/5 limit 1";
    
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
            $result = mysqli_query($connection, $query);
    
            if(mysqli_num_rows($result))
            {
                if($n != 5 && $n != 0){
                    $ways = $ways.",";
                    $foundWay = "";
                }

                $foundResult = mysqli_fetch_assoc($result);
                $user_id = $foundResult['user_id'];
                $time = $foundResult[$levelName];
    
                TakePlayerWay($user_id, $levelNum, $foundWay, $connection);
                $ways = $ways. $foundWay;
            }
            else
            {
                break;
            }
        }

        $jsonWays = $ways.']}';

        return true;
    }
?>