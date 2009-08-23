<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

session_save_path("/tmp/");
session_start();

// Tata lomaketta ei laiteta includa kaikkiin fileihin
// se suoritetaan vain, kun kayttaa *lomake_login.php*

// DATA COLLECTION

// Independent variables
$passhash_md5 = md5($_POST['login']['password']);
$email = $_POST['login']['email'];

/* Dependent variables
 *   $username
 *   $user_id
 */

// DATA PROCESSING

// grap the user_id
$result = pg_prepare( $dbconn, 'user_id_query',
    "SELECT user_id, username
    FROM users
    WHERE email = $1;"
);
$result = pg_execute( $dbconn, 'user_id_query', array( $email ) );
// to compile the data
while ( $row = pg_fetch_array( $result ) ) {
    $user_id = $row['user_id'];
    $username = $row['username'];
}

// Limitations/*{{{*/

// tarkistetaan datan oikeus
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // palataan paasivulle
    header("Location: /codes/index.php?"
        . "login"
        . "&"
        . "unsuccessful_login" 
    );
}
/*}}}*/

// haetaan original password db:sta 
$result = pg_prepare($dbconn, "query3", 
    'SELECT passhash_md5 
    FROM users WHERE email = $1;
    ');
$result = pg_execute($dbconn, "query3", array( $email ) );

// to read the password from the result
while ( $row = pg_fetch_row( $result ) ) {
    $passhash_md5_original = $row[0];
}


if ( $passhash_md5_original == $passhash_md5 ) {

    $_SESSION['login']['email'] = $email;
    $_SESSION['login']['passhash_md5'] = $passhash_md5;
    $_SESSION['login']['logged_in'] = 1; 
    $_SESSION['login']['username'] = $username;
    $_SESSION['login']['user_id'] = (int) $user_id;

    // To redirect the user back to the question where he logged in
    $pattern = '/\?([^#&]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    // extract query from URL
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
    parse_str($query, $params);
    $question_id = explode ( '=', $query );

    if ( !empty($question_id[0]) ) {
        header ( "Location: /codes/index.php"
              . "?successful_login"
              . "&"
              . "question_id="
              . $question_id[0]  
        );
    }
    header ( "Location: /codes/index.php?successful_login" );
}

// unsuccessful attempts
if ( $passhash_md5_original !== $passhash_md5 ) {
    if ( isset ( $_GET['question_id'] ) ) {
        header("Location: /codes/index.php?"
            . "unsuccessful_login"
            . "&"
            . "question_id="
            . $question_id[0]
        );
    } else {
        // put user back to the homepage 
        header("Location: /codes/index.php?"
                . "unsuccessful_login"
            );
    }
}
//pg_close($dbconn);
?>
