<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" vieport-fit="cover"> 

        <link rel="stylesheet" href="./css/dashboard-login.css">
    </head>

    <form action="verify.php" method="POST">
        <h2>Login</h2>

        <label>Username</label>
        <input type="text" name="username" placeholder="Username" required><br>

        <label>Password</label>
        <input type="password" name="password" placeholder="Password" autocomplete="off" required><br> 

        <button type="submit" name="login">Login</button>
    </form>

</html>