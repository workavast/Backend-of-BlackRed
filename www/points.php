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

    function TakeWay($user_id, $levelNum, &$jsonWay, $connection)
    {
        $query = "SELECT way FROM ways WHERE user_id = '$user_id' AND levelNum = '$levelNum'";
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

    function TakeWays($user_id, $levelNum, $playerTime, &$jsonWays, $connection){
        $levelName = "";
        switch($levelNum){
            case '1':
                $levelName = "level_1";
                break;
            case '2':
                $levelName = "level_2";
                break;
            case '3':
                $levelName = "level_3";
                break;
            default:
                return false;
        }


        $foundWay = "";
        $ways = '{"ways":[';

        if(!TakeWay($user_id, $levelNum, $foundWay, $connection)){
            return false;
        }

        $ways = $ways. $foundWay;

        $time = $playerTime;
            
        for($n = 0; $n < 5; $n += 1){
            $time = $time - 0.2;
    
            $query = "SELECT id, $levelName  FROM users WHERE $levelName < $time AND $levelName > $time - $time/5 limit 1";
    
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
            $result = mysqli_query($connection, $query);
    
            if(mysqli_num_rows($result))
            {
                if($n != 5){
                    $ways = $ways.",";
                    $foundWay = "";
                }

                $foundResult = mysqli_fetch_assoc($result);
                $user_id = $foundResult['id'];
                $time = $foundResult[$levelName];
    
                if(!TakeWay($user_id, $levelNum, $foundWay, $connection)){
                    return false;
                }

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