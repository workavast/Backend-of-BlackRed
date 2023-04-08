<?php
    function UserExistCheck($userName, $connection)
    {
        $query = "SELECT * FROM users WHERE name = '$userName'";

        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);

        return $foundResult;
    }

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

    function UserRegistraion($userName, $userPassword, $connection, &$json)
    {
        $userINSERT = "INSERT into users (name, password) VALUES ('$userName', '$userPassword')";
        $levelsTimesINSERT = "INSERT into levelstimes (user_id) VALUES (LAST_INSERT_ID())";

        $connection->query("START TRANSACTION");
        $userResult = $connection->query($userINSERT);
        $idUsers = $connection->insert_id;
        $levelsTimesResult = $connection->query($levelsTimesINSERT);
        
        if($userResult && $levelsTimesResult)
        {
            $connection->query("COMMIT");

            $jsonArray = array(
                "id" => $idUsers,
                "name" => $userName
            );
            $json = json_encode($jsonArray);

            return true;
        }
        else
        {
            $connection->query("ROLLBACK");
            return false;
        }
   
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>