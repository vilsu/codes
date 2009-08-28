<?php 
    echo (" <form id='ask_form' method='post' onsubmit='javascript:notEmpty()'" 
        . "action='./handlers/receive_new_question.php"
        . "'>"
    );
?>

<fieldset>
    <label for="title">Title</label>
        <input name="question[title]" type="text" cols="92" class='title' id="required" />

    <label for="question">Question</label>
        <div class="resizable-textarea">
            <textarea id="input" class="textarea" id="required" tabindex="101" rows="15" cols="92" name="question[body]"></textarea>
        </div>

    <label for="tags">Tags</label>
        <input name='question[tags]' type="text" cols="92" class='tags' id="required" />
        <div id="notice"><p>
        Please, use at least one tag and maximum five tags. Separate them by commas (,).
        </p></div>
</fieldset>

<?php 
    if( $_SESSION['login']['logged_in'] ) {

        echo ("<input class='ask_question' onclick='checkFields();' type='submit' value='Ask Your Question' /></form>");
    } else {
        echo ("</form>");
    }
?>
