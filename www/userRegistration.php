<?php
    function UserRegistraion($userName, $userPassword, $connection)
    {
        $query = "INSERT into users (name, password) VALUES ('$userName', '$userPassword')";

        if($connection->query($query)){
            return "Complited";
        }
        else{
            return "Error" . $connection->error;
        }
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>