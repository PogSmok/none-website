<?php 
    //Connect to the database
    require "./db/config.php";
    $connection = connect();

    //Send e-mail form on submit
    if(isset($_POST['email'])) {
        $to = $EMAIL;
        $subject = "Commission Request";

        //All form data
        $comm = $_POST["type"];
        $name = $_POST["name"];
        $email = $_POST["email"];
        $description = $_POST["description"];
        $references = $_POST["references"];

        //Content of the mail
        $message = "You have gotten a commission request from a user " . $name ."!\n\nTheir email: " . $email . "\n\nThe commission type they have chosen: " . $comm . "\n\nThe description of the commission: " . $description . "\n\nThe references of the characters: $references";

        //Reset the form input
        foreach ($_POST as $key => $value) {
            $_POST[$key] = "";
        }

        if(!mail($to, $subject, $message)) {   
            echo("<script>alert('Something went wrong, if the error persists send your email manually to: $to');</script>");  
        } else {
            echo("<script>alert('Your email has been sent.');</script>"); 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Contact</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" vieport-fit="cover"> 

        <link rel="stylesheet" href="./css/contact.css">
        <link rel="stylesheet" href="./css/contact-confirmation.css">
        <link rel="stylesheet" href="./css/contact-form.css">
        <link rel="stylesheet" href="./css/nav.css">
        <link rel="stylesheet" href="./css/footer.css">

        <!-- Generates the nav bar -->
        <script src="./scripts/nav.js" defer></script>

        <!-- Adds highlight to tiers and confirmation window before form -->
        <script src="./scripts/tier-style-and-confirmation.js" defer></script>

        <!-- Creates form screen and adds hyperlinks to it -->
        <script src="./scripts/form.js" defer></script>
    </head>
    <body>
        <div class="form-container">
            <img class="exit-form" src="./resources/contact/close.webp">
            <form class="form" id="comm-form" action="contact.php" method="POST">
                <div class="title">
                    Fill-out Form
                </div>
                <div id="selected-tier">
                    Selected tier: 
                </div>
                <input type="hidden" id="type" name="type" value="">
                <div class="form-field">
                    <label for="name"><b>Name/Nickname</b></label>
                    <input type="text" placeholder="How should I call you?" name="name" pattern=".{2,20}" title="from 2 to 20 characters required" required>
                </div>
                <div class="form-field">
                    <label for="email"><b>E-mail</b></label>
                    <input type="email" placeholder="myname@example.com" name="email" required>
                </div>
                <div class="form-field">
                    <label for="description"><b>Description</b></label>
                    <textarea name="description" placeholder="What do you want? How should it look?" rows="7"></textarea>
                </div>
                <div class="form-field">
                    <label for="references"><b>References</b></label>
                    <textarea name="references" placeholder="Put links to your references or any other important images you want me to see here" rows="3"></textarea>
                </div>
                <div class="submit-container">
                    <input type="image" src="./resources/contact/submit.webp" alt="Submit" name="submit" id="submit">
                </div>
            </form>
            <img src="./resources/contact/form.webp" class="form-img">
        </div>

        <div class="confirmation-container">
            <img class="exit" src="./resources/contact/close.webp">
            <div class="type-selection">
                <div class="tier-selection" id="left-tier">
                </div>
                <div class="tier-selection" id="current-tier">
                        <img class="selection-arrow" id="left-arrow" src="./resources/contact/arrow1l.webp">
                        <div class="current-tier-text">
                        </div>
                        <img class="selection-arrow" id="right-arrow" src="./resources/contact/arrow1r.webp">
                </div>
                <div class="tier-selection" id="right-tier">
                </div>
            </div>
            <div class="label">

            </div>
            <div class="examples-label">
                Examples:
            </div>
            <div class="examples">
                <img src="./resources/contact/arrowl.webp" class="img-arrow" id="img-left">
                <div class="type" id="sketch">
                    <?php
                    //Select sketches
                    $sketchSelectSql = "SELECT `path` FROM `gallery` INNER JOIN `examples` ON `parent_folder` = `folder_id` WHERE `name` = 'sketch'";
                    $sketches = mysqli_query($connection, $sketchSelectSql);
                    foreach($sketches as $sketch){ 
                        $path = "./db/".substr($sketch["path"], 2)
                    ?>
                        <img src=<?php echo $path; ?> class="example-img sketch-img" loading="lazy">
                    <?php } ?>
                </div>
                <div class="type" id="drawing">
                    <?php
                    //Select drawings
                    $drawingSelectSql = "SELECT `path` FROM `gallery` INNER JOIN `examples` ON `parent_folder` = `folder_id` WHERE `name` = 'drawing'";
                    $drawings = mysqli_query($connection, $drawingSelectSql);
                    foreach($drawings as $drawing){ 
                        $path = "./db/".substr($drawing["path"], 2)
                    ?>
                        <img src=<?php echo $path; ?> class="example-img drawing-img" loading="lazy">
                    <?php } ?>
                </div>
                <div class="type" id="painting">
                    <?php
                    //Select drawings
                    $paintingSelectSql = "SELECT `path` FROM `gallery` INNER JOIN `examples` ON `parent_folder` = `folder_id` WHERE `name` = 'painting'";
                    $paintings = mysqli_query($connection, $paintingSelectSql);
                    foreach($paintings as $painting){ 
                        $path = "./db/".substr($painting["path"], 2)
                    ?>
                        <img src=<?php echo $path; ?> class="example-img painting-img" loading="lazy">
                    <?php } ?>
                </div>
                <img src="./resources/contact/arrowr.webp" class="img-arrow" id="img-right">
                <div class="about-proceed-container">
                    <div class="about-tier-container">
                        <div class="about-tier"></div>
                    </div>
                    <div class="proceed-container">
                        <img src="./resources/contact/proceed.webp" class="proceed">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Content and functionality from "./scripts/nav.js" -->
        <div class="nav-bar"></div>

        <div class="backgrounds">
            <div class="background"></div>
            <div class="foreground-container">
                <div class="foreground"></div>
            </div>
        </div>

        <div class="content-container">
            <div class="content">
                <div class="tier-container">
                    <div class="tier" id="0">
                        <img src="./resources/contact/tiers/default/0.webp" class="tier-img">
                    </div>
                    <div class="tier" id="1">
                        <img src="./resources/contact/tiers/default/1.webp" class="tier-img">
                    </div>
                    <div class="tier" id="2">
                        <img src="./resources/contact/tiers/default/2.webp" class="tier-img">
                    </div>
                    <div class="tier" id="3">
                        <img src="./resources/contact/tiers/default/3.webp" class="tier-img">
                    </div>
                </div>
                <div class="mobile-tier-container">
                    <div class="mobile-tier" id="0">
                        <img src="./resources/contact/tiers/mobile/0.webp" class="mobile-tier-img">
                    </div>
                    <div class="mobile-tier" id="1">
                        <img src="./resources/contact/tiers/mobile/1.webp" class="mobile-tier-img">
                    </div>
                    <div class="mobile-tier" id="2">
                        <img src="./resources/contact/tiers/mobile/2.webp" class="mobile-tier-img">
                    </div>
                    <div class="mobile-tier" id="3">
                        <img src="./resources/contact/tiers/mobile/3.webp" class="mobile-tier-img">
                    </div>
                </div>
            </div>
        </div>

        <div class="footer">
            <img src="./resources/contact/contact-footer.webp" class="footer-img">
        </div>
    </body>

</html>
