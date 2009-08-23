<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to get titles and question_ids
$result_titles = pg_query_params( $dbconn,
    "SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
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
    LIMIT 50",
    array()
);
if ( pg_num_rows( $result_titles ) == 0 ) {
    header ( "Location: /codes/index.php?"
        . "no_question_found"
    );
} else if ( pg_num_rows( $result_titles ) !== 0 ) {
    // to make mainheader without a link
    echo ("<div class='top_header'>");
    subheader( "Recent Questions", false);
    create_tab_box_question( );
    echo ("</div>");

    // we use two queries because no repeation of `titles` then
    // TAGS
    $result_tags = pg_query_params( $dbconn, 
        "SELECT question_id, tag
        FROM tags
        WHERE question_id IN 
        ( 
            SELECT question_id
            FROM questions
            LIMIT 50
        )",
        array()
    );


    // Compile the data
    // tags
    while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
        // Add the Tag to an array of tags for that question
        $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];
    }
    // to check if 0 messages
    if ( count ( $end_array ) == 0 ) {
        header( "Location: index.php?"
            . "no_question_found"
        );
    }
    else {
        // Titles
        while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
            $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];

            $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
            $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
            $user_ids [ $titles_and_Qid['question_id'] ] ['user_id'] = $titles_and_Qid['user_id'] ;
        }

        if ( $_GET['tab'] == 'oldest' )
        {
            organize_questions ( 
                $end_array, 
                $tags_and_Qid,
                $titles_and_Qid,
                $titles,
                $was_sent_at_times,
                $usernames,
                $user_ids );
        }
        else
        {
            organize_questions ( 
                array_reverse ( $end_array, true ), 
                $tags_and_Qid,
                $titles_and_Qid,
                $titles,
                $was_sent_at_times,
                $usernames,
                $user_ids );
        }
    }
}
?>
