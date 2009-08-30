<?php

/**
 * @file delete_a_question.php
 *
 * Tiedosto laukaisee jQuery funktion tiedosta jQuery.php.
 */

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// remove the body and title of the question
$result = pg_query_params ( $dbconn,
    'DELETE FROM questions
    WHERE question_id = $1',
    array ($_POST['question_id'] ) 
);
if ( !$result ) {
    header( "Location: /codes/index.php?unsuccessful_removal");
}
else if ( $result ) {
    // remove tags of the question
    $result = pg_query_params ( $dbconn, 
        'DELETE FROM tags
        WHERE question_id = $1',
        array ( $_POST['question_id'] )
    );
    if ( !$result ) {
        header( "Location: /codes/index.php?unsuccessful_removal");
    }
    else if ( $result ) {
        // remove answers of the question
        $result = pg_query_params ( $dbconn,
            'DELETE FROM answers
            WHERE question_id = $1',
            array ( $_POST['question_id'] )
        );
        if ( !$result ) {
            header( "Location: /codes/index.php?unsuccessful_removal");
        }
        else if ( $result ) {
            header( "Location: /codes/index.php?successful_removal");
        }
    }
}

?>
