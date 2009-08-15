<form method="post" action="handlers/handler_question.php">
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
        if(!$logged_in) {
            <div id="login">
                    include 'handlers/handler_logged_in_menu.php'; 
            </div>

        if($logged_in) {
            <input type="submit" value="OK" />
        }
        else {
            // late TODO bind AJAX to this like in SO if you have time
            echo "Please, login or register first";
        }
    ?>
</form>
