<?php 
    echo ("<form method='post'" 
        . "action='/codes/handlers/handle_registration.php"
        . "'>"
    );
?>

    <label for="display-name">Name</label>
        <input name="login[username]" type="text" cols="92" />

    <label for="email">Email</label>
        <input name="login[email]" type="text" cols="92" />

    <label for="password">Password</label>
        <input name="password" type="password" cols="92" />

    <input type="submit" value="Register and Login" />
</form>
