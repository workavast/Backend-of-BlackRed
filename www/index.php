<?php

    include("config.php");
    include("userRegistration.php");
    include("userEnter.php");

    $command = $_POST['Command'];
    switch($command){
        case 'UserRegistration':
            $userName = $_POST['name'];
            if(!UserExistCheck($userName, $connection)){
                $userPassword = $_POST['password'];
                if(UserRegistraion($userName, $userPassword, $connection)){
                    echo('Complited');
                }
                else{
                    echo('Some error');
                }
            }
            else{
                echo('This name is occupied');
            }
            break;

        case 'UserEnter':
            if(UserExistCheck($_POST['name'], $connection)){
                if(!UserEnter($_POST['name'], $_POST['password'], $connection)){
                    echo('Not correct password');
                }else{
                    echo('Complited');
                }
            }
            else{
                echo('This name dont exist');
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