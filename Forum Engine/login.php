<?php
require_once 'lib/common.php';

session_start();

//Handle the form posting
$username = '';
if($_POST){
    //Init the session and the database
    $conn = connect_to_db();

    //We redirect only if the password is correct
    $username = $_POST['username'];
    $ok = tryLogin($conn, $username, $_POST['pass']);
    if($ok){
        login($username);
        redirectAndExit('index.php');
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application | Login
        </title>
        <meta http-equiv="Content-type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <?php require 'title.php' ?>

        <p>Login here:</p>

        <form
            method="post"
        >
            <p>
                Username:
                <input type="text" name="username" />
            </p>
            <p>
                Password:
                <input type="password" name="pass" />
            </p>
            <input type="submit" name="submit" value="Login" />
        </form>
    </body>
</html>