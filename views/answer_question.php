<?php
// ASK QUESTION -view
if (isset($_GET['question_id']) ) {
    // LOGIN at the bottom
    if (!isset($_SESSION['login']['logged_in'])) {
        // change the layout by adding question form by getting data
        echo "<div id='notice'>";
        echo "<p>Ole kirjautuneena, niin voit vastata.</p>";
        include 'lomake_login.php';
        echo "</div>";
    } else {
            echo "<input type='submit' value='Send Your Answer' /></form>";
    }
}

?>
