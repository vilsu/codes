<?php
// LIST OF 10 QUESTIONS
// if there is no data in $_GET, then the print 10 questions
// to use SESSIONS TODO
if (isset($_REQUEST[''])) {
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
?>
