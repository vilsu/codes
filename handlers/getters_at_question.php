<?php 

/**
 * @file    getters_at_question.php
 * @brief   Gettereita kysymyksessa
 */


/** 
 * Ota kysymystunniste
 * @return integer
 */
function get_questionID_at_question () {
/**
 * $question_id	integer
 * $subject	string
 * pattern 	string
 * $query	string
 */
    $pattern = '/question_id=([^#&]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str( $query, $params );
    $question_id = explode( "=", $query );      // this is an array

    return $question_id[0];
}

?>
