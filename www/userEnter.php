<?php
    include("levelsTimes.php");

    function UserEnter($userName, $userPassword, $connection, &$json)
    {
        $query = "SELECT * FROM users WHERE name = '$userName'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);
    
        if($foundResult == null)
            return false;
        
        if($foundResult['password'] == $userPassword)
        {
            $jsonArray = array(
                "id" => $foundResult['id'],
                "name" => $foundResult['name']
            );
            
            if(LevelsTimes($foundResult['id'], $connection, $jsonArray))
            {
                $json = json_encode($jsonArray);
                return true;
            }
        }

        return false;
    }
?>