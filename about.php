<?php 
    //Connect to the database
    require "./db/config.php";
    $connection = connect();

    //Display about content from DB
    $aboutSelectSql = "SELECT * FROM `about`";
    $aboutContent = mysqli_query($connection, $aboutSelectSql);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>About</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" vieport-fit="cover"> 

        <link rel="stylesheet" href="./css/about.css">
        <link rel="stylesheet" href="./css/nav.css">
        <link rel="stylesheet" href="./css/footer.css">

        <!-- Generates the nav bar -->
        <script src="./scripts/nav.js" defer></script>
        
        <!-- Scrolls into given posts, changes highlight, styles it and grants functionality to about-nav -->
        <script src="./scripts/scroll-and-style.js" defer></script>
    </head>

    <body>
        <!-- Content and functionality from "./scripts/nav.js" -->
        <div class="nav-bar"></div>

        <div class="backgrounds">
            <div class="background"></div>
            <div class="foreground-container">
                <div class="foreground"></div>
            </div>
        </div>

        <!-- Functionality from "./scripts/scroll-to.js" -->
        <div class="about-nav">
            <?php foreach($aboutContent as $post){ ?>
                <div class="about-nav-button-container">
                    <div class="about-nav-button" id=<?php echo $post['id'];?> style=<?php echo "color:".$post["color"]?>>
                        <div class='about-nav-button-text'>
                            <?php echo $post["title"]; ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="about">
            <?php foreach($aboutContent as $post){ ?>
                <div class="about-post-container" id=<?php echo "post-".$post["id"]; ?>>
                    <div class="about-post">
                        <?php if($post["path"]){ 
                            $path = "./db/".substr($post["path"], 2)
                            ?>
                            <img src=<?php echo $path; ?> class="about-img">
                        <?php } ?>
                        <div class="about-text">
                            <?php echo $post["description"] ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        
        <div class="footer">
            <img src="./resources/about/about-footer.webp" class="footer-img">
        </div>
    </body> 
</html>