<?php

/** Tarkasta oikeudet kysymyksen muokkaamiseen ja poistoon
 * @param integer $question_id
 * @param integer $user_id
 * @param integer $result_clear
 * @return boolean
 */
function check_authority_for_a_question ( $question_id, $user_id) {
    if ( $_SESSION['login']['logged_in'] == 1 ) {

        $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
        $result = pg_query_params ( $dbconn, 
            'SELECT user_id
            FROM questions
            WHERE user_id = $1
            AND question_id = $2',
            array ( $_SESSION['login']['user_id'], 
            $_GET['question_id'] ) 
        );
        while ( $row = pg_fetch_array ( $result ) ) {
            $result_clear = (int) $row['user_id'];
        }

        // to allow the asker to remove his own questions
        if ( is_integer ( $result_clear ) )
            return true;
        else if ( $_SESSION['login']['a_moderator'] == 1 )
            return true;
        else 
            return false;
    }
    else
        return false;
}


?>
