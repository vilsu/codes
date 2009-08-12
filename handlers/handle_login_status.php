<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

$result = pg_prepare($dbconn, "query22", "SELECT passhash_md5 FROM users
        WHERE email=$1;");

// tarkistetaan, etta salasana on oikein
$passhash_md5 = pg_execute($dbconn, "query22", array($_REQUEST['email']));

session_start();
$_SESSION['logged_in'] = false;
if ($passhash_md5 == $_REQUEST['passhash_md5']) {
    $_SESSION['logged_in'] = true;
}

// no pg_close() here
?>
