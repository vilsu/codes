<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

// to process question sent from the lomake_ask_question.php

// INDEPENDENT VARIABLES
    //  $_POST['question[body]']
    //  $_POST['question[title]']
    //  $_REQUEST['login[email]']
    //  $_REQUEST['login[passhash_md5]']
    //  $user_id

// TODO bugaa vaikka on sisalla, niin false toi muuttuja
if(!$logged_in){
    header("Location: /codes/index.php");
    die("You are not logged_in");
}

// TODO bugaa: vaikka on kirjautneena, niin ei nayta tata
$body = $_POST['question[body]'];
$title = $_POST['question[title]'];

$email = $_REQUEST['login[email]'];
$passhash_md5 = $_REQUEST['login[passhash_md5]'];


// DATA PROCESSING TO REQUEST VARIABLES
//
// USER_ID
$result = pg_prepare($dbconn, "query1", "SELECT user_id FROM users 
    WHERE email = $1;");
$result = pg_execute($dbconn, "query1", array($email));
// to read the value

echo $result;
while ($row = pg_fetch_row($result)) {
    $user_id = $row[0];
}

///*{{{*/
//
// TAGS
// to get tags to an array 
//$tags = $_POST['question[tags]']; 
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
/////*}}}*/
//
// Body of the question TO DB 
$result = pg_prepare($dbconn, "query77", "INSERT INTO questions
    (body, title, users_user_id)
    VALUES ($1, $2, $3);");
$result = pg_query($dbconn, "query77", array($body, $title, "sami2@gmail.com"));

// TODO bugaa: email ja passhash_md5 ei kulkeudu, kun kysymys on lahetetty
if(isset($result)) {
    $header = ("Location: /codes/index.php?" 
        . "question_sent"
        );
    header($header);
} else {
    header("Location: /codes/index.php?unsuccessful");
}

//pg_close($dbconn);
?>
