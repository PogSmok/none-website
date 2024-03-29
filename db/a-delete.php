<?php 
    /**
     *  Script deleting an about me post
     **/

    //Handles unauthorised access via link etc.
    require "return.php";
    blockLink(__FILE__);

    //Connect to the database
    require "config.php";
    $connection = connect();

    $_POST = array_map("trim", $_POST);
    forEach($_POST as $p){
            if(preg_match("/delete/i", $p) && isset($p)){
                $id = substr($p, strpos($p, "_")+1);

                //Delete any related images from the server
                $findFileToDeleteSqL = "SELECT `path` FROM `about` WHERE `id` = '$id'";
                $filesToDelete = mysqli_query($connection, $findFileToDeleteSqL);
                foreach($filesToDelete as $file){
                    if($file["path"] != NULL && file_exists($file["path"])){
                        unlink($file["path"]);
                    }
                } 

                //Delete entry in the database
                $aboutDeleteSql = "DELETE FROM `about` WHERE `id` = '$id'";
                if(mysqli_query($connection, $aboutDeleteSql)){
                    echo "<meta http-equiv='refresh' content='0'>";
                    header("Location: dashboard.php");
                    exit;
                } else {
                    throw new ErrorException("Couldn't delete from database");
                }
            }
        }
?>