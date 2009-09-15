<?php

/**
 * @file    delete_a_question.php
 * @brief   Poista kysymys
 *
 * Tiedosto laukaisee jQuery funktion tiedosta jQuery.php.
 */

/**
 * Poista kysymys
 * @param $question_id 
 * 	kysymystunniste integer
 */

function delete_question ( $question_id ) {
	$dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");

	// remove the body and title of the question
	$result = pg_query_params ( $dbconn,
			'DELETE FROM questions
			WHERE question_id = $1',
			array ( $question_id ) 
			);
	// remove tags of the question
	$result = pg_query_params ( $dbconn, 
			'DELETE FROM tags
			WHERE question_id = $1',
			array ( $question_id )
			);
	// remove answers of the question
	$result = pg_query_params ( $dbconn,
			'DELETE FROM answers
			WHERE question_id = $1',
			array ( $question_id )
			);
	header( "Location: /pgCodesS/index.php?successful_removal");
}

/**
 * Poista kysymys
 */
delete_question ( $_POST['question_id'] );

?>
