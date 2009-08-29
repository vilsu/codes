<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
// remove the answer 
$result = pg_query_params ( $dbconn,
    'DELETE FROM answers 
    WHERE answer = $1',
    array ($_POST['answer'] ) 
);

?>
