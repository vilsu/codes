<?php
// To get answers for the question

/** Ota kysymystunniste vastaukselle
 * @param string $pattern
 * @param string $subject
 * @param string $query
 * @param integer $question_id
 * @return integer
 */
function get_question_id_for_answer () {
    if ($_GET['question_id'] > 0 ) 
    {
        $question_id = $_GET['question_id'];
    }
    else
    {
        $pattern = '/\?([^#]*)/';
        $subject = $_SERVER['HTTP_REFERER'];
        $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
        parse_str($query, $params);
        $question_id = explode( "=", $query );
    }
    return $question_id;
}


/** Ota vastaukset kysymykselle
 * @param integer $question_id
 * @return resource
 */
function fetch_answers ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    if ( !($_GET['sort'] == 'oldest' ) )
    {
        $result = pg_query_params ( $dbconn, 
            'SELECT a.answer, u.username, a.was_sent_at_time, u.user_id, a.answer_id
            FROM answers a
            LEFT JOIN users u ON a.user_id = u.user_id
            WHERE question_id = $1
            ORDER BY a.was_sent_at_time DESC',
            array ( $question_id )
        );
    }
    else
    {
        $result = pg_query_params ( $dbconn, 
            'SELECT a.answer, u.username, a.was_sent_at_time, u.user_id, a.answer_id
            FROM answers a
            LEFT JOIN users u ON a.user_id = u.user_id
            WHERE question_id = $1
            ORDER BY a.was_sent_at_time ASC',
            array ( $question_id )
        );
    }

    return $result;
}

/** Luo HTML alaotsikko vastauksille
 * @param integer $question_id
 * @param array $result_answers
 * @param integer $number_of_answers
 */
function create_subheader_for_answers ( $question_id ) {
    $result_answers = fetch_answers ( $question_id );
    // to print subheader for Answers
    $number_of_answers = pg_num_rows ( $result_answers );

    if ( $number_of_answers == 1 ) 
    {
        subheader( $number_of_answers 
            .  " Answer" );
    }
    // to have the underline
    else if ( $number_of_answers == 0 ) {
        subheader( "Be the first answerer" );
    }
    else
    {
        echo ("<div id='subheader'>"
            . "<h2>"
            . $number_of_answers . " Answers"
            . "</h2>" );
        create_tab_box_thread( $question_id );
        echo ( "</div>" );
    }
}


/** Ota vastauksen l\"{a}hetysaika
 * @param integer $question_id
 * @param string $was_sent_at_time
 * @param array $was_sent_at_time_array
 * @return string
 */
function get_was_sent_time_for_answer ( $question_id ) {
    // Grab the was_sent_at_time for the question from the second array
    $was_sent_at_time_unformatted = $answer_row['was_sent_at_time'];
    $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
    $was_sent_at_time = $was_sent_at_time_array[0];

    return $was_sent_at_time;
}


/** Luo HTML vastausten s\"{a}ili\"{o}
 * @param integer $question_id
 * @param integer $number_of_answers
 * @param array $result_answers
 * @param array $answers_real
 * @param string $answer
 * @param integer $user_id
 * @param string $username
 * @param string $was_sent_at_time
 */
function create_answer_box ( $question_id ) {
    $result_answers = fetch_answers ( $question_id );
    // to print subheader for Answers
    $number_of_answers = pg_num_rows ( $result_answers );

    if ( $number_of_answers !== 0 ) 
    {
        $result_answers = fetch_answers ( $question_id );
        $answers_real = pg_fetch_all( $result_answers );
        foreach ( $answers_real as $answer_row ) {
            echo ("<div id='one_answer'>");
            $answer = $answer_row['answer'];
            create_answer( $answer );
            echo ("<div class='clear'> </div>");

            $user_id = $answer_row['user_id'];
            $username = $answer_row['username'];

            $was_sent_at_time = $answer_row['was_sent_at_time'];
            $was_sent_at_time = get_was_sent_time_for_answer ( $question_id );

            create_user_info_box_question( $user_id, $username, $was_sent_at_time, "answered" );

            echo("</div>");
        }
        echo ("</div>");
    }

}










// Let's fire!

/** Luo alaotsikko vastauksille ja tee vastauss\"{a}ili\"{o}
 */

create_subheader_for_answers ( get_question_id_for_answer () );
create_answer_box ( get_question_id_for_answer () );

?>
