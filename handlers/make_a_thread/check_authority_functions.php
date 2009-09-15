<?php

/**
 * @brief   Tarkasta kayttajan oikeudet
 * @file    check_authority_functions.php
 */



/** Tarkasta oikeudet kysymyksen muokkaamiseen ja poistoon
 * @param $question_id integer 
 * @param $user_id integer 
 * @return boolean
 */
function check_authority_for_a_question ( $question_id, $user_id) {
    if ( $_SESSION['login']['logged_in'] == 1 ) {

        $dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");
        $result = pg_query_params ( $dbconn, 
            'SELECT user_id
            FROM questions
            WHERE user_id = $1
            AND question_id = $2',
            array ( $_SESSION['login']['user_id'], 
            $_GET['question_id'] ) 
        );
	/*
       	 * $result_clear integer
         */
        while ( $row = pg_fetch_array ( $result ) ) {
            $result_clear = $row['user_id'];
        }

        // to allow the asker to remove his own questions
        if ( $_SESSION['login']['a_moderator'] == 1 )
            return true;
        else 
            return false;
    }
    else
        return false;
}


?>
