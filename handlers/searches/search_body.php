<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

$result = pg_prepare ( $dbconn, "query_index",
    "SELECT body 
    FROM questions
    WHERE question_id = $1"
);
$result = pg_execute ( $dbconn, "query_index", array ( 14 ) );

while ( $row = pg_fetch_array ( $result ) ) {
    $question_body = $row['body'];
}

$question_index = explode ( " ", $question_body );

var_dump( $question_index );

?>
