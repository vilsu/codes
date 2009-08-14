<div class="successful">
<p>
<?php
// SUCCESSFUL REGISTRARATION
if (array_key_exists('successful_registration', $_REQUEST)) {
    echo ("Successful registration. You are now logged in too.");
}

// SUCCESSFUL LOGIN
if (array_key_exists('successful_login', $_REQUEST)) {
    echo ("Successful login");
}

// QUESTION SENT
if (array_key_exists('question_sent', $_REQUEST)) {
    echo ("Question sent");
}
?>
</div>
