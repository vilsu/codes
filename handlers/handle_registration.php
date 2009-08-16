<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

session_save_path("/tmp/");
session_start();


// INDEPENDENT VARIABLES
$username = $_POST['login']['username'];
$passhash_md5 = md5($_POST['password']);
$email = $_POST['login']['email'];


// DATA PROCESSING

// Limitations/*{{{*/

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
     // palataan paasivulle

    $result = ("Location: /codes/index.php?"
                . "registration"
                . "&"
                . "registration_wrong_email"
                );
    header($result);
    die("Wrong email-address.");
}
/*}}}*/

// we do not allow one email address have many accounts
$result = pg_prepare($dbconn, "query11", 'SELECT count(email) FROM users
    WHERE email = $1;');
$result = pg_execute($dbconn, "query11", array($email));
// luetaan data
while ($row = pg_fetch_row($result)) {
    $number_of_emails = $row[0];
}



if($number_of_emails > 0) {
    header("Location: /codes/index.php?"
        . "registration"
        . "&"
        . "2email"
    );
} else {
    $_SESSION['login']['passhash_md5'] = $passhash_md5;
    $_SESSION['login']['email'] = $email;
    $_SESSION['login']['logged_in'] = true;

    // Save to db

    $result = pg_prepare($dbconn, "query1", 'INSERT INTO users (username, email, passhash_md5)
        VALUES ($1, $2, $3);');
    $result = pg_execute($dbconn, "query1", array($username, $email, $passhash_md5));
    if(!$result) {
        echo "An error occurred - Hhhhhhhhhhh!\n";
        exit;
    } 

    $result = ("Location: /codes/index.php?"
            . "successful_registration"
            );
    // palataan paasivulle

    header($result);
}

// NO session_write_close HERE!
//pg_close($dbconn);
?>
