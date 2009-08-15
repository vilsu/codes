<?php 
    echo ("<form method='post'" 
    . "action='/codes/handlers/handle_a_thread.php'"
    . "'>"
    );
?>
    <p>Answer:
        <div id="answer" class="resizable-textarea">
                <textarea id="input" class="textarea" tabindex="101" rows="15" cols="92" name="answer" /></textarea>
        </div>
    </p>
    <input type="submit" value="OK" />
</form>
