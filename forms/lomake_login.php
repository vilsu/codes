<?php 
    echo (" <form method='post'" 
        . "action='./handlers/handle_login_form.php"
        . "'>"
    );
?>
    <p>Email:
        <input name="login[email]" type="text" cols="92" />
    </p>

    <p>Password:
        <input name="login[password]" type="password" cols="92" />
    </p> 

    <input type="submit" value="Login" />
</form>
