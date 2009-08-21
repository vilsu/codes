<?php 
    echo ("<form method='post'" 
    . "action='./handlers/receive_answers.php'"
    . "'>"
    );
?>
    <h2>Your Answer:</h2>
        <div id="answer" class="resizable-textarea">
                <textarea id="input" class="textarea" tabindex="101" rows="15" cols="92" name="answer" /></textarea>
        </div>
<?php 
    if( $_SESSION['login']['logged_in'] ) {
        echo ("<input type='submit' value='Send Your Answer' /></form>");
    } else {
        echo ("</form>");
    }
?>
<!-- no form -tag, since it is at index.php -->
