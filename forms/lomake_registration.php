<?php 
    echo ("<form method='post'" 
        . "action='/codes/handlers/handle_registration.php"
        . "'>"
    );
?>

    <p>Username:
        <input name="login[username]" type="text" cols="92" />
    </p>

    <p>Email:
        <input name="login[email]" type="text" cols="92" />
    </p>

    <p>Password:
        <input name="password" type="password" cols="92" />
    </p>

    <input type="submit" value="OK" />
</form>
