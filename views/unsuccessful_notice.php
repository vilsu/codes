<div class="unsuccessful">
<p>
<?php
// UNSUCCESSFUL LOGIN
if (array_key_exists('unsuccessful_login', $_GET)) {
    echo ("Unsuccessful login. Please try again.");
}


// UNSUCCESSFUL REGISTRARATION: wrong email
if (array_key_exists('registration_wrong_email', $_GET)) {
    echo ("Unsuccessful registration. Wrong email address.");
}
// UNSUCCESSFUL REGISTRARATION: 2 accounts for one email
if (array_key_exists('2email', $_GET)) {
    echo ("Unsuccessful login. You already have an accout.
           Please, use Login.");
}

// UNSUCCESSFUL question sent 
if (array_key_exists('unsuccessful_new_question', $_GET)) {
    echo ("Please, use at least one tag and maximum 5 tags."); 
}


// ANSWER NOT SENT
if (array_key_exists('answer_not_sent', $_GET)) {
    echo ("Your answer was sent unsuccessfully.
        Please try again later.");
}


// UNSUCCESSFUL random bugs
if (array_key_exists('unsuccessful', $_GET)) {
    echo ("This is an unknown bug. Please, report it to the moderator."); 
}

// NO question found
if (array_key_exists('no_question_found', $_GET)) {
    echo ( "<p>No question found.</p>" ); 
}

// Too short Password
if ( array_key_exists ('too_short_password', $_GET ) ) {
    echo ( "Too short password. At least 6 characters." );
}

// Too long title in asking question
if ( array_key_exists ('too_long_title', $_GET ) ) {
    echo ( "Too long title. Maximun 200 characters." );
}

// No tag supplied in asking question
if ( array_key_exists ('no_tag', $_GET ) ) {
    echo ( "No tag supplied for the question." );
}

// Unsuccessful question removal
if ( array_key_exists ( 'unsuccessful_question_removal', $_GET ) ) {
    echo ( "Question was removed." );
}

// duplicate email addresses
if ( array_key_exists ( 'unsuccessful_registration', $_GET ) ) {
    echo ("Unsuccessful registration."
        . " Your password must have 6 characters. 
        Email must be unique and without special characters similarly as username too."
    );
}

?>
</p>
</div>
