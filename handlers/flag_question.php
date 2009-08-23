<?php

$subject = "Flagged question"; 
$question_id = $_POST['question_id']; // to get data from jQuery.post

$to = 'ville.tapsu@gmail.com';
$message = "<a href='index.php?question_id=" . $question_id . "'>"
    . "The question " . $question_id . "</a> is flagged by an user. Please, review it.";

if ( mail( $to, $subject, $message ) ) {
    echo "Thank you for your report!";
}
else {
    echo ("There is some error in sending the report");
}

// to change the status in the database
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
$result = pg_query_params ( $dbconn,
    "UPDATE questions
    SET flagged_for_moderator_removal = 1
    WHERE question_id = $1",
    array ( $_POST['question_id'] )   // by jQuery.post
);
if ( !$result ) {
    header( "Location: /codes/index.php?unsuccessful_flagging");
    echo ("Unsuccessufl udptate process. This is reported for admin.");
}
 
header( "Location: /codes/index.php?successful_flagging");

?>
