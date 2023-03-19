<?php
    include("levelsTimes.php");

    function UserEnter($username, $userpassword, $connection, &$json)
    {
        $query = "SELECT * FROM users WHERE name = '$username'";
    
        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);
    
        if($foundResult == null){
            return false;
        }
        
        if($foundResult['password'] == $userpassword){
            $jsonArray = array(
                "id" => $foundResult['id'],
                "name" => $foundResult['name']
            );
            
            if(LevelsTimes($foundResult['id'], $connection, $jsonArray)){
                $json = json_encode($jsonArray);
                return true;
            }else{
                return false;
            }
        }
        else
            return false;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>