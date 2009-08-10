<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// Tata lomaketta ei laiteta includa kaikkiin fileihin
// se suoritetaan vain, kun kayttaa *lomake_login.php*

// tarkistetaan datan oikeus
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // palataan paasivulle
    header("Location: /codes/index.php?"
        . "unsuccessful_login" 
        . "&"
        . "login"
    );
    die("Wrong email-address");
}


include 'handle_login_status.php';

// haetaan original password db:sta 
$result = pg_prepare($dbconn, "query3", 'SELECT passhash_md5 
    FROM users WHERE email = $1;');
$result = pg_execute($dbconn, "query3", array($_POST['email']));

// to read the password from the result
while ($row = pg_fetch_row($result)) {
    $password_original = $row[0];
}


if ($password_original == md5($_POST['password'])) {
    $result = ("Location: /codes/index.php?ask_question"
            . "&"
            . "successful_login"
            . "&"                  // this is not HTML: we need no escapes
            . "email="
            . $_POST['email']
            . "&"
            . "passhash_md5="
            . md5($_POST['password']) );

    header($result);    
    include '/codes/handlers/handle_login_status.php';
    die("oikea salasana");

} else {
    header("Location: /codes/index.php?unsuccessful_login");
}


//pg_close($dbconn);
?>
