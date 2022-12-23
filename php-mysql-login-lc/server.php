<?php

/**
 * La password di default è appunto password
 */

function login($username, $password, $conn)
{
    // verifico se la sessione è già stata avviata
    // https://www.php.net/manual/en/function.session-status.php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }


    $md5password = md5($password);

    $stmt = $conn->prepare("SELECT `id`, `username` FROM `users` WHERE `username` = ? AND `password` = ?");
    $stmt->bind_param('ss', $username, $md5password);

    $stmt->execute();

    $result = $stmt->get_result();

    $num_rows = $result->num_rows;

    if ($num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userId'] = $row['id'];
        $_SESSION['username'] = $row['username'];
    } else {
        $_SESSION['userId'] = 0;
        $_SESSION['username'] = '';
    }

    session_write_close();
}
