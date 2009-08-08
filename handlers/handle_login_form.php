<?php

// Tata lomaketta ei laiteta includa kaikkiin fileihin
// se suoritetaan vain, kun kayttaa *lomake_login.php*

// tarkistetaan datan oikeus
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // palataan paasivulle
    header("Location: ../index.php");
    die("Wrong email-address");
}

// haetaan muuttujien arvot db:sta ja lomakkeelta
$result = pg_prepare($dbconn, "query2", 'SELECT email, passhash_md5
    FROM users WHERE email = $1
    AND passhash_md5 = $2;');
$result = pg_execute($dbconn, "query2", array($_POST['email'], $_POST['password']));
if(!$result) {
    echo "An error occurred - hhhhhh!\n";
    exit;
}



 // COOKIE setting /*{{{*/

 /* $cookie looks like this:
   variable
        passhash_md5 = "password-in-md5"
        email = "email@gmail.com"
   before md5:
        "email"
        "passhash_md5"
   after md5:
        "email,a08d367f31feb0eb6fb51123b4cd3cb7"
 */

// haetaan muuttujien arvot lomakkeelta
// ja tehdaan login_cookie
$login_cookie = $_POST['email'] . "," . md5($_POST['password']);

// haetaan original password db:sta 
$result = pg_prepare($dbconn, "query3", 'SELECT passhash_md5 
    FROM users WHERE email = $1;');
$result = pg_execute($dbconn, "query3", array($_POST['email']));

// to read the password from the result
while ($row = pg_fetch_row($result)) {
    $password_original = $row[0];
}

// tehdaan original login cookie
$login_cookie_original = md5($password_original);


// Check for the Cookie
if (isset($_COOKIE['login']) )
{

    // Check if the Login Form is the same as the cookie
    if ( $login_cookie_original == $login_cookie )
    {
        header("Location: ../index.php");
        die("logged in");
    }
    header("Location: ../index.php");
    die("wrong email/password");
}

// If no cookie, we do NOT try to log them in
else
{
    header("Location: ../index.php");
    die("wrong email/password");
}
/*}}}*/

pg_close($dbconn);
?>
