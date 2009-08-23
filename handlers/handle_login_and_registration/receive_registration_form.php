<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

session_save_path("/tmp/");
session_start();

// Tata lomaketta ei laiteta includa kaikkiin fileihin
// se suoritetaan vain, kun kayttaa *lomake_registration.php*

// DATA COLLECTION

// Independent variables
$username = $_POST['login']['username'];
$passhash_md5 = md5($_POST['login']['password']);
$email = $_POST['login']['email'];


function amount_of_emails ( $email ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // we do not allow one email address have many accounts
    $result = pg_query_params($dbconn,
        'SELECT count(email) 
        FROM users
        WHERE email = $1', 
        array($email)
    );
    // luetaan data
    while ($row = pg_fetch_row($result)) {
        $number_of_emails = $row[0];
    }
    return $number_of_emails;
}


// TODO this is buggy
// http://fi2.php.net/manual/en/function.empty.php
if ( empty ( $username ) ) {
    header ("Location: /codes/index.php?"
        . "no_username"
        . "&unsuccessful_registration" );
}
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // back to registration
    header ("Location: /codes/index.php?"
        . "login"
        . "&"
        . "registration_wrong_email"
    );
}
else if ( mb_strlen ( $_POST['login']['password'] ) < 6) {
    // back to registration
    header ("Location: /codes/index.php?"
        . "login"
        . "&"
        . "too_short_password"
    );
}
else if ( amount_of_emails( $email ) > 0) {
    header("Location: /codes/index.php?"
        . "registration"
        . "&"
        . "2email"
    );
} else if ( amount_of_emails( $email ) == 0) {
    // Save to db
    $result = pg_query_params($dbconn, 
        'INSERT INTO users 
        (username, email, passhash_md5)
        VALUES ($1, $2, $3)',
            array($username, $email, $passhash_md5)
        );
    if(!$result) {
        echo "An error occurred - Hhhhhhhhhhh!\n";
        exit;
    } 
    else if ( $result ) {
        // grap the user_id
        $result = pg_query_params( $dbconn,
            "SELECT user_id
            FROM users
            WHERE email = $1",
            array( $email )  
        );
        // to compile the data
        while ( $row = pg_fetch_array( $result ) ) {
            $user_id = (int) $row['user_id'];
        }

        $_SESSION['login']['passhash_md5'] = $passhash_md5;
        $_SESSION['login']['email'] = $email;
        $_SESSION['login']['logged_in'] = 1;
        $_SESSION['login']['user_id'] = $user_id;
        $_SESSION['login']['username'] = $username;


        // To redirect the user back to the question where he logged in
        $pattern = '/\?([^#&]*)/';
        $subject = $_SERVER['HTTP_REFERER'];
        // extract query from URL
        $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
        parse_str($query, $params);
        $question_id = explode ( '=', $query );
    }
    else if ( array_key_exists ( 'question_id', $_GET ) ) {
        header ( "Location: /codes/index.php?question_id=" 
            . $question_id 
            . "&successful_login" );
    }
    else if ( $_GET['login'] ) 
    {  
        header("Location: /codes/index.php?"
            . "successful_login"
        );
    }
    else 
    {
        header ("Location: /codes/index.php");
    }
} 
else if ( array_key_exists ( 'question_id', $_GET ) ) {
    header("Location: /codes/index.php?"
        . "unsuccessful_login"
        . "&"
        . "question_id="
        . $question_id
    );
}
else 
{
    // palataan paasivulle
    header ( "Location: /codes/index.php?"
        . "unsuccessful_registration"
    );
}

// NO session_write_close HERE!
//pg_close($dbconn);
?>
