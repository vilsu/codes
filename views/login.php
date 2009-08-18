<?php
// change the layout by adding question form by getting data

subheader( "Login or Register", false );
echo ("<div id='registration_login'>");
include './forms/lomake_login.php';
echo (" <p> or </p>");
include './forms/lomake_registration.php';
echo ("</div>");

?>
