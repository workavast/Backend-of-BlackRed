<?php
    function UserEnter($username, $userpassword, $connection)
    {
        $query = "SELECT * FROM users WHERE name = '$username'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);
    
        if($foundResult == null){
            return false;
        }
        
        if($foundResult['password'] == $userpassword)
            return true;
        else
            return false;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>