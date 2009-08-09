<?php 

set_include_path=':/home/noa/Dropbox/tietokantasovellus/Sami/codes/handlers:/home/noa/Dropbox/tietokantasovellus/Sami/codes/lomakkeet:'

// otetaan yhteys kantaan
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
if(!$dbconn) {
    echo "An error occurred - Hhhh\n";
    exit;
}

// check the login status
include 'handle_login_status.php';
?>

<html>
<head>
   <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <title>Keskustelusivu</title>
</head>

<body>

<div id="navbar">
    <h1 id="logo">Keskustelusivu</h1>

    <!-- to change the layout of the "Ask question" -button -->
    <!-- default: 
                <div class="ask_question">
         active:  
                <div class="ask_question" id='ask_question_active'>
    -->
    <div class="ask_question" 
        <?php
        if(array_key_exists('ask_question', $_GET)) {
            echo "id='ask_question_active'";
        }
        ?>
    >
        <a href="?ask_question">Ask question</a>
    </div>
</div>







<div id="mainbar">
<?php

// ASK QUESTION -view
if (array_key_exists('ask_question', $_GET)) {
    // change the layout by adding question form by getting data from 
    // lomakkeet/lomake_ask_question.php
    include 'lomakkeet/lomake_ask_question.php';
}

// LIST OF 10 QUESTIONS
// if there is no data in $_GET, then the print 10 questions
if (array_key_exists('', $_GET)) {
    $result = pg_prepare($dbconn, "query8", "SELECT question_id, title FROM questions
        ORDER BY was_sent_at_time DESC LIMIT 10;");
    $result = pg_execute($dbconn, "query8", array());
    // print the title of each question: title
    // to make the URL for each title: question_id, title
    //      index.php?question_id=777&title
    //                |               |--- for reader
    //                |------------------- for computer: lomake_question_answer.php
    while($row = pg_fetch_row($result)) {
        echo "<div id='question_summary'>
                
                    <h3>
                        <a href='?question_id=" . $row[0] . "&" . $row[1] . "'>" . $row[1] . "</a>
                    </h3>
                </div>";
    }
}

// A QUESTION SELECTED BY USER 
// to generate the answers for the given question 
if (array_key_exists('question_id', $_GET)) {

    // to get the title and body of the question
    $result = pg_prepare($dbconn, "query9", "SELECT title, body  
        FROM questions WHERE question_id = $1;");
    // TODO I am not sure if the syntax is correct for parametr inside $_GET
    $result_title_body = pg_execute($dbconn, "query9", array($_GET['question_id']));

    // to get answers for the question
    $result = pg_prepare($dbconn, "query10", "SELECT answer FROM answers
        WHERE questions_question_id = $1;");
    $result_answer = pg_execute($dbconn, "query10", array($_GET['question_id']));
}


?>

</div>

</body>
</html>

