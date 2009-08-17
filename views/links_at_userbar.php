<div class="hlinks">
<ul>
    <?php
    if (!$_SESSION['login']['logged_in']) {
        echo "<li><a href='index.php?registration"
            . "'>Register</a></li>"
            ;
        echo "<li><a href='index.php?"
            . "login"
            . "'>Login</a></li>"
            ;
    }
    else {
        echo "<li>" 
            . $_SESSION['login']['email'] 
            . "</li>";
        echo "<li><a href='index.php?logout'>Logout</a></li>";
    }
    echo ("<li><a href='index.php?about"
        . "'>About</a></li>"
    );
    ?>
</ul>
</div>
