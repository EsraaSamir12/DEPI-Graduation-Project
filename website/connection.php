<?php
$localhost = "localhost";
$username = "root";
$password = "";
$database ="cucasdb";

$connect = mysqli_connect($localhost, $username ,$password , $database);

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getUserName() {
    return $_SESSION['user_name'] ?? '';
}

if(isset($_POST['logout']))
{
    session_unset();
    session_destroy();
    header("location:login.php");
    exit();
}
?>