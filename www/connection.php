<?php
    include('config.php');

    $connection = mysqli_connect(
        $config['db']['server'],
        $config['db']['username'],
        $config['db']['password'],
        $config['db']['name']
    );

    if ($connection == false){
        echo 'connection error<br>';
        echo mysqli_connect_error();
        exit();
    }

    session_start();
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>