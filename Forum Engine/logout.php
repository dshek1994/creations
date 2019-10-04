<?php
require_once 'lib/common.php';

session_start();
$conn = connect_to_db();
logout();
redirectAndExit('index.php');