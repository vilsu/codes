<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
$user_id = ;
$body = "uoaeue";
$title = "eoouoae";

// to get the question_id from the db
$result = pg_query_params($dbconn, 
    "SELECT question_id 
    FROM questions
    WHERE user_id = $1
    AND title = $2
    AND body = $3",
    array($user_id, $title, $body)
);

while ($row = pg_fetch_row($result)) {
    $question_id = $row[0];
}

return $question_id;

?>
