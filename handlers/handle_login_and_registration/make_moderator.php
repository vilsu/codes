<?php

/**
 * @brief   Tee moderaattori
 * @file    make_moderator.php
 */

// do not bind this to anything
// only for reference

/** Tee moderaattori
 */
$result = pg_prepare ( $dbconn, "make_moderator", 
    'UPDATE users 
    SET a_moderator = 1
    WHERE email = $1',
    array ( $_POST['login']['email'] ) 
);

?>
