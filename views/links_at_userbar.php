<ul>
    <?php
    if (!array_key_exists('email', $_GET)) {
    //if(isset($_GET['email'])) {
        echo "<li><a href='index.php?registration'>Register</a></li>";
        echo "<li><a href='index.php?login'>Login</a></li>";
    }
    else {
        echo $_REQUEST['email'];
        echo "<li><a href='index.php?logout'>Logout</a></li>";
        //echo "'<li>' . $_GET['email'] . '</li>'";
    }

    // varmistetaan, etta URLiin jaa muuttujat, kun ollaan kirjautuneena
    // Always escape & by &amp;
    // to use SESSIONS
    //if (isset($_REQUEST['email'])) {
    //    echo  ("<li><a href='?about"
    //        . "&amp;"
    //        . "email=" .    
    //        . $_GET['email']
    //        . "&amp;passhash_md5="
    //        . $_GET['passhash_md5']
    //       . "'>About</a></li>");
    // } else {
        echo "<li><a href='index.php?about'>About</a></li>";
    //}
    ?>
</ul>
