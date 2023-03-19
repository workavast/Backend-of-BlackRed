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
?>