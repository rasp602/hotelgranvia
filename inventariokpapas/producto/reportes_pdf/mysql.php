<?php
    define("MYSQL_USER","hotel");
    define("MYSQL_PASS","chile2023$");
    define("MYSQL_SERVER","190.101.222.6");
    define("MYSQL_DATABASE","hoteleria");

    $conn = mysqli_connect(MYSQL_SERVER, MYSQL_USER, MYSQL_PASS, MYSQL_DATABASE);
    if(!$conn){
        echo 'Connection error: ' . mysqli_connect_error();
    }


?>