<?php
require_once 'lib/common.php';

session_start();

//Get the post id
if(isset($_GET['post_id'])){
    $postId = $_GET['post_id'];
}else{
    $postId = 0;
}
//create connection
$conn = new mysqli($servername, $username, $password, $database);

//check connection
if($conn->connect_error){
    die('Connection failed: ' . $conn->connect_error);
}

if(!($stmt = $conn->prepare('SELECT title, created_at, body FROM post WHERE id = ?'))){
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
}

if(!$stmt->bind_param('i', $postId)){
    echo "Binding parameters failed: (" . $stmt->errno. ") " . $stmt->error;
}

if(!$stmt->execute()){
    echo "Execute failed: (" . $stmt->errno. ") " . $stmt->error;
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$errors = null;
if($_POST){
    $commentData = array('person' => $_POST['comment-name'], 'website' => $_POST['comment-website'], 'the_text' => $_POST['comment-text']);
    $errors = addCommentToPost($conn, $postId, $commentData);

    if(!$errors){
        redirectAndExit('view-post.php?post_id' . $postId);
    }
}else{
    $commentData = array('person' => '', 'website' => '', 'the_text' => '');
}
//Swap carriage returns for paragraph breaks
$bodyText = htmlEscape($row['body']);
$paraText = str_replace('\n', '</p><p>', $bodyText);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            A blog application |
            <?php echo htmlEscape($row['title']) ?>
        </title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    </head>
    <body>
        <a href="index.php">
            <h1>Blog title</h1>
        </a>
        <p>This paragraph summarizes what the blog is about.</p>

        <h2>
            <?php echo htmlEscape($row['title']) ?>
        </h2>
        <div>
            <?php echo $row['created_at'] ?>
        </div>
        <p>
            <?php echo $paraText ?>
        </p>
        <h3><?php echo countCommentsForPost($postId); echo ' comments' ?> </h3>
        <?php foreach (getCommentsForPost($postId) as $comment): ?>
            <?php //for now we'll use a horizontal rule-off to split it up a bit ?>
            <hr />
            <div class="comment">
                <div class="comment-meta">
                    Comment from
                    <?php echo htmlEscape($comment['person']) ?>
                    on
                    <?php echo ($comment['created_at']) ?>
                </div>
                <div class="comment-body">
                    <?php echo htmlEscape($comment['the_text']) ?>
                </div>
            </div>
        <?php endforeach ?>

        <?php require 'comment-form.php' ?>
    </body>
</html>