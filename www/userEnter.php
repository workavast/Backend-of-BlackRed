<?php
    function UserEnter($username, $userpassword, $connection)
    {
        $query = "SELECT * FROM users WHERE name = '$username'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);
    
        if($foundResult == null){
            echo("not found");
            exit();
        }
        
        if($foundResult['password'] != $userpassword)
            echo("uncorrect password");
        else
            echo("all good");
        
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }


?>