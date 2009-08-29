<?php

include ("/handlers/Email/email.php");

$subject = "Flagged answer"; 
$answer_id = $_POST['answer_id']; // to get data from jQuery.post
$headers = 'MIME-Version: 1.0' . "\r\n"; 
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

$to = '"Ville Tapsu" <ville.tapsu@gmail.com>';
$message = "<a href='index.php?answer_id=" . $answer_id . "'>"
    . "The answer " . $answer_id . "</a> is flagged by an user. Please, review it.";

if ( mail( $to, $subject, $message, $headers, "-fville.tapsu@gmail.com" ) ) {
    echo ("Thank you for your report!");
}

?>
