<?php 

    /**
     * @brief    Rekisterointilomake.
     * @file     lomake_registration.php
     */


    echo ("<form method='post'" 
        . "action='/codes/handlers/handle_login_and_registration/receive_registration_form.php"
        . "'>"
    );
?>

    <label for="display-name">Name</label>
        <input name="login[username]" type="text" cols="92" />

    <label for="email">Email</label>
        <input name="login[email]" type="text" cols="92" />

    <label for="password">Password</label>
        <input name="login[password]" type="password" cols="92" />
    <div id='notice'> Your password must be at least 6 characters. </div>

    <input type="submit" value="Register and Login" />
</form>
