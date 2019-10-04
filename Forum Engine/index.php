<?php
require_once 'lib/common.php';

session_start();

//connect to the database, run a query, and handle errors
$conn = new mysqli($servername, $username, $password, $database);
$sql = mysqli_query($conn, 'SELECT id, title, created_at, body FROM post ORDER BY created_at DESC');

if($sql === false){
    throw new Exception('There was a problem running this query');
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>A blog application</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div style="float: right;">
            <?php require_once 'lib/common.php'; if (isLoggedIn()): ?>
            Hello <?php echo htmlEscape(getAuthUser()) ?>.
                <a href="logout.php">Log out</a>
            <?php else: ?>
                <a href="login.php">Log in </a>
            <?php endif ?>
        </div>
        <div class="header">
            <h1>Blog Title</h1>
        </div>
        <p>This paragraph summarizes what the blog is about.</p>
        <div class="row">
            <div class="card">
            <?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)):  ?>
            <h2>
                <?php echo htmlEscape($row['title']) ?>
            </h2>
            <div>
                <?php echo $row['created_at'] ?>
                <div class="fakeimg" style="height:200px;">Image</div>
                <?php echo countCommentsForPost($row['id']); echo ' comments' ?>
            </div>
            <p>
                <?php echo htmlEscape($row['body']) ?>
            </p>
            <p>
                <a href="view-post.php?post_id=<?php echo $row['id'] ?>">Read more...</a>
            </p>
        <?php endwhile ?>
            </div>
        </div>
    </body>
</html>
