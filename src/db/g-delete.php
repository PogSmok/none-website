<?php 
    /**
     *  Script deleting gallery folders and images
     **/

    //Handles unauthorised access via link etc.
    if(!function_exists("blockLink")){
        require "return.php";
    }
    blockLink(__FILE__);

    //Connect to the database
    require "config.php";
    $connection = connect();

    $_POST = array_map("trim", $_POST);
    forEach($_POST as $p){
        if(preg_match("/delete/i", $p) && isset($p)){
            $id = substr($p, strpos($p, "_") + 1);
            $deletingFolder = false;
            if(mb_substr($id, 0, 1) == "f"){
                $id = substr($id, 1);
                $deletingFolder = true;
            }

            if($deletingFolder){
                //Check if the folder is used as an examples folder
                $isUsedCheck = "SELECT * FROM `examples` WHERE `id` = '$id'";
                $isUsedCheckQuery = mysqli_query($connection, $isUsedCheck);
                if(!$isUsedCheckQuery) {
                    throw new ErrorException("Couldn't connect to the database");
                }

                if(mysqli_num_rows($isUsedCheckQuery) != 0){
                    throw new ErrorException("Cannot delete a folder, that contains examples used in the contact page");
                }

                //Delete all related images and the folder
                $imgDeleteSql = "DELETE FROM `gallery` WHERE `parent_folder` = '$id'";
                $folderDeleteSql = "DELETE FROM `gallery_folders` WHERE `id` = '$id'";
                if(mysqli_query($connection, $imgDeleteSql) && mysqli_query($connection, $folderDeleteSql)){
                    echo "<meta http-equiv='refresh' content='0'>";
                    header("Location: dashboard.php");
                } else {
                    throw new ErrorException("Couldn't delete from the database");
                }
            } else {
                //Delete entry in the database
                $imgDeleteSql = "DELETE FROM `gallery` WHERE `id` = '$id'";
                if(mysqli_query($connection, $imgDeleteSql)){
                    echo "<meta http-equiv='refresh' content='0'>";
                    echo "<script type='text/javascript'>alert('Successfully deleted!');</script>";
                } else {
                    throw new ErrorException("Couldn't delete from the database");
                }
            }
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
?>