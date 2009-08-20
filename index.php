<?php 

/* 
 * This file tells you the basic HTML structure of the site and
 * the conditions when a given action happens. 
 */

// Functions
include ("./handlers/header_functions.php");

// inside a question functions
include ("./handlers/make_a_thread/thread_functions.php");

// search functions
include ("./handlers/searches/make_a_list_of_questions_functions.php");
include ("./handlers/make_a_list_of_questions/organize_a_list_of_questions_functions.php");

// We need output buffers to prevent headers from leaving before Sessions are 
// ended.
ob_start();


require ( './handlers/handle_login_and_registration/login_by_session.php' );

$pattern = '/\?([^#&]*)/';
$subject = $_SERVER['HTTP_REFERER'];
$query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
parse_str($query, $params);
// TODO you can simplify this by calling only $params: see php -docs


include ( './official_content/html_head_body.php' );

// debugging code must be inside HTML
// include( "debugging_code.php" );

include( './PATHs.php' );
?>

<div class="container"><!--/*{{{*/-->
    <div class="header">
        <div id="userbar">
            <?php
            require './views/links_at_userbar.php';
            require './forms/lomake_search.php';
            ?>
        </div>

        <div id="logo">
            <h1 id="logo">
                <a href="index.php">
                    Keskustelusivu
                </a>
            </h1>
        </div>
    </div>

    <div id="navbar">
        <div class='ask_question'>
            <?php
            require './views/ask_question_link.php';
            ?> 
        </div>
    </div>

    <div id="mainbar">
        <div class="container_two">
        <?php

        
        // Notices about successes and failures in the site
        require 'views/successful_notice.php';
        require 'views/unsuccessful_notice.php';

        // Recent questions at homepage
        if ( array_key_exists('successful_login', $_REQUEST) ) {
            require ( './handlers/searches/handle_questions_by_time.php' );
        }
        // Recent questions at homepage
        if ( array_key_exists('successful_registration', $_REQUEST) ) {
            require ( './handlers/searches/handle_questions_by_time.php' );
        }

        // to sort answers
        if( empty( $_GET )
            OR $_GET['tab'] == 'newest'
            OR $_GET['tab'] == 'oldest' ) {
            require ( './handlers/searches/handle_questions_by_time.php' );
        }

        // Content with headers/*{{{*/
        // Question selected by the user
        if( array_key_exists('question_id', $_GET ) ) {
            require ('./handlers/fetch_a_thread.php');

            echo ("<div class='answers'>");         // to start answers -block
                require ("./handlers/fetch_answers.php");
            echo ("</div>");                        // to end answers -block

            require ('./forms/lomake_answer.php');

            // LOGIN at the bottom
            if (!isset($_SESSION['login']['logged_in'])) {
                echo ("<div id='login_box'>");
                    // change the layout by adding question form by getting data
                    include( "./views/login.php" );
                echo ("</div>");
            }
        }
/*}}}*/
        // Tagged questions
        if( array_key_exists( 'tag', $_GET ) ) {
            require ('./handlers/searches/handle_questions_by_tag.php');
        }

        // Questions of a username
        if( array_key_exists( 'username', $_GET ) ) {
            require ('./handlers/searches/handle_questions_by_username.php');
        }


        // Static content
        require './views/about.php';

    // Content without headers
        
        // Login and Logout
        if (isset($_GET['login'])) {
            // to have login at userbar
            require './views/login.php';
        }
        require './views/logout_at_userbar_notice.php';

        // Ask question -view
        if ( isset( $_GET['ask_question'] ) ) {
            // change the layout by adding question form by getting data from 
            include './forms/lomake_ask_question.php';

            // LOGIN at the bottom of Ask_question
            if ( !isset( $_SESSION['login']['logged_in'] ) ) {
                // change the layout by adding question form by getting data
                include( "./views/login.php" );
            }
        }
        ?>
        </div>
    </div>
</div>
<!--/*}}}*/-->
</body>
</html>

<?php
// http://www.php.net/manual/en/function.session-regenerate-id.php#85433
ob_end_flush();
?>
