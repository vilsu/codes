<?php

/**
 * @brief   Hae kysymykset ajan mukaan
 * @file    handle_questions_by_time.php
 */

ob_start();
include ('getters_for_search.php');

/** Ota kysymykset tietokannasta
 * @param array $result_titles
 * @return array
 */
function get_raw_data () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to get titles and question_ids
    $result_titles = pg_query_params( $dbconn,
        'SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
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
        LIMIT 50',
        array()
    );

    if ( pg_num_rows( $result_titles ) == 0 ) {
        header ( "Location: /codes/index.php?"
            . "no_question_found"
        );
    }
    else if ( pg_num_rows( $result_titles ) !== 0 ) {
        return $result_titles;
    }
    else
    {
        echo ("No raw data from the first query");
//        return false;
    }
}

/** Ota tagit tietokannasta
 * @param array $result_tags
 * @param array $end_array
 * @return array
 */

function get_tags () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result_tags = pg_query_params( $dbconn, 
        'SELECT question_id, tag
        FROM tags
        WHERE question_id IN 
        ( 
            SELECT question_id
            FROM questions
            LIMIT 50
        )',
        array()
    );
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
    else
        return $end_array;
}


/** Luo otsikot
 */
function create_headings () {
    // to make mainheader without a link
    echo ("<div class='top_header'>");
    subheader( "Recent Questions", false);
    create_tab_box_question( );
    echo ("</div>");
}


/** J\"{a}rjest\"{a} kysymykset tagin mukaan
 * @param array $end_array
 * @param array $tags_and_Qid
 * @param array $titles_and_Qid
 * @param array $titles
 * @param array $was_sent_at_times
 * @param array $usernames
 * @param array $user_ids
 */
function organize_questions_by_time () {
    $end_array = get_tags ();
    $tags_and_Qid = get_tags ();
    $titles_and_Qid = get_titles ();
    $titles = get_titles ();
    $was_sent_at_times = get_was_sent_at_times ();
    $usernames = get_usernames ();
    $user_ids = get_user_ids ();

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

// Let's fire

/** Luo otsikot ja j\"{a}rjest\"{a} kysymykset
 */
create_headings ();
organize_questions_by_time ();


ob_end_flush();
?>
