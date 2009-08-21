<?php 
    echo (" <form method='post'" 
        . "action='./handlers/receive_new_question.php"
        . "'>"
    );
?>

    <label for="title">Title</label>
        <input name="question[title]" type="text" cols="92" />

    <label for="your-question">Question</label>
        <div class="resizable-textarea">
                <textarea id="input" class="textarea" tabindex="101" rows="15" cols="92" name="question[body]"></textarea>
        </div>

    <label for="tags">Tags</label>
        <input name='question[tags]' type="text" cols="92" />
    <div id="notice">Please, use at least one tag and separate them by commas (,).</div>

<?php 
    if( $_SESSION['login']['logged_in'] ) {
        echo ("<input type='submit' value='Ask Your Question' /></form>");
    } else {
        echo ("</form>");
    }
?>
