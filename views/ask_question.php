<?php
// ASK QUESTION -view
// to use SESSIONS
if (isset($_REQUEST['ask_question'])) {
    // change the layout by adding question form by getting data from 
    // lomakkeet/lomake_ask_question.php
    include './lomakkeet/lomake_ask_question.php';

    // LOGIN at the bottom of Ask_question
    // to use SESSIONS
    if (!isset($_SESSION['login']['logged_in'])) {
        // change the layout by adding question form by getting data
        echo "<div id='notice'>";
        echo "<p>Ole kirjautuneena, niin voit kysya.</p>";
        include 'lomake_login.php';
        echo "</div>";
    } else {
            echo "<input type='submit' value='Ask Your Quostion' /></form>";
    }
}

?>
