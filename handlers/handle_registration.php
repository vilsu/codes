<?php

// not a duplicate
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to see the login status
include 'handle_login_status.php';
if($logged_in) {
    header("Location: /codes/index.php");
    die("You are logged in");
}

// haetaan muuttujien arvot lomakkeelta
// We do not save passwords in plain text
$username = $_POST['username'];
$passhash_md5 = md5($_POST['password']);
$email = $_POST['email'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     // palataan paasivulle
    header("Location: /codes/index.php");
    die("Wrong email-address");
}

$result = pg_prepare($dbconn, "query1", 'INSERT INTO users (username, email, passhash_md5)
    VALUES ($1, $2, $3);');
$result = pg_execute($dbconn, "query1", array($username, $email, $passhash_md5));
if(!$result) {
    echo "An error occurred - Hhhhhhhhhhh!\n";
    exit;
}

// palataan paasivulle
header("Location: /codes/index.php");
die("Successful registration");

pg_close($dbconn);
?>
