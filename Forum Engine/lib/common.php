<?php
$servername = 'localhost';
$username = 'root';
$password = 'cassie123';
$database = 'blogdb';

function connect_to_db(){
    $servername = 'localhost';
    $username = 'root';
    $password = 'cassie123';
    $database = 'blogdb';

    $conn = new mysqli($servername, $username, $password, $database);

    return $conn;

}
/**
 * Escapes HTML so it is safe to output
 */
function htmlEscape($html){
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}

function convertSqlDate($sqlDate){
    $date = DateTime::createFromFormat('Y-m-d', $sqlDate);

    return $date->format('d M Y');
}
function countCommentsForPost($postId){
    $conn = connect_to_db();
    $sql = 'SELECT
                *
            FROM
                comment
            WHERE
                post_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $row_count = $result->num_rows;
    return $row_count;
}

function getCommentsForPost($postId){
    $conn = connect_to_db();
    $sql = 'SELECT 
                id, person, the_text, created_at, website
            FROM 
                comment
            WHERE
                post_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $postId);
    $stmt->execute();

    return $result = $stmt->get_result();
}

function addCommentToPost($connection, $postId, array $commentData){
    $errors = array();

    if(empty($commentData['person'])){
        $errors['name'] = 'A name is required';
    }
    if(empty($commentData['the_text'])){
        $errors['the_text'] = 'A comment is required';
    }

    if(!$errors){
        $t = time();
        $currDate = date("Y-m-d", $t);
        $sql = "INSERT INTO comment (person, website, the_text, post_id, created_at) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sssis', $commentData['person'], $commentData['website'], $commentData['the_text'], $postId, $currDate);
        $stmt->execute();
    }

    return $errors;
}

function redirectAndExit($script){
    //Get domain of relative url and work out the folder
    $relativeURL = $_SERVER['PHP_SELF'];
    $urlFolder = substr($relativeURL, 0, strrpos($relativeURL, '/') + 1);

    //redirect to the full URL
    $host = $_SERVER['HTTP_HOST'];
    $fullUrl = 'http://' . $host . $urlFolder . $script;
    header('Location:' . $fullUrl);
    //exit();
}

function tryLogin($conn, $username, $password){
    $sql = "SELECT pass FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $hash_object = $stmt->get_result();
    $hash_array = $hash_object->fetch_assoc();
    $hash = implode("",$hash_array);
    $success = password_verify($password, $hash);

    return $success;
}

function login($username){
    session_regenerate_id();

    $_SESSION['logged_in_username'] = $username;
}

function isLoggedIn(){
    return isset($_SESSION['logged_in_username']);
}

function logout(){
    unset($_SESSION['logged_in_username']);
}

function getAuthUser(){
    return isLoggedIn() ? $_SESSION['logged_in_username'] : null;
}
?>