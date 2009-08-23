<?php

session_save_path("/tmp/");
session_start();

// for *lomake_registration.php*

function validate_email ( $email ) 
{
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $result = pg_query_params($dbconn,
        "SELECT count(email) 
        FROM users
        WHERE email = $1", 
        array( $email )
    );
    while ( $row = pg_fetch_row ( $result ) ) {
        $number_of_emails = $row[0];
    }

    if ( $number_of_emails > 0 )
        return "2email";
    else if ( !(filter_var ( $email, FILTER_VALIDATE_EMAIL ) ) ) 
        return "registration_wrong_email";
    else 
        return 1; 
}

function validate_password ( $password )
{
    if ( mb_strlen ( $password ) < 6)
        return "too_short_password";
    else
        return 1;
}

function validate_username ( $username )
{
    if ( !( ctype_alnum ( $username ) ) ) 
        return "wrong_username";
    else 
        return 1;
}

function validate ( $email, $password, $username )
{
    if (  (validate_email ( $email ) )
        AND (validate_password ( $password ) )
        AND (validate_username ( $username ) ) )
        return 1;
    else 
    {
        $email_status = validate_email ( $email );
        $password_status = validate_password ( $password );
        $username_status = validate_username ( $username );
        return $email_status . $password_status . $username_status;
    }
}

function add_new_user ( $username, $email, $passhash_md5 )
{
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // Save to db
    $result = pg_query_params($dbconn, 
        "INSERT INTO users 
        (username, email, passhash_md5)
        VALUES ($1, $2, $3)",
            array($username, $email, $passhash_md5)
        );
}

function get_user_id ( $email ) 
{
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // grap the user_id
    $result = pg_query_params( $dbconn,
        "SELECT user_id
        FROM users
        WHERE email = $1",
        array( $email )  
    );
    while ( $row = pg_fetch_array( $result ) ) {
        $user_id = (int) $row['user_id'];
    }
    return $user_id;
}

function direct_right ()
{
    if ( array_key_exists ( 'question_id', $_GET ) ) {
        // To redirect the user back to the question where he logged in
        $pattern = '/\?([^#&]*)/';
        $subject = $_SERVER['HTTP_REFERER'];
        // extract query from URL
        $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
        parse_str($query, $params);
        $question_id = explode ( '=', $query );

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
        header ("Location: /codes/index.php");
}

function direct_wrong ( $message ) { 
    header ( "Location: /codes/index.php?"
        . unsuccessful_registration
        . "&message="
        . $message
    );
}

// Let's rock!
$username = $_POST['login']['username'];
$passhash_md5 = md5 ( $_POST['login']['password'] );
$password = $_POST['login']['password'];
$email = $_POST['login']['email'];

if ( validate( $username, $email, $password ) ) {
    add_new_user ( $username, $email, $passhash_md5 ); 

    $_SESSION['login']['passhash_md5'] = $passhash_md5;
    $_SESSION['login']['email'] = $email;
    $_SESSION['login']['logged_in'] = 1;
    $_SESSION['login']['user_id'] = get_user_id ( $email );
    $_SESSION['login']['username'] = $username;

    direct_right();
}
else
{
    direct_wrong( validate( $username, $email, $password ) );
}

?>
