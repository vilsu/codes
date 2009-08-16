<?php 

// We need output buffers to prevent headers from leaving before Sessions are 
// ended.
ob_start();

echo "POST: " . session_id();
session_id();
var_dump($_POST);
echo "COOKIE";
var_dump($_COOKIE);
echo "SESION";
var_dump($_SESSION);
echo "GET";
var_dump($_GET);

require './handlers/login_by_session.php';
print_r($_SESSION);

echo ("HTTP_REFERER\n"
    . $_SERVER['HTTP_REFERER']
    );


$pattern = '/\?([^#]*)/';
$subject = $_SERVER['HTTP_REFERER'];
$query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
parse_str($query, $params);

echo "----";
print_r( $params );
echo "----";
var_dump( $params );

//$question_id = explode( "=", $query );           // to get the parameter
//echo "This is the output: " . $question_id[1];



include './official_content/html_head_body.php';
include './PATHs.php';
?>

<div class="container"><!--/*{{{*/-->
    <div class="header">
        <div id="userbar">
            <?php
            require './views/links_at_userbar.php';
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
    <?php

        // Dynamic content: questions' titles
            // IF empty($_GET)
        require './handlers/searches/handle_questions_by_time.php';

        if( array_key_exists('question_id', $_GET ) ) {
            require './handlers/fetch_a_thread.php';
            require './handlers/fetch_answers.php';
            require './forms/lomake_answer.php';
        }

        // Notices
        require './views/registration_at_userbar_notice.php';
        require './views/login_at_userbar_notice.php';
        require './views/logout_at_userbar_notice.php';

        require 'views/answer_question.php';
        require 'views/ask_question.php';

        require 'views/successful_notice.php';
        require 'views/unsuccessful_notice.php';

        // Static content
        require './views/about.php';
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
