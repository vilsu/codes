<?php
// A QUESTION SELECTED BY USER 
// to generate the answers for the given question 
if (array_key_exists('question_id', $_REQUEST)) {

    // to get the title and body of the question
    $result = pg_prepare($dbconn, "query9", "SELECT title, body  
        FROM questions WHERE question_id = $1;");
    // TODO I am not sure if the syntax is correct for parametr inside $_REQUEST
    $result_title_body = pg_execute($dbconn, "query9", array($_REQUEST['question_id']));

    // to get answers for the question
    $result = pg_prepare($dbconn, "query10", "SELECT answer FROM answers
        WHERE questions_question_id = $1;");
    $result_answer = pg_execute($dbconn, "query10", array($_REQUEST['question_id']));
}
?>
