<?php
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
                "id" => $foundResult['idUsers'],
                "name" => $foundResult['name']
            );
            $json = json_encode($jsonArray);

            // $json .= "\"id\":".$foundResult['idUsers'];
            // $json .= ",";
            // $json .= "\"name\":\"".$foundResult['name']."\"";
            // $json .= "}";

            return true;
        }
        else
            return false;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>