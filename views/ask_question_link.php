<!-- to change the layout of the "Ask question" -button -->
<!-- default: 
            <div class="ask_question">
        active:  
            <div class="ask_question" id='ask_question_active'>
-->

<?php
    // to use SESSIONS
    if (isset($_REQUEST['email'])) {
        if(isset($_GET['ask_question'])) {
            echo  ("<li id='ask_question_active'><a href='?ask_question&amp;"
                .  htmlspecialchars(SID)   // SESSION
                . "&amp;"
//                . "email=" 
//                . $_GET['email'] 
                . "&amp;passhash_md5="
                . $_GET['passhash_md5'] 
                . "'>Ask question</a></li>
                ");

        }
        else {
            echo  ("<li><a href='?ask_question&amp;"
//            . "email=" .
//            . $_GET['email']
            . "&amp;passhash_md5="
            . $_GET['passhash_md5']
            . "'>Ask question</a></li>");

        }
    } else {
        echo "<li><a href='?ask_question'>Ask question</a></li>";
    }
?>
