<?php

/**
 * @brief   Tarkasta Moderaattoritila
 * @file    moderator_check.php
 */

session_save_path("/tmp/");
session_start();

function get_moderator_status () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    if(!$dbconn) {
        echo "An error occurred - Hhhh\n";
        exit;
    }
    $result = pg_query_params ( $dbconn, 
            'SELECT a_moderator 
            FROM users
            WHERE email = $1',
            array( $_SESSION['login']['email'] ) 
        );
    $rows = pg_fetch_all ( $result );

    return $rows;
}


// test data with type-safe identity comparator
if ( $_SESSION['login']['logged_in'] == 1 ) {
    $rows = get_moderator_status ();
    // to compile the data
    foreach ( $rows as $row ) {
        $_SESSION['login']['a_moderator'] = (int) $row['a_moderator'];
    }
}

?>
