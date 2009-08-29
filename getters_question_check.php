<?php

function get_status_of_question_in_database ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result = pg_query_params ( $dbconn,
        'SELECT question_id
        FROM questions
        WHERE question_id = $1',
        array ( $question_id )
    );

    if ( $result !== FALSE )
    {
        $row = pg_num_rows ( $result );

        if ( $row !== 0 )
            return true;
        else
            return false;
    }
    else
        return false;
}

?>
