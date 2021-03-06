<?php

/** 
 * @file    flag_question.php
 *
 * @brief   Laheta email moderaattorille asiattomasta viestista.
 *
 * Tiedosto laukaisee jQuery funktion tiedostosta jQuery.php.
 */


function send_mail () {
	include ("/pgCodesS/Email/email.php");

	/**
         * $subject 	string
         * $question_id	integer
         * $headers	string
	 * $to		string
	 * $message	string 
	 */
	$subject = "Flagged question"; 
	$question_id = $_POST['question_id']; // to get data from jQuery.post
	$headers = 'MIME-Version: 1.0' . "\r\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 

	$to = '"Ville Tapsu" <ville.tapsu@gmail.com>';
	$message = "<a href='index.php?question_id=" . $question_id . "'>"
	    . "The question " . $question_id . "</a> is flagged by an user. Please, review it.";

	if ( mail( $to, $subject, $message, $headers, "-fville.tapsu@gmail.com" ) ) {
	}
}

/*
 * send the mail
 */
send_mail ();

?>
