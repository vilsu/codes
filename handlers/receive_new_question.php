<?php

// This handles the receiving of new questions to database
// and gives users feedback about the completion.


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


if( $_SESSION['login']['logged_in'] == 0 ) {
    header("Location: /codes/index.php"
        . "?unsuccessful"
    );
    die("You are not logged_in");
}

// to sanitize data
$body = pg_escape_string ( $_POST['question']['body'] );
$title = pg_escape_string ( $_POST['question']['title'] );

$email = $_SESSION['login']['email'];
$passhash_md5 = $_SESSION['login']['passhash_md5'];


if ( mb_strlen ( $title ) > 200 ) {
    // back to the ask_question page
    header ("Location: /codes/index.php?"
        . "ask_question"
        . "&"
        . "too_long_title"
    );
}

if ( empty ( $_POST['question']['tags'][1] ) ) {
    header ("Location: /codes/index.php?"
        . "ask_question"
        . "&"
        . "no_tag"
    );
}

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
$result_question = pg_prepare($dbconn, "query77", "INSERT INTO questions
    (body, title, user_id)
    VALUES ($1, $2, $3);");
$result_question = pg_execute($dbconn, "query77", array($body, $title, $user_id));

// to get the question_id from the db
$result = pg_prepare($dbconn, "query87", "SELECT question_id FROM questions
    WHERE title = $1 AND 
          body = $2 AND
          user_id = $3;
");
$result = pg_execute($dbconn, "query87", array($title, $body, $user_id));
while ($row = pg_fetch_row($result)) {
    $question_id = $row[0];
}

// TAGS
// to sanitize data
$tags = pg_escape_string ( $_POST['question']['tags'] );
// to strip whitespaces at the end and beginning
$tags_trimmed = preg_replace('/\s+/', '', $tags);
// to make an array of the tags
$tags_array = explode(",", $tags_trimmed);


if ( !empty ( $tags_array ) ) {
    // TAGS to DB
    $result = pg_prepare($dbconn, "query2", "INSERT INTO tags
        (tag, question_id)
        VALUES ($1, $2);");
    // to save the cells in the array to db
    for ($i = 0; $i < count($tags_array); $i++) {
        $result = pg_execute($dbconn, "query2", array($tags_array[$i], $question_id));
    }
}

if ( isset ( $result_question ) ) {
    header  ("Location: /codes/index.php?" 
        . "question_sent"
        . "&"
        . "question_id="
        . $question_id
        . "&"
        . $title  // for user
        );
} else {
    header("Location: /codes/index.php?unsuccessful");
}




//pg_close($dbconn);
?>
