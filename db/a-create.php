<?php
    /**
     *  Script creating or editing an about me post
     **/

    //Handles unauthorised access via link etc.
    if(!function_exists("blockLink")){
        require "return.php";
    }
    blockLink(__FILE__);

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["a-create"])){
        //Check if maximum amount of posts has been reached
        if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM `about`")) >= 6){
            echo "<meta http-equiv='refresh' content='0'>";
            echo '<script type="text/javascript">alert("Maximum amount of posts has been reached!\nDelete a post in order to be able to create new one.");</script>';
            return;
        }

        if(isset($_POST["title"]) && isset($_POST["description"]) && isset($_POST["color"])){
            $_POST = array_map("trim", $_POST);
            $title = htmlspecialchars($_POST["title"]);
            $description = nl2br(htmlspecialchars($_POST["description"]));
            $color = $_POST["color"];
            //Validate color hex
            if(!preg_match("/#([[:xdigit:]]{3}){1,2}\b/", $color)){
                echo "<meta http-equiv='refresh' content='0'>";
                echo "<script type='text/javascript'>alert('An incorrect color hex was provided!');</script>";
                return;
            }
            $path = NULL;

            //Check if user is editing
            $editing = false;
            if(isset($_POST["id"]) && $_POST["id"] != NULL){
                $id = $_POST["id"];
                //Check if the id is valid
                $checkId = "SELECT `path` FROM `about` WHERE `id` = '$id'";
                $oldEntries = mysqli_query($connection, $checkId);
                if(mysqli_num_rows($oldEntries) == 0){
                    echo "<meta http-equiv='refresh' content='0'>";
                    echo "<script type='text/javascript'>alert('An incorrect ID was provided!');</script>";
                    return;
                } else {
                    $editing = true;
                    foreach($oldEntries as $oldEntry){
                        //Delete any old files from the server
                        if($oldEntry["path"] != NULL && file_exists($oldEntry["path"])){
                            unlink($oldEntry["path"]);
                        }
                    }
                }
            }

            if(is_uploaded_file($_FILES['image']['tmp_name'])) {
                $temp = explode(".", $_FILES["image"]["name"]);
                $newfilename = round(microtime(true)) . '.' . end($temp);

                if(move_uploaded_file($_FILES['image']['tmp_name'], "./img-a/". $newfilename))
                    $path = "./img-a/". $newfilename;
                else {
                    throw new ErrorException("Couldn't save the file");
                }
            }

            if($editing) {
                $aboutEditSql = "UPDATE `about` SET `title` = '$title', `color` = '$color', `description` = '$description', `path` = '$path' WHERE `id` = '$id'";
                $aboutEditQuery = mysqli_query($connection, $aboutEditSql);
                if($aboutEditQuery){
                    echo "<script type='text/javascript'>alert('Sucessfully edited post $id');</script>";
                } else {
                    throw new ErrorException("Couldn't edit the database");
                }
            } else {
                $aboutCreateSql = "INSERT INTO `about` (`title`, `color`, `description`, `path`) VALUES ('$title', '$color', '$description', '$path')";
                $aboutCreateQuery = mysqli_query($connection, $aboutCreateSql);
                if($aboutCreateQuery){
                    echo "<script type='text/javascript'>alert('Sucessfully created!');</script>";
                } else {
                    throw new ErrorException("Couldn't upload to database");
                }
            }
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }
?>