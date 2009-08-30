<?php 

/* 
 * This file tells you the basic HTML structure of the site and
 * the conditions when a given action happens. 
 */

// Functions
include ("./handlers/header_functions.php");

// user info box for lists of questions and for answers
include ("./handlers/user_info_functions.php");

// We need output buffers to prevent headers from leaving before Sessions are 
// ended.
ob_start();


require ( './handlers/handle_login_and_registration/login_by_session.php' );
require ( './handlers/handle_login_and_registration/moderator_check.php' );

include ( './html_head_body.php' );

// debugging code must be inside HTML
include( "debugging_code.php" );

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
                    Forum
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

/** Luo huomautukset
 */
function create_notices () {
    // Notices about successes and failures in the site
    require ('views/successful_notice.php');
    require ('views/unsuccessful_notice.php');

    // Recent questions at homepage
    if ( array_key_exists('successful_login', $_GET ) ) {
        require ( './handlers/searches/handle_questions_by_time.php' );
    }
    // Recent questions at homepage
    else if ( array_key_exists('successful_registration', $_GET ) ) {
        require ( './handlers/searches/handle_questions_by_time.php' );
    }
}

/** Luo perusn\"{a}kymym\"{a}
 */
function create_view () {
    // search functions
    include ("./handlers/make_a_list_of_questions/make_a_list_of_questions_functions.php");
    include ("./handlers/make_a_list_of_questions/organize_a_list_of_questions_functions.php");

    // to sort the list of questions at the homepage
    if( empty( $_GET )
        OR $_GET['tab'] == 'newest'
        OR $_GET['tab'] == 'oldest' ) {
            require ( './handlers/searches/handle_questions_by_time.php' );
        }
    // tag search
    else if( $_GET['tab_tag'] == 'newest'
        OR $_GET['tab_tag'] == 'oldest' ) {
            require ( './handlers/searches/handle_questions_by_tag.php' );
        }
    // Tagged questions
    else if( array_key_exists( 'tag', $_GET ) ) {
        require ('./handlers/searches/handle_questions_by_tag.php');
    }
    // username search
    else if( $_GET['tab_user'] == 'newest'
        OR $_GET['tab_user'] == 'oldest' ) {
            require ( './handlers/searches/handle_questions_by_username.php' );
        }
    // Questions of a username
    else if( array_key_exists( 'username', $_GET ) ) {
        require ('./handlers/searches/handle_questions_by_username.php');
    }
    else if( array_key_exists( 'search', $_GET ) ) {
        require ('./handlers/searches/search_body.php');
    }
}


/** Ota kysymystunniste
 * @param string $pattern
 * @param string $subject
 * @param string $query
 * @param integer $question_id
 * @return integer
 */
function get_question_id_home ( ) {
    if ( !empty ( $_GET['question_id'] ) )
        return $_GET['question_id'];
    else if ( !empty ( $_SERVER['HTTP_REFERER'] ) ) 
    {
        // To redirect the user back to the question where he logged in
        $pattern = '/question_id=([^#&]*)/';
        $subject = $_SERVER['HTTP_REFERER'];
        // extract query from URL
        $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
        parse_str ( $query, $params );
        $question_id = explode ( '=', $query );
        $question_id = $question_id[0];

        return $question_id;
    }
}


/** Luo sis\"{a}\"{a}nkirjautumisn\"{a}kym\"{a}
 */
function create_logged_in_view () {
    // Login and Logout
    if (isset($_GET['login'])) {
        // to have login at userbar
        require './views/login.php';
    }
    // LOGOUT at USERBAR
    else if (isset($_GET['logout'])) {
        echo "Successful logout";
        session_destroy();
        header("Location: index.php");
    } 
}


/** Ota sis\"{a}\"{a}nkirjautumistila
 * @return boolean
 */
function get_login_status () {
    if ( isset( $_SESSION['login']['logged_in'] ) )
        return true;
    else
        return false;
}


/** Luo kysy -n\"{a}kym\"{a}
 */
function create_ask_question_view () {
    // Ask question -view
    if ( isset( $_GET['ask_question'] ) ) {
        // change the layout by adding question form by getting data from 
        include './forms/lomake_ask_question.php';

        // LOGIN at the bottom of Ask_question
        if ( !get_login_status () )
            include( "./views/login.php" );
    }
}

/** Luo yleist\"{a} -n\"{a}kym\"{a}
 */
function create_about_view () {
    if ( array_key_exists ( 'about', $_GET ) )
        require './views/about.php';
}


/** Luo HTML vastauss\"{a}ili\"{o}
 * @param integer $question_id
 */
function create_answers_box ( $question_id ) {
    echo ("<table><tr><td>");
    // to sort the answers of the given question
    require ("./handlers/make_a_thread/fetch_answers.php");

    require ('./forms/lomake_answer.php');

    // LOGIN at the bottom
    if ( !get_login_status () )
        include( "./views/login.php" );
    echo ("</div>");    // to end container two

    echo ("</td><td><div class='right_bar'>");
    create_global_tag_count_box_for_a_question ( $question_id );
    echo ("</div></td></tr></table>");
}


/** Luo n\"{a}kym\"{a} kysymyksess\"{a}
 * @param integer $question_id
 */
function create_in_question_view ( $question_id ) {
    // Content with headers
    // Question selected by the user
    if( array_key_exists('question_id', $_GET ) ) 
    {
        if ( array_key_exists ( 'edit_question', $_GET ) ) 
            require ('./handlers/edit_question.php');
        else 
        {
            require ('./handlers/make_a_thread/fetch_a_question.php');
            create_answers_box ( $question_id );
        }
    }
}




/** Luo n\"{a}kym\"{a}t ilman otsikoita
 * @param integer $question_id
 */
function create_content_without_headings ( $question_id ) {
    // inside a question functions
    include ("./handlers/make_a_thread/thread_functions.php");
    create_notices ();
    create_logged_in_view ();
    create_ask_question_view ();
    create_about_view ();

    create_in_question_view ( $question_id );
}



// Let's fire!

/** Luo p\"{a}\"{a}n\"{a}kym\"{a} otetulle kysymystunnisteelle ja luo
 * sis\"{a}lt\"{o}, jolla ei ole otsikoita
 * @param integer $question_id
 */
$question_id = get_question_id_home ();
create_view ();
create_content_without_headings ( $question_id );

?>
    </div>
</div>
<!--/*}}}*/-->
</body>
</html>

<?php
// http://www.php.net/manual/en/function.session-regenerate-id.php#85433
ob_end_flush();

?>
