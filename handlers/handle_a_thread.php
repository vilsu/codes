<?php
 
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to handle questions from ../forms/lomake_answer.php

// no questions from ananymous
if(!$logged_in){
    header("Location: /codes/index.php");
    die("You are not logged_in");
}

$result = pg_prepare($dbconn, "query1", "SELECT question_id FROM users 
                              WHERE email = $1;");

$result = pg_execute($dbconn, "query1", array($_SESSION['login[email]']));

$result = pg_prepare($dbconn, "query2", "INSERT INTO answers (answer, questions_question_id)
                            VALUES ($1, $2);");
// $answer tulee lomakkeelta, kun taas $questions_question_id tulee URL:ista 
$result = pg_execute($dbconn, "query2", array($_POST['login[answer]'], $_GET['questions_question_id']));

//pg_close($dbconn);

?>
