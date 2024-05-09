<?php
    /**
     *  Script creating folders and adding images to folders in gallery
     **/

    //Handles unauthorised access via link etc.
    if(!function_exists("blockLink")){
        require "return.php";
    }
    blockLink(__FILE__);


    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["g-create"])){
        if(isset($_POST["type"])){
            $_POST = array_map("trim", $_POST);

            //Check if user is creating a folder, or adding an image

            //User is creating a folder
            if($_POST["type"] == "f"){
                if(!isset($_POST["name"])){
                    echo "<meta http-equiv='refresh' content='0'>";
                    echo "<script type='text/javascript'>alert('No folder name was provided!');</script>";
                    return;
                }
                $name = htmlspecialchars($_POST["name"]);
                $color = $_POST["color"];
                //ALL COLOR HEXES FOLDERS CAN HAVE ARE HERE, WHEN ADDING A NEW HEX CHANGE THIS ARRAY
                $hexArray = array("#f8f8f8", "#d936ea", "#5f35ea", "#31e9e6", "#46ea37", "#e9832a", "#eb8d3c", "#eb3c3c");
                $hex = $hexArray[$color - 1];

                if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $temp = explode(".", $_FILES["image"]["name"]);
                    $newfilename = round(microtime(true)) . '.' . end($temp);

                    if(move_uploaded_file($_FILES['image']['tmp_name'], "./img-g/folder-img/". $newfilename))
                        $path = "./img-g/folder-img/". $newfilename;
                    else {
                        throw new ErrorException("Couldn't save the file");
                    }

                    $folderCreateSql = "INSERT INTO `gallery_folders` (`name`, `color`, `hex`, `path`) VALUES ('$name', '$color', '$hex', '$path')";
                    $folderCreateQuery = mysqli_query($connection, $folderCreateSql);
                    if($folderCreateQuery){
                        echo "<script type='text/javascript'>alert('Sucessfully created!');</script>";
                    } else {
                        throw new ErrorException("Couldn't upload to database");
                    }
                }
            //User is adding an image
            } else if($_POST["type"] == "i"){

                //Check if folder id is valid
                $id = $_POST["id"];
                $folderCheckSql = "SELECT * FROM `gallery_folders` WHERE `id` = '$id'";
                $folderCheckQuery = mysqli_query($connection, $folderCheckSql);
                if(mysqli_num_rows($folderCheckQuery) == 0){
                    echo "<meta http-equiv='refresh' content='0'>";
                    echo "<script type='text/javascript'>alert('An incorrect folder id was provided!');</script>";
                    return;
                }

                if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                    $temp = explode(".", $_FILES["image"]["name"]);
                    $newfilename = round(microtime(true)) . '.' . end($temp);

                    if(move_uploaded_file($_FILES['image']['tmp_name'], "./img-g/img/". $newfilename))
                        $path = "./img-g/img/". $newfilename;
                    else {
                        throw new ErrorException("Couldn't save the file");
                    }
                }

                $imgAddSql = "INSERT INTO `gallery` (`parent_folder`, `path`) VALUES ('$id', '$path')";
                $imgAddQuery = mysqli_query($connection, $imgAddSql);
                if($imgAddQuery){
                    echo "<script type='text/javascript'>alert('Sucessfully added an image!');</script>";
                } else {
                    throw new ErrorException("Couldn't upload to database");
                }
            }
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }