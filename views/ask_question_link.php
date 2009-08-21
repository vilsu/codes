<!-- to change the layout of the "Ask question" -button -->

<?php
    // to use SESSIONS
    if (isset($_REQUEST['email'])) {
        if(isset($_REQUEST['ask_question'])) {
            echo  ("<li id='ask_question_active'><a href='?"
                . "ask_question&amp;"
                . "&amp;passhash_md5="
                . $_REQUEST['passhash_md5'] 
                . "'>Ask question</a></li>
                ");

        }
        else {
            echo  ("<li><a href='?ask_question&amp;"
            . "&amp;passhash_md5="
            . $_REQUEST['passhash_md5']
            . "'>Ask question</a></li>");

        }
    } else {
        echo "<li><a href='?ask_question"
            . "'>Ask question</a></li>"
            ;
    }
?>
