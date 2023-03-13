<?php
    function UserRegistraionCheck($userName, $connection)
    {
        $query = "SELECT * FROM users WHERE name = '$userName'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);
    
        if($foundResult == null){
            echo("not found");
        }
        else{
            echo("found");
        }
                
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }

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