<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to process question sent from the lomake_ask_question.php

// INDEPENDENT VARIABLES
    //  $_POST['question']['body']:
    //  $_POST['question']['title']
    //  $_SESSION['login']['email']
    //  $_SESSION['login']['passhash_md5']
    //  $user_id


session_save_path("/tmp/");
session_start();


if( $_SESSION['login']['logged_in'] == false ) {
    header("Location: /codes/index.php"
        . "?unsuccessful"
    );
    die("You are not logged_in");
}

$body = $_POST['question']['body'];
$title = $_POST['question']['title'];

$email = $_SESSION['login']['email'];
$passhash_md5 = $_SESSION['login']['passhash_md5'];


// DATA PROCESSING TO SESSION VARIABLES
//
// haetaan USER_ID
$result = pg_prepare($dbconn, "query1", "SELECT user_id FROM users 
    WHERE email = $1;");
$result = pg_execute($dbconn, "query1", array($email));
// to read the value
while ($row = pg_fetch_row($result)) {
    $user_id = $row[0];
}

// This needs to be before Tags, since we need the question_id
// Body of the question TO DB 
$result = pg_prepare($dbconn, "query77", "INSERT INTO questions
    (body, title, users_user_id)
    VALUES ($1, $2, $3);");
$result = pg_execute($dbconn, "query77", array($body, $title, $user_id));

if(isset($result)) {
    $header = ("Location: /codes/index.php?" 
        . "question_sent"
        );
    header($header);
} else {
    header("Location: /codes/index.php?unsuccessful");
}

// to get the question_id from the db
$result = pg_prepare($dbconn, "query87", "SELECT question_id FROM questions
    WHERE title = $1 AND 
          body = $2 AND
          users_user_id = $3;
");
$result = pg_execute($dbconn, "query87", array($title, $body, $user_id));
while ($row = pg_fetch_row($result)) {
    $question_id = $row[0];
}


// TAGS
$tags = $_POST['question']['tags'];
// to strip whitespaces at the end and beginning
$tags_trimmed = preg_replace('/\s+/', '', $tags);
// to make an array of the tags
$tags_array = explode(",", $tags_trimmed);


// TAGS to DB
$result = pg_prepare($dbconn, "query2", "INSERT INTO tags
    (tag, questions_question_id)
    VALUES ($1, $2);");
// to save the cells in the array to db
for ($i = 0; $i < count($tags_array); $i++) {
    // TODO this may be a bug [$i]
    $result = pg_execute($dbconn, "query2", array($tags_array[$i], $question_id));
}


//pg_close($dbconn);
?>
