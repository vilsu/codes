<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to process question sent from the lomake_ask_question.php


// no questions from ananymous
include 'handle_login_status.php';
// TODO bugaa vaikka on sisalla, niin false toi muuttuja
//if(!$logged_in){
 //   die("You are not logged_in");
    //header("Location: /codes/index.php");
//}


// INDEPENDENT VARIABLES

// TODO bugaa: vaikka on kirjautneena, niin ei nayta tata
$body = $_POST['body'];
$title = $_POST['title'];
$email = $_GET['email'];
$passhash_md5 = $_GET['passhash_md5'];
// $user_id
// 
//

// DATA PROCESSING TO GET VARIABLES
//
// USER_ID
$result = pg_prepare($dbconn, "query1", "SELECT user_id FROM users 
    WHERE email = $1;");
$result = pg_execute($dbconn, "query1", array($_email));
// to read the value
while ($row = pg_fetch_row($result)) {
    $user_id = $row[0];
}
//
//
// TAGS
// to get tags to an array 
//$tags = $_POST['tags']; 
//$tags_trimmed = trim($tags);
//$tags_array = explode(",", $tags_trimmed);
//
//
//
//// DATA to DB
//
//// to save the cells in the array to db
//for ($i = 0; $i < count($tags_array); $i++) {
//    $result . $i = pg_prepare($dbconn, "query2", "INSERT INTO tags 
//        (tag, questions_question_id)
//        VALUES ($1, $2);");
//    // TODO this may be a bug [$i]
//    $result . $i = pg_execute($dbconn, "query2", array($tags_array[$i], $user_id));
//}
//
////
//
// Body of the question TO DB 
$result = pg_prepare($dbconn, "query77", "INSERT INTO questions
    (body, title, users_user_id)
    VALUES ($1, $2, $3);");
$result = pg_execute($dbconn, "query77", array($body, $title, $user_id));

if($result) {
    $header = ("Location: /codes/index.php?" 
        . "question_sent"
        . "&"
        . "email="
        . $_GET['email']
        . "&"
        . "passhash_md5="
        . $_GET['passhash_md5']
        );
    header($header);
} else {
    header("Location: /codes/index.php?unsuccessful");
}

//pg_close($dbconn);
?>
