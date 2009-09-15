<?php

/**
 * @brief   Tee sisaankirjautuminen
 * @file    login.php
 */


// change the layout by adding question form by getting data

echo ("<div id='login_box'>");
    subheader( "Login or Register", false );
    echo ("<div id='registration_login'>");
    include ('./forms/lomake_login.php');
        echo (" <p> or </p>");
    include ('./forms/lomake_registration.php');
    echo ("</div>");
echo ("</div>");

?>
