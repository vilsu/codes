<?php

// to handle questions from ../lomakkeet/lomake_answer.php

// no questions from ananymous
include 'handle_login_status.php';
if(!$logged_in){
    header("Location: index.php");
    die("You are not logged_in");
}

$result = pg_prepare($dbconn, "query1", "SELECT question_id FROM users 
                              WHERE email = $1;");
// $email tulee handle_login_status.php -lomakkeelta
$result = pg_execute($dbconn, "query1", array($email));

$result = pg_prepare($dbconn, "query2", "INSERT INTO answers (answer, questions_question_id)
                            VALUES ($1, $2);");
// $answer tulee lomakkeelta, kun taas $questions_question_id tulee URL:ista 
$result = pg_execute($dbconn, "query2", array($_POST['answer'], $_GET['questions_question_id']));

pg_close($dbconn);

?>
