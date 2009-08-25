<?php

// This handlers the receiving of answers to a question from 
// ../forms/lomake_answer.php

ob_start ();

// to be able to grap data from session
session_save_path("/tmp/");
session_start();


function check_user_status () {
    // TODO may be buggy
    if ( $_SESSION['login']['user_id'] == '' )
        return false;
    else
        return true;
}

function get_question_id_for_receive_question () {
    $pattern = '/question_id=([^#&]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str( $query, $params );
    $question_id = explode( "=", $query );      // this is an array

    return $question_id[0];
}



function set_answer ( $question_id ) {
    $answer_sanitized = pg_escape_string( $_POST['answer'] );   // to sanitize answer

    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to put answer and question_id to Answers -table
    $result = pg_query_params ( $dbconn,
        "INSERT INTO answers 
        (answer, question_id, user_id)
        VALUES ($1, $2, $3)",
            array( $answer_sanitized, 
            $question_id,
            $_SESSION['login']['user_id'] ) 
        );

    // to redirect the user
    if ( $result ) {
        header("Location: /codes/index.php?"
            . "answer_sent"
            . "&"
            . "question_id="
            . $question_id
        );
    } 
    else {
        header("Location: /codes/index.php?"
            . "answer_not_sent"
            . "&"
            . "question_id="
            . $question_id
        );
    }
}


// Let's fire!

if ( !(empty ( $_POST['answer'] ) ) )
{
    if ( check_user_status () )
        set_answer ( get_question_id_for_receive_question() );
}
else
    header( "Location: /codes/index.php" );

ob_flush ();

?>
