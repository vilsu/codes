<?php

/**
 * @brief   Tee moderaattori
 * @file    make_moderator.php
 */

/**
 * Tee moderaattori
 */
function make_moderator () {

	$result = pg_prepare ( $dbconn, "make_moderator", 
	    'UPDATE users 
	    SET a_moderator = 1
	    WHERE email = $1',
	    array ( $_POST['login']['email'] ) 
	);
}

make_moderator ();

?>
