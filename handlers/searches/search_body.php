<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

$result = pg_query_params ( $dbconn, 
    "SELECT question_id, body
    FROM questions",
    array ()
);


while ( $row = pg_fetch_array ( $result ) ) {
    $question_body [ $row['question_id'] ] ['body'] = $row['body'];
    $question_index = explode ( " ", $question_body[ $row['question_id'] ] ['body'] );
    $question_index = array_unique ( $question_index );
}
var_dump( $question_index );

?>
