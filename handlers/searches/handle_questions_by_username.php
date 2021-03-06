<?php

/**
 * @brief   Hae kysymykset kayttajanimen mukaan
 * @file    handle_questions_by_username.php
 */

ob_start();
include ('getters_for_search.php');

/** Ota kysymyksen tiedot tietokannasta
 * @return array
 */
function get_raw_data () {
 /* 
  * $result_titles array
  */
	$dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");

	if ( empty ( $_GET['user_id'] ) ) {
		// to get titles and question_ids
		// When tag is given by the user
		$result_titles = pg_query_params( $dbconn,
				'SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
				FROM questions q
				LEFT JOIN users u
				ON q.user_id=u.user_id
				WHERE u.username = $1
				ORDER BY q.was_sent_at_time
				DESC LIMIT 50',
				array( strip_tags( $_GET['username'] ) )
				);
	}
	else
	{
		// to get titles and question_ids
		// When tag is given by the user
		$result_titles = pg_query_params( $dbconn,
				'SELECT q.question_id, q.title, q.was_sent_at_time, u.username, u.user_id
				FROM questions q
				LEFT JOIN users u
				ON q.user_id=u.user_id
				WHERE u.user_id = $1
				ORDER BY q.was_sent_at_time
				DESC LIMIT 50',
				array( strip_tags( $_GET['user_id'] ) )
				);
	}

	return $result_titles;
}

/** Ota tagit tietokannasta
 * @return array
 */
function get_tags () {
	/* $result_tags array
	 * $end_array array
	 */
	$dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");
	if ( empty ( $_GET['user_id'] ) ) {
		$result_tags = pg_query_params( $dbconn, 
				'SELECT t.question_id, t.tag
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
				ORDER BY t.question_id',
				array( $_GET['username'] )
				);
	}
	else
	{
		// strip_tags removes HTML and php from the GET
		$result_tags = pg_query_params( $dbconn, 
				'SELECT t.question_id, t.tag
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
				ORDER BY t.question_id',
				array( $_GET['user_id'] )
				);
	}

	while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
		// Add the Tag to an array of tags for that question
		$end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];
	}
	return $end_array;
}

/**
 * Luo otsikko kysymyslistalle
 */
function create_headings () {
	$end_array = get_tags();

	if ( count ( $end_array ) == 0 ) {
		mainheader( $_GET['username'], false );
		subheader( "0 Questions", false);
		return false;
	}
	else
	{
		mainheader( $_GET['username'], false );
		create_tab_box_question_usernames ( $_GET['username'] );
		subheader( count ( $end_array ) . " Questions", false);
		return true;
	}
}


/** J\"{a}rjest\"{a} kysymykset tagin mukaan
 */
function organize_questions_by_username () {

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

	if ( $_GET['tab_user'] == 'oldest' )
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

// Let's fire!

/** Luo otsikot ja j\"{a}rjest\"{a} kysymykset
 */
if (create_headings () != false)
{
	organize_questions_by_username ();
}
ob_end_flush();
?>
