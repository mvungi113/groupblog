<?php 
include_once '../database/config.php';


$query ="DELETE FROM posts WHERE id='".$_GET["id"]."'";
mysqli_query($conn, $query);
header('location: index.php');
// close connection
$conn->close();
?>