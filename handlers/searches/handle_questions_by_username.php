<?php

// to make mainheader without a link
mainheader( "Tagged Questions", false);

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to get titles and question_ids
// When tag is given by the user
$result_titles = pg_prepare( $dbconn, "username_search",
    "SELECT q.question_id, q.title, q.was_sent_at_time, u.username
        FROM questions q
        LEFT JOIN users u
            ON q.user_id=u.user_id
        WHERE u.username = $1
        ORDER BY q.was_sent_at_time
        DESC LIMIT 50;"
);
$result_titles = pg_execute( $dbconn, "username_search", 
    array( strip_tags( $_GET['username'] ) )
);
//TODO with strip_tags

// TAGS
$result_tags = pg_prepare( $dbconn, "username_query_search", 
    "SELECT t.question_id, t.tag
    FROM tags t
    WHERE t.question_id IN
    (
        SELECT q.question_id
        FROM questions q
        WHERE q.user_id IN
            (
                SELECT u.user_id
                FROM users u
                WHERE u.username=$1
            )
    )
    ORDER BY t.question_id;"
);
$result_tags = pg_execute( $dbconn, "username_query_search", 
    array( $_GET['username'] )
);

// First compile the Data

// Compile the data
// tags
while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
    // Add the Tag to an array of tags for that question
    $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];


}

if ( count ( $end_array ) == 0 ) {
    header( "Location: /codes/index.php?"
        . "no_question_found"
    );
}


// Titles
while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
    $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];

    $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
    $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
}


// $title should be the actual string, not an array
// $tags should be single, non-multidimensional array containing tag names

// Go through each question
foreach( $end_array as $tags_and_Qid['question_id'] => $titles_and_Qid['title'] )
{
    // Grab the title for the first array
    $title = $titles [ $tags_and_Qid['question_id'] ] ['title'];

    // Grab the tags for the question from the second array
    $tags = $end_array [ $tags_and_Qid['question_id'] ] ['tag'];

    // Grab the username for the question from the second array
    $username = $usernames [ $tags_and_Qid['question_id'] ] ['username'];

    // Grab the was_sent_at_time for the question from the second array
    $was_sent_at_time_unformatted = $was_sent_at_times [ $tags_and_Qid['question_id'] ] ['was_sent_at_time'];
    $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
    $was_sent_at_time = $was_sent_at_time_array[0];

    // Grap the question_id
    $question_id = $tags_and_Qid['question_id'];

    // 1.1 Print the Title & 1.2 Print the Tags
    create_question( $title, $tags, $question_id, $user_id, $username, $was_sent_at_time, "asked" );
}

?>
