<?php

/** 
 * @file    receive_answers.php
 * @brief   Ota vastaus kysymykseen
 */

include ("getters_at_question.php");

// This handlers the receiving of answers to a question from 
// ../forms/lomake_answer.php

ob_start ();

// to be able to grap data from session
session_save_path("/tmp/");
session_start();

/** Tarkasta k\"{a}ytt\"{a}n sis\"{a}\"{a}nkirjautumistila
 * @return boolean
 */
function check_user_status () {
    // TODO may be buggy
    if ( $_SESSION['login']['user_id'] == '' )
        return false;
    else
        return true;
}

/** Aseta vastaus
 * @param integer $question_id
 * @param string $answer_sanitized
 */
function set_answer ( $question_id ) {
    $answer_sanitized = pg_escape_string( $_POST['answer'] );   // to sanitize answer

    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to put answer and question_id to Answers -table
    $result = pg_query_params ( $dbconn,
        'INSERT INTO answers 
        (answer, question_id, user_id)
        VALUES ($1, $2, $3)',
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

/** Tarkasta, ettei vastaus ole tyh\"{a} ja salli vain kirjautunet 
 * k\"{a}ytt\"{a}j\"{a}
 */
if ( !(empty ( $_POST['answer'] ) ) )
{
    if ( check_user_status () )
        set_answer ( get_questionID_at_question() );
}
else
    header( "Location: /codes/index.php" );

ob_flush ();

?>
