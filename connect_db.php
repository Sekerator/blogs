<?php
function getConn()
{
    $host = 'localhost';
    $db   = 'blogdb';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8mb4';
    $dsn = "mysql:host=" . $host . ";dbname=" . $db . ";charset=" . $charset;
    $opt =
        [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    return new PDO($dsn, $user, $pass, $opt);
}
?>