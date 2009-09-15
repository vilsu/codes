<?php

/**
 * @brief   Hae kysymykset otsikon ja sisallon mukaan
 * @file    search_body.php
 */

ob_start();
include ('getters_for_search.php');

/** Ota kysymykset tietokannasta
 * @return array
 */
function get_raw_data () {
 /* 
  * $result array
  */
    $dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");

    $result = pg_query_params ( $dbconn, 
        'SELECT q.question_id, q.body, q.title, q.was_sent_at_time, 
            u.username, u.user_id
        FROM questions q
        LEFT JOIN users u
        ON q.user_id=u.user_id
        WHERE body ilike $1
            OR title ilike $1
        ORDER BY was_sent_at_time DESC
        LIMIT 50',
        array ( '%' . $_GET['search'] . '%')
    );

    if ( pg_num_rows( $result ) == 0 ) {
        echo ("Pieleen alussa");
        header ( "Location: /pgCodesS/index.php?"
            . "no_question_found"
        );
    }
    else if ( pg_num_rows( $result ) !== 0 )
        return $result;
    else
        echo ("No raw data from the first query");
}

/** Ota tagit tietokannasta
 * @return array
 */

function get_tags () {
 /* $result_tags array
 * $end_array array
 */
    $dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");

    $result_tags = pg_query_params( $dbconn, 
        'SELECT question_id, tag
        FROM tags
        WHERE question_id IN 
        ( 
            SELECT question_id
            FROM questions
            WHERE BODY ilike $1
            OR title ilike $1
            LIMIT 50
        )',
        array ( '%' . $_GET['search'] . '%')
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
    subheader( "Recent Questions for " . $_GET['search'], false);
    create_tab_box_question( );
    echo ("</div>");
}


/** J\"{a}rjest\"{a} kysymykset tagin mukaan
 */
function organize_questions_by_keyword () {

 /* $end_array array
 * $tags_and_Qid array
 * $titles_and_Qid array
 * $titles array
 * $was_sent_at_times array
 * $usernames array
 * $user_ids array
 */
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
organize_questions_by_keyword ();


ob_end_flush();

?>
