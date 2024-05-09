<?php 
    //Connect to the database
    require "./db/config.php";
    $connection = connect();

    //Display folders from DB
    $foldersSelectSql = "SELECT * FROM `gallery_folders`";
    $folders = mysqli_query($connection, $foldersSelectSql);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Gallery</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" vieport-fit="cover"> 

        <link rel="stylesheet" href="./css/gallery.css">
        <link rel="stylesheet" href="./css/nav.css">
        <link rel="stylesheet" href="./css/footer.css">

        <!-- Generates the nav bar -->
        <script src="./scripts/nav.js" defer></script>

        <!-- Adds functionality to folders -->
        <script src="./scripts/display-from-folders.js" defer></script>

        <!-- Enlarges images on click -->
        <script src="./scripts/fullscreen-on-click.js" defer></script>
    </head>

    <body>
        <div id="fullscreen"></div>
        
        <!-- Content and functionality from "./scripts/nav.js" -->
        <div class="nav-bar"></div>

        <div class="backgrounds">
            <div class="background"></div>
            <div class="foreground-container">
                <div class="foreground"></div>
            </div>
        </div>

        <div class="folders">
            <?php foreach($folders as $f){ ?>
                    <?php
                        $id = $f["id"];
                        $colorId = $f["color"];
                        $colorPath = "./resources/gallery/folder-colors/$colorId.webp";
                        $colorHex = $f["hex"];

                        $rawPath = substr($f["path"], 2);
                        $path = "./db/$rawPath";
                    ?>
                    <div class="folder-text-container">
                        <div class="folder-label-container">
                            <div class="folder-label" style=<?php echo "color:$colorHex;";?>>
                                <b><?php echo $f["name"]; ?></b>
                            </div>
                        </div>
                        <div class="folder-container">
                            <img class="folder" src=<?php echo $colorPath; ?> id=<?php echo $id; ?>>
                            <img class="folder-image" src=<?php echo $path; ?>>
                            <img class="folder-image-frame" src="./resources/gallery/image-frame.webp">
                        </div>
                    </div>
            <?php } ?>
        </div>

        <?php foreach($folders as $f){ ?>
            <?php 
                $parentId = $f["id"];
                $isEmpty = true;
                //Display images from DB
                $imagesSelectSql = "SELECT * FROM `gallery` WHERE `parent_folder` = '$parentId'";
                $images = mysqli_query($connection, $imagesSelectSql);
            ?>
            <div class="images" id=<?php echo "parent-id-".$parentId ?>>
                <div class="images-header">
                    <div class="title"><?php echo $f["name"]?></div>
                    <img class="return-button" id=<?php echo "return-id-".$parentId ?> src="./resources/gallery/back.webp">
                </div>
                <?php foreach($images as $i){ ?>
                    <?php $isEmpty = false ?>
                    <div class="gallery-image-container">
                        <?php 
                            $rawPath = substr($i["path"], 2);
                            $path = "./db/$rawPath";
                        ?>
                        <img class="gallery-image" src=<?php echo $path; ?> loading="lazy">
                    </div>
                <?php } ?>
                <?php if($isEmpty){ ?>
                    <div class="empty">No images in this folder. Yet!</div>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="footer">
            <img src="./resources/gallery/gallery-footer.webp" class="footer-img">
        </div>
    </body>

</html>
