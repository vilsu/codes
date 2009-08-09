<form method="post" action="/handlers/handle_new_question.php">
    <p>Title:
        <input name="title" type="text" cols="92" />
    </p>
    <p>Question:
        <div class="resizable-textarea">
                <textarea id="input" class="textarea" tabindex="101" rows="15" cols="92" name="body" /></textarea>
        </div>
    </p>

    <p>Tags:
        <input name="tags" type="text" cols="92" />
    </p> 

    
    <?php
    include 'handle_login_status.php';
    if(!$logged_in) {
        echo "<div id='notice'>";
        echo "<p>Ole kirjautuneena, niin voit kysya.</p>";
        include 'lomake_login.php';
        echo "</div>";
    }
    else {
        echo "<input type='submit' value='OK' />";
    }
    ?>
    
</form>
