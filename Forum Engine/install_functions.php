<?php

function createUser($conn, $username, $length = 10){
    //Get current time when creating a user
    $t = time();
    $currTime = date('Y-m-d', $t);
    //this algorithm creates a random password
    $alphabet = range(ord('A'), ord('z'));
    $alphabetLength = count($alphabet);

    $password = '';
    for($i = 0; $i < $length; $i++){
        $letterCode = $alphabet[rand(0, $alphabetLength-1)];
        $password .= chr($letterCode);
    }
    echo 'Created admin user. The password is ' . $password;

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, pass, created_at) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hash, $currTime);
    $stmt->execute();

    return;
}