<?php

// This fetches the question and its answers to a thread
// according to the $_GET['question_id'].

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to get title and body of the question
$result = pg_prepare( $dbconn, "fetch_question", 
    "SELECT q.title, q.body, u.username, q.was_sent_at_time, u.user_id
    FROM questions q
    LEFT JOIN users u ON q.user_id = u.user_id
    WHERE question_id = $1;"
);

if ($_GET['question_id'] > 0 ) {
    $questions = pg_execute( $dbconn, "fetch_question", array( $_GET['question_id'] ) );
    $question_id = $_GET['question_id'];
}
if (empty( $_GET['question_id'] ) ) {
    $pattern = '/question_id=([^&#]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str($query, $params);
    $question_id = explode( "=", $query );
    $questions = pg_execute( $dbconn, "fetch_question", array( $question_id[1] ) );
}


// To compile title and body of the question
while ( $question = pg_fetch_array( $questions ) ) {
    echo ("<div id='top_header_main'>");
        // To print the header of the question
        create_question_title( $question['title'], $question_id );
    echo ("</div>");        // to end question_title block

    $username = $question['username'];

    $user_id = $question['user_id'];

    // print the body of the question
    echo ("<div class='question_body'>"
        . "<div id='question_content'>"
            . $question['body']
        . "</div>"
    );
    // Grab the was_sent_at_time for the question from the second array
    $was_sent_at_time_unformatted = $question['was_sent_at_time'];
    $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
    $was_sent_at_time = $was_sent_at_time_array[0];

    echo ("<div class='user_info_bottom_box'>");
    // print the user box for the question
    create_user_info_box_question( $user_id, $username, $was_sent_at_time, "asked" );
    create_moderator_box_for_a_question ( $question_id );
    echo ("</div>");

    // to end the body of the question
    echo ("</div>");
}

?>
