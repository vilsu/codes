<?php
// do not bind this to anything
// only for reference

$result = pg_prepare ( $dbconn, "make_moderator", 
    "UPDATE users 
    SET a_moderator = 1
    WHERE email = $1;"
);

$result = pg_execute ( $dbconn, "make_moderator", array ( $_POST['login']['email'] ) );

?>
