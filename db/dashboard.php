<?php
    //Handles unauthorised access via link etc.
    require "verify.php";

    //Creates or edits an about me post
    require "a-create.php";

    //Creates folders or adds images to folders in gallery
    require "g-create.php";

    $connection = connect();
    //Display about content from DB
    $aboutSelectSql = "SELECT * FROM `about`";
    $aboutContent = mysqli_query($connection, $aboutSelectSql);

    //Display gallery content from DB;
    $galleryFolderSelectSql = "SELECT * FROM `gallery_folders`";
    $galleryFolders = mysqli_query($connection, $galleryFolderSelectSql);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" vieport-fit="cover"> 

        <link rel="stylesheet" href="./css/dashboard.css">

        <!-- Displays/Hides images each folder contains -->
        <script src="./scripts/display-img.js" defer></script>
    </head>

    <body>
        <div class="sections">
            <div class="section">
                <h1>About</h1>
                <div class="a-create-container">
                    <form method="POST" enctype="multipart/form-data">
                        <h2>Create or edit an about me post</h2>
                        <label>Id of the post to be edited</label><br>
                        <input type="text" name="id" placeholder="Leave empty if creating" autocomplete="off"><br>
                        <label>Title</label><br>
                        <input type="text" name="title" placeholder="My new artistic creation" maxlength="10" autocomplete="off" required><br>
                     
                        <label>Color</label><br>
                        <input type="text" name="color" placeholder="#4f04c7" autocomplete="off" required><br>

                        <label>Description</label><br>
                        <textarea rows="9" cols="50" name="description" placeholder="So I drew this beautiful thing, really beautifully and it's very beautiful." maxlength="400" autocomplete="off" required></textarea><br>         

                        <label>Image</label><br>
                        <input type="file" name="image" accept="image/png, image/jpg, image/jpeg"><br>

                        <button type="submit" name="a-create">Create</button>
                    </form>
                </div>

                <table class="about-table">
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Delete</th>
                    </tr>
                    <?php foreach($aboutContent as $q) { ?>
                        <tr>
                            <td>
                                <?php echo $q["id"]; ?>
                            </td>
                            <td>
                                <div class="title" style=<?php echo "color:".$q["color"] ?>> <?php echo $q["title"]; ?> </div>
                            </td>
                            <td>
                                <?php
                                    if($q["path"]){ ?>
                                        <img src=<?php echo $q["path"]; ?> class="about-img">
                                    <?php } else { ?>
                                        <div class="no-path"> <?php echo "No image has been set" ?> </div>
                                    <?php } ?> 
                            </td>
                            <td>
                                <div class="description"> <?php echo $q["description"]; ?> </div>
                            </td>
                            <td>
                                <form method="post" action="a-delete.php">
                                    <input type="submit" name="about-delete" class="button" onclick="return confirm('Are you sure you want to delete the post?')" value=<?php echo "Delete_{$q["id"]}" ?> /> 
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <div class="section">
                <h1>Gallery</h1>
                <div class="g-create-container">
                    <form method="POST" enctype="multipart/form-data">
                        <h2>Add an image or a folder</h2>
                        <label>Select the action add</label><br>
                        <input type="radio" id="f" value="f" name="type" required>
                        <label for="folder">Create a folder</label><br>
                        <input type="radio" id="i" value="i" name="type">
                        <label for="i">Add an image</label><br>
                        <label>Folder color (fill when creating a folder)</label>
                        <select name="color" id="color">
                            <option value="1">white</option>
                            <option value="2">purple</option>
                            <option value="3">blue</option>
                            <option value="4">sky blue</option>
                            <option value="5">green</option>
                            <option value="6">yellow</option>
                            <option value="7">orange</option>
                            <option value="8">red</option>
                        </select><br><br>

                        <label>Folder name (fill when creating a folder)</label><br>
                        <input type="text" name="name" max-length="10" placeholder="Name of the folder"><br>

                        <label>Folder id  (fill when adding an image)</label><br>
                        <input type="text" name="id" max-length="10" placeholder="Id of the parent folder"><br>

                        <label>Image</label><br>
                        <input type="file" name="image" accept="image/png, image/jpg, image/jpeg" required><br>

                        <button type="submit" name="g-create">Create</button>
                    </form>
                </div>

                <table class="gallery-table" id="main-gallery-table">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Display</th>
                            <th>Delete</th>
                        </tr>
                        <?php 
                        $first = true;
                        foreach($galleryFolders as $q){ 

                            //Merge first table with the defining orignal table
                            if(!$first){
                                echo '<table class="gallery-table">';
                            } 
                            $first = false;
                            ?>
                                <tr>
                                    <td style="width: 50px;">
                                        <?php echo $q["id"]; ?>
                                    </td>
                                    <td style="width: 100px;">
                                        <?php echo $q["name"]; ?>
                                    </td>
                                    <td>
                                        <img src=<?php echo $q["path"]; ?> class="folder-image">
                                    </td>
                                    <td style="width: 350px;">
                                        <button type="button" class="display-img" <?php echo "id='{$q['id']}'" ?> >Display/Hide images</button>
                                    </td>
                                    <td style="width: 150px;">
                                        <form method="POST" enctype="multipart/form-data" action="g-delete.php">
                                            <input type="submit" name="g-delete" class="button" onclick="return confirm('Are you sure you want to delete the folder and every image contained in it?')" value=<?php echo "Delete_f{$q["id"]}" ?> /> 
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            <?php
                            $selectImgSql = "SELECT * FROM `gallery` WHERE `parent_folder` = '{$q['id']}'";
                            $selectImgQuery = mysqli_query($connection, $selectImgSql); ?>

                            <table class="img-table" <?php echo "id='table-{$q['id']}'" ?> >
                                <tr>
                                    <th> 
                                        Id 
                                    </th>
                                    <th> 
                                        Image
                                    </th>
                                    <th> 
                                        Delete 
                                    </th>
                                </tr>
                                <?php foreach($selectImgQuery as $i){ ?>
                                    <tr>
                                        <td style="width: 100px;">
                                            <?php echo $i["id"]; ?>
                                        </td>
                                        <td style="width: 250px;">
                                            <img src=<?php echo $i["path"]; ?> class="gallery-img">
                                        </td>
                                        <td style="width: 150px;">
                                            <form method="POST" enctype="multipart/form-data"  action="g-delete.php">
                                                <input type="submit" name="g-delete" class="button" onclick="return confirm('Are you sure you want to delete the image?')" value=<?php echo "Delete_{$i["id"]}" ?> /> 
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                        <?php } ?>  
            </div>
        </div>
    </body>
</html>