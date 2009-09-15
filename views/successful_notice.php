<div class="successful">
<p>
<?php

/**
 * @brief   Tee onnistumisilmoitus
 * @file    successful_notice.php
 */



// SUCCESSFUL REGISTRARATION
if ( array_key_exists('successful_registration', $_GET)
AND !array_key_exists ( 'question_id', $_GET ) 
AND !array_key_exists ( 'ask_question', $_GET ) ) {
    echo ("Successful registration. You are now logged in too.");
}

// SUCCESSFUL LOGIN
if (array_key_exists('successful_login', $_GET)
AND !array_key_exists ( 'question_id', $_GET ) 
AND !array_key_exists ( 'ask_question', $_GET ) ) {
    echo ("Successful login");
}

// QUESTION SENT
if (array_key_exists('question_sent', $_GET)) {
    echo ("Question sent");
}

// ANSWER SENT
if (array_key_exists('answer_sent', $_GET)) {
    echo ("Answer sent");
}

// Question removed successfully 
if (array_key_exists('successful_question_removal', $_GET)) {
    echo ("Question removed.");
}



?>
</div>
