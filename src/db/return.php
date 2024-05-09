<?php
    /**
     * Blocks direct access to files via link
     * @param string $sitePath path to the site
     * @return void 
     **/
    function blockLink($sitePath){
        if($_SERVER['REQUEST_METHOD']=='GET' && realpath($sitePath) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
            header('HTTP/1.1 404 Not Found');
            include("../404.html");
            die();
        }
    }

    blockLink(__FILE__);
?>