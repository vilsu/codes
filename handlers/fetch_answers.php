<?php
// To get answers for the question

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

$result = pg_prepare( $dbconn, "query_fetch_answers",
    "SELECT answer
    FROM answers
    WHERE question_id = $1"
);

// to get answers when we can use GET
if ($_GET['question_id'] > 0 ) {
    $result = pg_execute( $dbconn, "query_fetch", array( $_GET['question_id'] ) );
}

// to get answers by HTTP_REFERER
if (empty( $_GET['question_id'] ) ) {
    $pattern = '/\?([^#]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str($query, $params);
    $question_id = explode( "=", $query );
    $result = pg_execute( $dbconn, "query_fetch_answers", array( $question_id[1] ) );
}


// to print subheader for Answers
subheader( "Answers" );

// to compile bodys of the answers
while ( $answer = pg_fetch_array( $result ) ) {
    echo ("<div class='answer'>"
    . $answer['answer']
    . "</div>"
    );
}

?>
