<?php

// This handlers the receiving of answers to a question from 
// ../forms/lomake_answer.php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to be able to grap data from session
session_save_path("/tmp/");
session_start();

if ( !$_SESSION['login']['user_id'] == '' ) {
    $_SESSION['login']['email'];
    header( "Location: http://localhost/codes/index.php" );
}

// to put answer and question_id to Answers -table
$result = pg_prepare($dbconn, "query2", "INSERT INTO answers 
                            (answer, question_id, user_id)
                            VALUES ($1, $2, $3);"
                        );

// to get the question_id
$pattern = '/question_id=([^#&]*)/';
$subject = $_SERVER['HTTP_REFERER'];
$query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
parse_str( $query, $params );
$question_id = explode( "=", $query );

$result = pg_execute( $dbconn, "query2", 
    array( $_POST['answer'], 
    $question_id[0],
    $_SESSION['login']['user_id']
     ) );
    // TODO bugaa titlen kanssa URL:issa
    // alkuperainen $question_id[1]

if ( $result ) {
    header("Location: /codes/index.php?"
        . "answer_sent"
        . "&"
        . "question_id="
        . $question_id[0]
    );
} else {
    header("Location: /codes/index.php?"
        . "answer_not_sent"
        . "&"
        . "question_id="
        . $question_id[0]
    );
}

//pg_close($dbconn);

?>
