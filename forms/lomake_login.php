<?php 
    echo (" <form method='post'" 
        . "action='./handlers/searches/handle_questions_by_tag.php"
        . "'>"
    );
?>
    <label for="email">Email</label>
        <input name="email" type="text" cols="92" />

    <label for="password">Password</label>
        <input name="password" type="text" cols="92" />

    <input type="submit" value="Login" />
</form>
