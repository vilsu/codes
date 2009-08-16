<?php 
    echo ("<form method='post'" 
    . "action='./handlers/receive_answers.php'"
    . "'>"
    );
?>
    <p><h2>Your Answer:</h2>
        <div id="answer" class="resizable-textarea">
                <textarea id="input" class="textarea" tabindex="101" rows="15" cols="92" name="answer" /></textarea>
        </div>
    </p>

<!-- no form -tag, since it is at index.php -->
