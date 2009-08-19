<?php

// to make mainheader without a link
mainheader( "Recent Questions", false);
create_tab_box_question( );

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to get titles and question_ids
$result_titles = pg_prepare( $dbconn, "query777", 
    "SELECT q.question_id, q.title, q.was_sent_at_time, u.username 
    FROM questions q
    LEFT JOIN users u
        ON q.user_id=u.user_id 
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

if ( pg_num_rows( $result_titles ) == 0 ) {
    header ( "Location: /codes/index.php?"
        . "no_question_found"
    );
}

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

    $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
    $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
}


// $title should be the actual string, not an array
// $tags should be single, non-multidimensional array containing tag names

if ( $_GET['tab'] == 'newest' ) {
    // Go through each question
    foreach( array_reverse( $end_array, true ) as $tags_and_Qid['question_id'] => $titles_and_Qid['title'] )
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

        create_question( 
            $title, 
            $tags, 
            $question_id, 
            $user_id, 
            $username, 
            $was_sent_at_time, 
            "asked"
        );
    }
}

if ( $_GET['tab'] == 'oldest' ) {
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

        create_question( 
            $title, 
            $tags, 
            $question_id, 
            $user_id, 
            $username, 
            $was_sent_at_time, 
            "asked"
        );
    }
} else {
    // newest questions at the top of homepage initially
    // Go through each question
    foreach( array_reverse ( $end_array, true ) as $tags_and_Qid['question_id'] => $titles_and_Qid['title'] )
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

        create_question( 
            $title, 
            $tags, 
            $question_id, 
            $user_id, 
            $username, 
            $was_sent_at_time, 
            "asked"
        );
    }
}




?>
