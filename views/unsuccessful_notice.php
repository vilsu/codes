<div class="unsuccessful">
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
    echo ("An error occurred in sending your question."); 
}


// UNSUCCESSFUL random bugs
if (array_key_exists('unsuccessful', $_GET)) {
    echo ("This is an unknown bug. Please, report it to the moderator."); 
}
?>
</p>
</div>
