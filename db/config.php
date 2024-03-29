<?php
    /**
     *  Script for connection to the site's database
     *  Database Structure:
     *      admin:
     *          id -> int(11): primary key A_I (do not set)
     *          username -> varchar(255)
     *          password -> varchar(255) (password is stored hashed with password_hash())
     *      about:
     *          id -> int(11): primary key A_I (do not set)
     *          title -> varchar(255)
     *          color -> varchar(255) (hex representation)
     *          description -> text
     *          path -> varchar(255) || NULL: path to the image, NULL if no image is assigned
     *      gallery_folders:
     *          id -> int(11): primary key A_I (do not set) 
     *          name -> varchar(255)
     *          color -> int(3): defines the color of the folder, id from ./folder-types
     *          hex -> varchar(9): color hex of the folder color
     *          path -> varchar(255): path to the image  
     *      gallery:
     *          id -> int(11): primary key A_I (do not set)
     *          parent_folder -> varchar(255): id of the parent folder from gallery_folders
     *          path -> varchar(255): path to the image  
     *      examples:
     *          id -> int(11): primary key A_I (do not set)
     *          name -> varchar(255)
     *          folder_id -> int(11)
     **/

    //Handles unauthorised access via link etc.
    if(!function_exists("blockLink")){
        require "return.php";
    }
    blockLink(__FILE__);
    

    /**
     * Connects to the website's database
     * @return mysqli Connection object
     */
    function connect(){
        $DBHOST = "";
        $DBUSERNAME = "";
        $DBPASSWORD = "";
        $DBNAME = "";
        $DBPORT = NULL;
        $DBSOCKET = NULL;

        $connection = mysqli_connect($DBHOST, $DBUSERNAME, $DBPASSWORD, $DBNAME, $DBPORT, $DBSOCKET) or die("Couldn't connect to the database. Reason: " .mysqli_connect_error());
        return $connection;
    }

    //e-mail cridentials to send forms to
    $EMAIL = "commissions@none.graphics";
?>
