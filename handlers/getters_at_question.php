<?php 

/** Ota kysymystunniste
 * @param integer $question_id
 * @param string $subject
 * @param string $pattern
 * @param string $query
 */
function get_questionID_at_question () {
    $pattern = '/question_id=([^#&]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
    parse_str( $query, $params );
    $question_id = explode( "=", $query );      // this is an array

    return $question_id[0];
}

?>
