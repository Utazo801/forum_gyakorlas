<?php

$server = "localhost";
$username="root";
$pwd ="";
$dbname = "forum_szb13a";

$conn = new mysqli($server,$username,$pwd,$dbname);

if($conn->connect_error){
    http_response_code(400);
    die('Error:'.$conn->connect_error);
}
$conn->set_charset('utf-8')

?>