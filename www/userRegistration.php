<?php
    function UserRegistraion($userName, $userPassword, $connection)
    {
        $userINSERT = "INSERT into users (name, password) VALUES ('$userName', '$userPassword')";
        $levelsTimesINSERT = "INSERT into levelstimes (user_id) VALUES (LAST_INSERT_ID())";

        $connection->query("START TRANSACTION");
        $userResult = $connection->query($userINSERT);
        $levelsTimesResult = $connection->query($levelsTimesINSERT);
        
        if($userResult && $levelsTimesResult){
            $connection->query("COMMIT");
            return true;
        }
        else{
            $connection->query("ROLLBACK");
            return false;
        }
   
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>