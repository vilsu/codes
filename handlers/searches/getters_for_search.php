<?php

function get_titles () {
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];
    }
    return $titles;
}

function get_was_sent_at_times () {
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
    }
    return $was_sent_at_times;
}

function get_usernames () {
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
    }
    return $usernames;
}

function get_user_ids () {
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $user_ids [ $titles_and_Qid['question_id'] ] ['user_id'] = $titles_and_Qid['user_id'] ;
    }
    return $user_ids;
}


?>
