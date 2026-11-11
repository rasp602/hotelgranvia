<?php
    define("MYSQL_USER","u410124118_rasp602");
    define("MYSQL_PASS","Rodrigo2410$");
    define("MYSQL_SERVER","localhost");
    define("MYSQL_DATABASE","u410124118_hoteleria");

    $conn = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }


?>