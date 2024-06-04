<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "groupblog";

$conn = mysqli_connect($host,$username,$password,$dbname);
if(!$conn){
    die("Connection Failed");
}

?>