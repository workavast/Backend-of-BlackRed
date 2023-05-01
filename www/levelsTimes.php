<?php
    function LevelsTimes($user_id, $connection, &$jsonArray)
    {
        $query = "SELECT * FROM levelstimes WHERE user_id = '$user_id'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);
    
        if($foundResult == null)
            return false;

        $jsonArray["levels"] = array(
            array("num" => 1,"time" => $foundResult['level_1']),
            array("num" => 2,"time" => $foundResult['level_2']),
            array("num" => 3,"time" => $foundResult['level_3'])
        );   
        return true;
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

    function UpdateLevelTime($user_id, $levelName, $time, $connection)
    {
        $query = "UPDATE levelstimes SET $levelName = '$time' WHERE user_id = '$user_id'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    
        return $result;
    }

    function TakeLeaderboard($user_id, $levelNum, &$json, $connection){
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
        
        
        $query = "SELECT * FROM
                (SELECT user_id, $levelName , ROW_NUMBER() OVER (ORDER BY $levelName) 'place' FROM levelstimes WHERE $levelName > 0) AS place
                WHERE user_id = $user_id;";
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $queryResult = mysqli_query($connection, $query);
        $foundResult = mysqli_fetch_assoc($queryResult);
        if($foundResult == null){
            return false;
        }



        $mainResult = $foundResult;
        $place = $foundResult['place'];

        $bordPos = $place % 10;
        $moreFast = $bordPos - 1;
        $lessFast = 10 - $bordPos;

        $query = "SELECT * FROM
                (SELECT * , ROW_NUMBER() OVER (ORDER BY $levelName) 'place' FROM levelstimes WHERE $levelName > 0) AS place
                WHERE place < $place LIMIT $moreFast;";
        $moreFastResult = mysqli_query($connection, $query);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $query = "SELECT * FROM
                (SELECT * , ROW_NUMBER() OVER (ORDER BY $levelName) 'place' FROM levelstimes WHERE $levelName > 0) AS place
                WHERE place > $place LIMIT $lessFast ;";
        $lessFastResult = mysqli_query($connection, $query);
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


        $bords = array();
        $max = mysqli_num_rows($moreFastResult);
        for($n = 0; $n < $max; $n++){
            $res = mysqli_fetch_assoc($moreFastResult);
            $bord = array(
                "place" => $res['place'],
                "name" => $res['user_id'],
                "time" => $res[$levelName]
            );

            $bords[] = $bord;
        }

        $bord = array(
            "place" => $mainResult['place'],
            "name" => $mainResult['user_id'],
            "time" => $mainResult[$levelName]
        );
        $bords[] = $bord;

        $max = mysqli_num_rows($lessFastResult);
        for($n = 0; $n < $max; $n++){
            $res = mysqli_fetch_assoc($lessFastResult);
            $bord = array(
                "place" => $res['place'],
                "name" => $res['user_id'],
                "time" => $res[$levelName]
            );

            $bords[] = $bord;
        }

        $fullBords = array(
            "boards" => $bords
        );

        $json = json_encode($fullBords);
        return true;
    }
?>