<?php

// to make mainheader without a link
mainheader( "Tagged Questions", false);

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to get titles and question_ids
// When tag is given by the user
$result_titles = pg_prepare( $dbconn, "tag_search",
    "SELECT q.question_id, q.title, q.was_sent_at_time, u.username
        FROM questions q
            INNER JOIN tags t 
            ON q.question_id=t.question_id
            LEFT JOIN users u
            ON q.user_id=u.user_id
        WHERE tag = $1
        ORDER BY q.was_sent_at_time
        DESC LIMIT 50;"
);
$result_titles = pg_execute( $dbconn, "tag_search", 
    array( strip_tags( $_GET['tag'] ) )
);
//TODO with strip_tags

// TAGS
$result_tags = pg_prepare( $dbconn, "tags_query_search", 
    "SELECT question_id, tag
        FROM tags
        WHERE question_id IN
        (
            SELECT question_id
            FROM tags
            WHERE tag = $1
        )
        ORDER BY question_id;"
);
$result_tags = pg_execute( $dbconn, "tags_query_search", 
    array( $_GET['tag'] )
);

// First compile the Data

// Compile the data
// tags
while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
    // Add the Tag to an array of tags for that question
    $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];


}

if ( count ( $end_array ) == 0 ) {
    header( "Location: index.php?"
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

    create_question( $title, $tags, $question_id, $user_id, $username, $was_sent_at_time, "asked", $tags_and_Qid, $titles_and_Qid );

?>
