<?php
require_once 'lib/common.php';

$relativeUrl = $_SERVER['PHP_SELF'];
$urlFolder = substr($relativeUrl, 0, strrpos($relativeUrl, '/') + 1);
$host = $_SERVER['HTTP_HOST'];
//$con = connect_to_db();

$fullUrl = 'http://' . $host . $urlFolder . 'view-post.php?post_id=3';

header('Location:' . $fullUrl);


?>