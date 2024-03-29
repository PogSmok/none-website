<?php 
    /**
     * Script for verification of logging in to dashboard, works using cookies
     **/
    //Handles unauthorised access via link etc.
    require "return.php";
    blockLink(__FILE__);

    //Connect to the database
    require "config.php";
    $connection = connect();

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])){
        if(isset($_POST["username"]) && isset($_POST["password"])){
            $username = $_POST["username"];
            $password = $_POST["password"];
            $sql = "SELECT `password` FROM `admin` WHERE `username` = '$username'";
            $db = mysqli_query($connection, $sql);
            if(mysqli_num_rows($db) > 0) {
                $dbPass = mysqli_fetch_assoc($db)["password"];
                if(password_verify($password, $dbPass)) {
                    setcookie("isVerified", 1, time() + 60*30, "/");
                    header("Location: dashboard.php");
                    exit;
                }
            }
        }
    }

    if(!isset($_COOKIE["isVerified"]) || $_COOKIE["isVerified"] != 1){
        header("Location: dashboard-login.php");
        exit;
    }
?>