<?php

/**
 * @brief   Hae kysymykset tagin mukaan
 * @file    handle_questions_by_tag.php
 */

ob_start();
include ('getters_for_search.php');

/** Ota kysymyksen tiedot tietokannasta
 * @param array $result_titles
 * @return array
 */
function get_raw_data () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    // to get titles and question_ids
    // When tag is given by the user
    $result_titles = pg_query_params( $dbconn,
        'SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
        FROM questions q
        INNER JOIN tags t 
        ON q.question_id=t.question_id
        LEFT JOIN users u
        ON q.user_id=u.user_id
        WHERE tag = $1
        ORDER BY q.was_sent_at_time
        DESC LIMIT 50',
        array( strip_tags( $_GET['tag'] ) )
    );

    return $result_titles;
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
            FROM tags
            WHERE tag = $1
        )
        ORDER BY question_id',
        array( $_GET['tag'] )
    );

    while ( $tags_and_Qid = pg_fetch_array ( $result_tags ) ) {
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
 * @param array $end_array
 */
function create_headings () {
    $end_array = get_tags();
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


/** J\"{a}rjest\"{a} kysymykset tagin mukaan
 * @param array $end_array
 * @param array $tags_and_Qid
 * @param array $titles_and_Qid
 * @param array $titles
 * @param array $was_sent_at_times
 * @param array $usernames
 * @param array $user_ids
 */
function organize_questions_by_tag () {
    $end_array = get_tags ();
    $tags_and_Qid = get_tags ();
    $titles_and_Qid = get_titles ();
    $titles = get_titles ();
    $was_sent_at_times = get_was_sent_at_times ();
    $usernames = get_usernames ();
    $user_ids = get_user_ids ();

    if ( $_GET['tab_tag'] == 'oldest' )
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
organize_questions_by_tag ();

ob_end_flush();
?>
