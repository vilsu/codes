<?php

/**
 * @brief   Getterit hauille
 * @file    getters_for_search.php
 */


/** Ota kysymysten otsikot
 * @return array
 */
function get_titles () {
 /* 
  * $titles array
  */
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];
    }
    return $titles;
}

/** Ota kysymysten l\"{a}hetysajat
 * @return array
 */
function get_was_sent_at_times () {
 /* 
  * $was_sent_at_times array
  */
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $was_sent_at_times [ $titles_and_Qid['question_id'] ] ['was_sent_at_time'] = $titles_and_Qid['was_sent_at_time'] ;
    }
    return $was_sent_at_times;
}

/** Ota k\"{a}ytt\"{a}jien nimet
 * @return array
 */
function get_usernames () {
 /* 
  * $usernames array
  */

    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $usernames [ $titles_and_Qid['question_id'] ] ['username'] = $titles_and_Qid['username'] ;
    }
    return $usernames;
}

/** Ota k\"{a}ytt\"{a}j\"{a}tunnisteet
 * @return array
 */
function get_user_ids () {
 /* 
  * $user_ids array
  */
    $result_titles = get_raw_data ();
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $user_ids [ $titles_and_Qid['question_id'] ] ['user_id'] = $titles_and_Qid['user_id'] ;
    }
    return $user_ids;
}


?>
