<?php
require_once 'lib/common.php';
require_once 'install_functions.php';

session_start();

$dir_path = realpath(__DIR__);
$error = '';

//create connection
$conn = new mysqli($servername, $username, $password, $database);
//check connection
if($conn->connect_error){
    die('Connection failed: ' . $conn->connect_error);
}

$templine = '';
// Read in entire file
$lines = file($dir_path . '/init.sql');
// Loop through each line
foreach ($lines as $line) {
// Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
        continue;

// Add this line to the current segment
    $templine .= $line;
// If it has a semicolon at the end, it's the end of the query
    if (substr(trim($line), -1, 1) == ';') {
        // Perform the query
        $conn->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . $conn->error() . '<br /><br />');
        // Reset temp variable to empty
        $templine = '';
    }
}
//see how many rows we created
$count = null;
if(!$error){
    $sql_comm = "SELECT COUNT(*) AS c FROM post";
    $stmt = mysqli_query($conn, $sql_comm);
    if($stmt){
        $count = $stmt->num_rows;
    }
}
$admin = 'admin';
createUser($conn, $admin);
$conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Blog installer</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <style type="text/css">
            .box {
                border: 1px dotted silver;
                border-radius: 5px;
                padding: 4px;
            }
            .error {
                background-color: #ff6666;
            }
            .success {
                background-color: #88ff88;
            }
        </style>
    </head>
    <body>
        <?php if ($error) : ?>
            <div class="error box">
                <?php echo $error ?>
            </div>
        <?php else: ?>
            <div class="success box">
                The database and demo data was created OK.
                <?php if ($count) : ?>
                    <?php echo $count ?> new rows were created.
                <?php endif ?>
            </div>
        <?php endif ?>
    </body>
</html>