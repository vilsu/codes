<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

session_save_path("/tmp/");
session_start();

// Tata lomaketta ei laiteta includa kaikkiin fileihin
// se suoritetaan vain, kun kayttaa *lomake_login.php*

// INDEPENDENT VARIABLES
$passhash_md5 = md5($_POST['login']['password']);
$email = $_POST['login']['email'];

// DATA PROCESSING

// Limitations/*{{{*/

// tarkistetaan datan oikeus
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // palataan paasivulle
    header("Location: /codes/index.php?"
        . "login"
        . "&"
        . "unsuccessful_login" 
    );
    die("Wrong email-address");
}
/*}}}*/

// haetaan original password db:sta 
$result = pg_prepare($dbconn, "query3", 
    'SELECT passhash_md5 
    FROM users WHERE email = $1;
    ');
$result = pg_execute($dbconn, "query3", array($email));

// to read the password from the result
while ($row = pg_fetch_row($result)) {
    $passhash_md5_original = $row[0];
}


if ($passhash_md5_original==md5($_POST['login']['password'])) {
    $result = ("Location: /codes/index.php?ask_question"
            . "&"
            . "successful_login"
            );

    $_SESSION['login']['email'] = $_POST['login']['email'];
    $_SESSION['login']['passhash_md5'] = md5($_POST['login']['password']);
    $_SESSION['login']['logged_in'] = true;

    header($result);    
    die("oikea salasana");

} else {
    header("Location: /codes/index.php?"
        . "unsuccessful_login"
        . "&"
        . "login"
    );
}

//pg_close($dbconn);
?>
