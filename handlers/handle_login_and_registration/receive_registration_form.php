<?php

ob_start();
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

    if ( $number_of_emails > 0 ) {
        echo "Your email has already an account";
        return false;
    }
    else if ( filter_var ( $email, FILTER_VALIDATE_EMAIL ) ) {
        echo ("email is in line with POSIX");
        return true;
    }
    // does not go through filter
    else 
    {
        echo ("email has illegal characters");
        return false; 
    }
}

function validate_password ( $password )
{
    if ( mb_strlen ( $password ) < 6)
        return false;
    else
    {
        echo ("Strong password");
        return true;
    }
}

function validate_username ( $username )
{
//    $allowed_username = preg_match ( '/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/', $username );

    if ( !( ctype_alnum ( $username ) ) ) 
    {
        echo ("Your password contains illegal characters");
        return false;
    }
    else if ( empty ( $username ) ) {
        echo ("Your password is empty");
        return false;
    }
    else 
    {
        echo ("Good username ");
        return true;
    }
}

function validate ( $email, $password, $username )
{
    if ( !validate_email ( $email ) ) 
    {
        echo "email wrong";
        return false;
    }
    else if ( !validate_password ( $password ) )
    {
        echo "password wrong";
        return false;
    }
    else if ( !validate_username ( $username ) )
    {
        echo "username wrong";
        return false;
    }
    else
    {
        echo "correct validation";
        return true;
    }
}

function add_new_user ( $email, $passhash_md5, $username )
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

function get_question_id ( ) {
    $pattern = '/question_id=([^#&]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    // extract query from URL
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
    parse_str($query, $params);
    $question_id = explode ( '=', $query );
}

function direct_right ()
{
    if ( array_key_exists ( 'question_id', $_GET ) ) {
        // To redirect the user back to the question where he logged in
    
        $question_id = get_question_id ();
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

function direct_wrong ( ) { 
    header ( "Location: /codes/index.php?"
        . "unsuccessful_registration"
        . "&login"
    );
}

// Let's rock!
$username = $_POST['login']['username'];
$password = $_POST['login']['password'];
$passhash_md5 = md5 ( $password );
$email = $_POST['login']['email'];

if ( validate( $email, $password, $username) ) {
    echo ("validaatio toimii"); 
    add_new_user ( $email, $passhash_md5, $username ); 

    $_SESSION['login']['passhash_md5'] = $passhash_md5;
    $_SESSION['login']['email'] = $email;
    $_SESSION['login']['logged_in'] = 1;
    $_SESSION['login']['user_id'] = get_user_id ( $email );
    $_SESSION['login']['username'] = $username;

    direct_right();
}
else
{
    direct_wrong( );
}

ob_end_flush();

?>
