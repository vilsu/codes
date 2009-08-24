<?php


function get_raw_data () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    // to get titles and question_ids
    // When tag is given by the user
    $result_titles = pg_query_params( $dbconn,
        "SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
        FROM questions q
        INNER JOIN tags t 
        ON q.question_id=t.question_id
        LEFT JOIN users u
        ON q.user_id=u.user_id
        WHERE tag = $1
        ORDER BY q.was_sent_at_time
        DESC LIMIT 50",
        array( strip_tags( $_GET['tag'] ) )
    );

    return $result_titles;
}


function get_tags () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result_tags = pg_query_params( $dbconn, 
        "SELECT question_id, tag
        FROM tags
        WHERE question_id IN
        (
            SELECT question_id
            FROM tags
            WHERE tag = $1
        )
        ORDER BY question_id",
        array( $_GET['tag'] )
    );

    while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
        // Add the Tag to an array of tags for that question
        $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];
    }
    return $end_array;
}

function get_titles () {
    $result_titles = get_raw_data();

    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];
    }
    return $titles;
}

function get_was_sent_at_times () {
    $result_titles = get_raw_data();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
            $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
    }
    return $was_sent_at_times;
}

function get_usernames () {
    $result_titles = get_raw_data();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
            $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
    }
    return $usernames;
}

function get_user_ids () {
    $result_titles = get_raw_data();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
            $user_ids [ $titles_and_Qid['question_id'] ] ['user_id'] = $titles_and_Qid['user_id'] ;
    }
    return $user_ids;
}




function create_headings () {
    $end_array = get_raw_data();
    // to check if 0 messages
    if ( count ( $end_array ) == 0 ) {
        mainheader( "Questions tagged by " . $_GET['tag'], false );
        subheader( count ( $end_array ) . " Questions", false);
    } 
    else if ( count ( $end_array ) == 1 ) {
        mainheader( "Questions tagged by " . $_GET['tag'], false );
        subheader( count ( $end_array ) . " Question", false);
    }
    else
    {
        mainheader( "Questions tagged by " . $_GET['tag'], false );
        create_tab_box_question_tags ( $_GET['tag'] );
        subheader( count ( $end_array ) . " Questions", false);
    }
}

function organize_questions_by_tag () {
    $end_array = get_tags ();
    $tags_and_Qid = get_tags ();
    $titles_and_Qid = get_titles ();
    $titles = get_titles ();
    $was_sent_at_times = get_was_sent_at_times ();
    $usernames = get_usernames ();
    $user_ids = get_user_ids ();

    if ( $_GET['tab_tag'] == 'newest' )
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

// Let's fire

create_headings ();
organize_questions_by_tag ();

?>
