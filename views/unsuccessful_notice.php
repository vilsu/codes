<div class="unsuccessful">
<?php
// UNSUCCESSFUL LOGIN
if (array_key_exists('unsuccessful_login', $_REQUEST)) {
    echo ("Unsuccessful login. Please try again.");
}


// UNSUCCESSFUL REGISTRARATION: wrong email
if (array_key_exists('registration_wrong_email', $_REQUEST)) {
    echo ("Unsuccessful registration. Wrong email address.");
}
// UNSUCCESSFUL REGISTRARATION: 2 accounts for one email
if (array_key_exists('2email', $_REQUEST)) {
    echo ("Unsuccessful login. You already have an accout.
           Please, use Login.");
}


// UNSUCCESSFUL random bugs
if (array_key_exists('unsuccessful', $_REQUEST)) {
    echo ("This is an unknown bug. Please, report it to the moderator."); 
}
?>
</p>
</div>
