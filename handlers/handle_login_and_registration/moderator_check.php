<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
if(!$dbconn) {
    echo "An error occurred - Hhhh\n";
    exit;
}

session_save_path("/tmp/");
session_start();

if ( $_SESSION['login']['logged_in'] == true ) {
    $result = pg_prepare($dbconn, "moderator_check_query", 
        "SELECT a_moderator 
        FROM users
        WHERE email = $1;
    ");
    $a_moderator = pg_execute($dbconn, "moderator_check_query", array($_SESSION['login']['email']));

    while ( $row = pg_fetch_array ( $a_moderator ) ) {
        $_SESSION['login']['a_moderator'] = $row['a_moderator'];

        // TODO this is buggy
    }
}

// no pg_close() here
?>
