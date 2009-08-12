<?php

    // Do NOT use absolute PATHs when including a file
    set_include_path(':/var/www/codes/handlers/:' 
                . '/var/www/codes/lomakkeet/:'
                . '/var/www/codes/official_content/:'
                . '/var/www/codes/views/'
    );

    session_start();

    function session_defaults() {
        $_SESSION['logged_in'] = false;
        $_SESSION['SID'] = 0;
        $_SESSION['username'] = '';
    }

    if (!isset($_SESSION['SID'])) {
        session_defaults();
    }

    // otetaan yhteys kantaan
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    if(!$dbconn) {
        echo "An error occurred - Hhhh\n";
        exit;
    }

    // to use SESSIONS
    if (isset($_REQUEST['email'])) {
        // check the login status
        include 'handle_login_status.php';
    }
?>
