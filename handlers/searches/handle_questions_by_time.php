<?php

// to make mainheader without a link
mainheader( "Recent Questions", false);

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to get titles and question_ids
$result_titles_tags = pg_prepare( $dbconn, "query777", 
    "SELECT question_id, title
    FROM questions
    WHERE question_id IN
    ( 
        SELECT question_id
        FROM questions
        LIMIT 50
    ) 
    ORDER BY was_sent_at_time DESC
    LIMIT 50;" 
);

$result_titles = pg_execute( $dbconn, "query777", array());

// we use two queries because no repeation of `titles` then
// TAGS
$result_tags = pg_prepare( $dbconn, "query9", 
    "SELECT question_id, tag
    FROM tags
    WHERE question_id IN 
    ( 
        SELECT question_id
        FROM questions
        LIMIT 50
    );"
);
$result_tags = pg_execute( $dbconn, "query9", array());


// Compile the data
// tags
while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
    // Add the Tag to an array of tags for that question
    $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];

}


// Titles
while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
    $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];
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

    // Grap the question_id
    $question_id = $tags_and_Qid['question_id'];

    // 1.1 Print the Title & 1.2 Print the Tags
    create_question($title, $tags, $question_id);
}

?>
