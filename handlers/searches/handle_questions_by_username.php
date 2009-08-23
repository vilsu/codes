<?php

// to make mainheader without a link

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");


if ( empty ( $_GET['user_id'] ) ) {/*{{{*/

    // to get titles and question_ids
    // When tag is given by the user
    $result_titles = pg_query_params( $dbconn,
        "SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
        FROM questions q
        LEFT JOIN users u
        ON q.user_id=u.user_id
        WHERE u.username = $1
        ORDER BY q.was_sent_at_time
        DESC LIMIT 50",
        array( strip_tags( $_GET['username'] ) )
    );

    // TAGS
    $result_tags = pg_query_params( $dbconn, 
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
        ORDER BY t.question_id",
        array( $_GET['username'] )
    );
}
/*}}}*/
else 
{/*{{{*/
    // to get titles and question_ids
    // When tag is given by the user
    $result_titles = pg_query_params( $dbconn,
        "SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
        FROM questions q
        LEFT JOIN users u
        ON q.user_id=u.user_id
        WHERE u.user_id = $1
        ORDER BY q.was_sent_at_time
        DESC LIMIT 50",
        array( strip_tags( $_GET['user_id'] ) )
    );
    // strip_tags removes HTML and php from the GET

    // TAGS
    $result_tags = pg_query_params( $dbconn, 
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
                WHERE u.user_id=$1
            )
        )
        ORDER BY t.question_id",
        array( $_GET['user_id'] )
    );

    /*}}}*/

    // First compile the Data

    // Compile the data
    // tags
    while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
        // Add the Tag to an array of tags for that question
        $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];
    }
    // to check if 0 messages
    if ( count ( $end_array ) == 0 ) {
        mainheader( $_GET['username'], false );
        subheader( count ( $end_array ) . " Questions", false);
    }
    else
    {
        mainheader( $_GET['username'], false );
        create_tab_box_question_usernames ( $_GET['username'] );
        subheader( count ( $end_array ) . " Questions", false);

        // Titles
        while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
            $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];

            $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
            $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
            $user_ids [ $titles_and_Qid['question_id'] ] ['user_id'] = $titles_and_Qid['user_id'] ;
        }

        if ( $_GET['tab_user'] == 'newest' )
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
