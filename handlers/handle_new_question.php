<?php

// to process questions sent from the lomake_question.php

// no questions from ananymous
include 'handle_login_status.php';
if(!$logged_in){
    header("Location: index.php");
    die("You are not logged_in");
}

$question_body = $_POST['body'];
$question_title = $_POST['title'];

$result10 = pg_prepare($dbconn, "query1", "SELECT question_id FROM users 
    WHERE username = $1;");
// $username tulee handle_login_form.php:lta
$result = pg_execute($dbconn, "query1", array($username));

// to get tags to an array 
$tags = $_POST['tags']; 
$tags_trimmed = trim($tags);
$tags_array = explode(",", $tags_trimmed);

// to save the cells in the array to db
for ($i = 0; $i < count($tags_array); $i++) {
    $result.$i = pg_prepare($dbconn, "query2", "INSERT INTO tags (tag, questions_question_id)
        VALUES ($1, $2);");
    $result.$i = pg_execute($dbconn, "query2", array($tags_array[$i], $result10));
}

// haetaan muuttujien arvot db:sta ja lomakkeelta
$result = pg_prepare($dbconn, "query3", "SELECT username, passhash_md5 FROM users
    WHERE username = $1
    AND passhash_md5 = $2;");
$result = pg_execute($dbconn, "query3", array($_POST['username'], md5($_POST['password'])));
if(!$result) {
    echo "An error occurred - Hhhhhhhhhhh";
    exit;
}

pg_close($dbconn);
?>
