<?php 

    /**
     * @brief    Sisaankirjautumislomake.
     * @file     lomake_login.php
     */


    echo (" <form method='post'" 
        . "action='/pgCodesS/handlers/handle_login_and_registration/receive_login_form.php"
        . "'>"
    );
?>
    <label for="email">Email</label>
        <input name="login[email]" type="text" cols="92" />

    <label for="password">Password</label>
        <input name="login[password]" type="password" cols="92" />

    <input type="submit" value="Login" />
</form>
