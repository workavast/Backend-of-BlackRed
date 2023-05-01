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
            
            if(TakeLevelsTimes($foundResult['id'], $connection, $jsonArray))
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

        $userResult = mysqli_query($connection, $userINSERT);
        $idUsers = $connection->insert_id;
        
        if($userResult)
        {
            $jsonArray = array(
                "id" => $idUsers,
                "name" => $userName
            );

            if(TakeLevelsTimes($idUsers, $connection, $jsonArray))
            {
                $json = json_encode($jsonArray);
                return true;
            }else{
                return false;
            }
        }
        else
        {
            return false;
        }
   
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>