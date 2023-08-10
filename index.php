<?php
require_once 'includes/config_session.php';
require_once 'includes/signup_view.php';
require_once 'includes/login_view.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>Login</h3>

    <form action="includes/login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button>Login</button>
    </form>

    <?php
    check_login_errors();

    ?>
    
    <h3>Signup</h3>

    <form action="includes/signup.php" method="post">
        <?php
         signup_inputs()
        ?>
        <button>Signup</button>
    </form>

    <?php
    check_signup_errors(); //show error messages to your users
    ?>
</body>
</html>