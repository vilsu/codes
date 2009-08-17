<?php 
    echo (" <form method='post'" 
        . "action='./handlers/searches/handle_questions_by_tag.php"
        . "'>"
    );
?>
    <p>Email
        <input name="email" type="text" cols="92" />
    </p> 

    <p>Password
        <input name="password" type="text" cols="92" />
    </p> 

    <input type="submit" value="Login" />
</form>
