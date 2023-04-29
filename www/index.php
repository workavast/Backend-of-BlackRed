<?php
    include("connection.php");
    include("user.php");
    include("levelsTimes.php");
    include("points.php");
    
    $command = $_POST['Command'];
    $json = "";
    switch($command){
        case 'UserRegistration':
            $userName = $_POST['name'];
            if(!UserExistCheck($userName, $connection))
            {
                $userPassword = $_POST['password'];
                if(UserRegistraion($userName, $userPassword, $connection, $json))
                {
                    echo($json);
                    http_response_code(200);//Complited
                }
                else
                {
                    http_response_code(520);//Some error, try again
                }
            }
            else
            {
                http_response_code(409);//This name is occupied
            }
            break;

        case 'UserEnter':
            if(UserExistCheck($_POST['name'], $connection)){
                if(UserEnter($_POST['name'], $_POST['password'], $connection, $json))
                {
                    echo($json);
                    http_response_code(200);//Complited
                }
                else
                {
                    http_response_code(401);//Not correct password
                }
            }
            else{
                http_response_code(404);//This name dont exist
            }
            break;

        case 'UpdateLevelTime':
            if(UpdateLevelTime((int)$_POST['user_id'], $_POST['levelName'], (float)$_POST['time'], $connection))
            {
                http_response_code(200);//Complited
            }
            else
            {
                http_response_code(520);//Some error, try again
            }
            break;

        case 'SaveWay':
            if(SaveWay((int)$_POST['user_id'], (int)$_POST['levelNum'], $_POST['points'] ,$connection))
            {
                http_response_code(200);//Complited
            }
            else
            {
                http_response_code(520);//Some error, try again
            }
            break;

        case 'TakePlayerWay':
            if(TakePlayerWay((int)$_POST['user_id'], (int)$_POST['levelNum'], $json ,$connection))
            {
                echo($json);
                http_response_code(200);//Complited
            }
            else
            {
                http_response_code(520);//Some error, try again
            }
            break;
            
        case 'TakeNearWays':
            if(TakeNearWays((int)$_POST['levelNum'], $_POST['levelName'], $_POST['time'], $json ,$connection))
            {
                echo($json);
                http_response_code(200);//Complited
            }
            else
            {
                http_response_code(520);//Some error, try again
            }
            break;
    }    
?>