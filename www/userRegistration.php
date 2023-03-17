<?php
    function UserRegistraion($userName, $userPassword, $connection, &$json)
    {
        $idUsers = "";
        $userINSERT = "INSERT into users (name, password) VALUES ('$userName', '$userPassword')";
        $levelsTimesINSERT = "INSERT into levelstimes (user_id) VALUES (LAST_INSERT_ID())";

        $connection->query("START TRANSACTION");
        $userResult = $connection->query($userINSERT);
        $idUsers = $connection->insert_id;
        $levelsTimesResult = $connection->query($levelsTimesINSERT);
        
        if($userResult && $levelsTimesResult){
            $connection->query("COMMIT");

            $jsonArray = array(
                "id" => $idUsers,
                "name" => $userName
            );
            $json = json_encode($jsonArray);

            // $json .= "\"id\":".$idUsers;
            // $json .= ",";
            // $json .= "\"name\":\"".$userName."\"";
            // $json .= "}";

            return true;
        }
        else{
            $connection->query("ROLLBACK");
            return false;
        }
   
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>