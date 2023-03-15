<?php
    function UserRegistraion($userName, $userPassword, $connection)
    {
        $query = "INSERT into users (name, password) VALUES ('$userName', '$userPassword')";

        if($connection->query($query)){
            $user_id = $connection->insert_id;
            $query = "INSERT into levelstimes (user_id) VALUES ('$user_id')";

            if($connection->query($query)){
                return "Complited";
            }
            else{
                $error = $connection->error;
                $query = "DELETE FROM users WHERE idUsers='$user_id'";
                return "Error" . $error;
            }
        }
        else{
            return "Error" . $connection->error;
        }
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>