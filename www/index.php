<?php

    include("config.php");
    include("userRegistration.php");
    include("userEnter.php");

    $command = $_POST['Command'];
    $json = "";
    switch($command){
        case 'UserRegistration':
            $userName = $_POST['name'];
            if(!UserExistCheck($userName, $connection)){
                $userPassword = $_POST['password'];
                if(UserRegistraion($userName, $userPassword, $connection, $json)){
                    echo($json);
                    http_response_code(200);//Complited
                }
                else{
                    http_response_code(520);//Some error, try again
                }
            }
            else{
                http_response_code(409);//This name is occupied
            }
            break;

        case 'UserEnter':
            if(UserExistCheck($_POST['name'], $connection)){
                if(UserEnter($_POST['name'], $_POST['password'], $connection, $json)){
                    echo($json);
                    http_response_code(200);//Complited
                }else{
                    http_response_code(401);//Not correct password
                }
            }
            else{
                http_response_code(404);//This name dont exist
            }
            break;
    }


    function UserExistCheck($userName, $connection)
    {
        $query = "SELECT * FROM users WHERE name = '$userName'";

        $result = mysqli_query($connection, $query);
    
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $foundResult = mysqli_fetch_assoc($result);

        if($foundResult){
            return true;
        }
        else{
            return false;
        }
               
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    }
?>