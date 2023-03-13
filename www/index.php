<?php

    include("config.php");
    include("userRegistration.php");
    include("userEnter.php");

    $command = $_POST['Command'];
    switch($command){

        case 'UserRegistration':
            $userName = $_POST['name'];
            if(UserRegistraionCheck($userName, $connection) == 'not found'){
                $userPassword = $_POST['password'];
                UserRegistraion($userName, $userPassword, $connection);
            }
            else{
                echo('This name is occupied');
            }
            break;

        case 'UserEnter':
            UserEnter($_POST['name'], $_POST['password'], $connection);
            break;
    }

?>