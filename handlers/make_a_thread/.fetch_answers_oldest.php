<?php
// To get answers for the question

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");


if ( $_GET['sort'] == 'newest' OR empty ( $_GET['sort'] ) )
{
    $result_answers = pg_prepare( $dbconn, "fetch_answers",
        "SELECT a.answer, u.username, a.was_sent_at_time, a.answer_id
        FROM answers a
        LEFT JOIN users u ON a.user_id = u.user_id
        WHERE question_id = $1
        ORDER BY a.was_sent_at_time DESC"
    );
}
if ( $_GET['sort'] == 'oldest' ) {
    $result_answers = pg_prepare( $dbconn, "fetch_answers",
            "SELECT a.answer, u.username, a.was_sent_at_time, a.answer_id
            FROM answers a
            LEFT JOIN users u ON a.user_id = u.user_id
            WHERE question_id = $1
            ORDER BY a.was_sent_at_time ASC"
        );
}

// to get answers when we can use GET
if ($_GET['question_id'] > 0 ) {
    $result_answers = pg_execute( $dbconn, "fetch_answers", array( $_GET['question_id'] ) );
}

// to get answers by HTTP_REFERER
if (empty( $_GET['question_id'] ) ) {
    $pattern = '/\?([^#]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str($query, $params);
    $question_id = explode( "=", $query );
    $result_answers = pg_execute( $dbconn, "fetch_answers", array( $question_id[1] ) );
}


// to print subheader for Answers/*{{{*/
$number_of_answers = pg_num_rows ( $result_answers);

if ( $number_of_answers == 1) {
    subheader( $number_of_answers 
    .  " Answer" );
}
if ( $number_of_answers > 1 ) {
    subheader( $number_of_answers 
    .  " Answers" );
}

// to have the underline
if ( $number_of_answers == 0 ) {
    subheader( "Be the first answerer" );
}
/*}}}*/

    echo ("</div>");        // to end answers -block


echo ("<div class='answers'>");         // to start answers -block
// to compile bodys of the answers
while ( $answer = pg_fetch_array( $result_answers) ) {

    $username = $answer['username'];
    // Grab the was_sent_at_time for the question from the second array
    $was_sent_at_time_unformatted = $answer['was_sent_at_time'];
    $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
    $was_sent_at_time = $was_sent_at_time_array[0];

    echo (
    . $answer['answer']
    ); 
    create_user_info_box_question( $user_id, $username, $was_sent_at_time, "answered" )
}

?>
