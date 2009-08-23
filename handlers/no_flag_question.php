<?php

$result = pg_query_params ( $dbconn, 
    "UPDATE questions
    SET flagged_for_moderator_removal = 0
    WHERE question_id = $1",
    array ( $_GET['question_id'] ) 
);
if ( !$result ) {
    echo ("Unsuccessufl udptate process. This is reported for admin.");
}

?>
