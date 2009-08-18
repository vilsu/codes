<?php

// This fetches the question and its answers to a thread
// according to the $_GET['question_id'].

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to start beginning of the question/*{{{*/
$result = pg_prepare( $dbconn, "query_fetch", 
    "SELECT title, body
    FROM questions
    WHERE question_id = $1;"
);

if ($_GET['question_id'] > 0 ) {
    $result = pg_execute( $dbconn, "query_fetch", array( $_GET['question_id'] ) );
}
if (empty( $_GET['question_id'] ) ) {
    $pattern = '/\?([^#]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str($query, $params);
    $question_id = explode( "=", $query );
    $result = pg_execute( $dbconn, "query_fetch", array( $question_id[1] ) );
}


// To compile title and body of the question
while ( $question = pg_fetch_array( $result ) ) {
    // To print the header of the question
    echo ("<div id='mainheader'>"
        // TODO activate this when other are seen in the homepage
//        . "<a href='?'"
//        . "question_id="
//        . $_GET['question_id']   // buggy
//        . "'>"
        . $question['title']
        . "</a>"
        . "</div>"
    );
    echo ("<div class='question_body'>"
        . $question['body']
        . "</div>"
    );
}/*}}}*/

?>
