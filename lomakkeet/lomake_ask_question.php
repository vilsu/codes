<?php 
    echo (" <form method='post'" 
        . "action='./handlers/handle_new_question.php"
        . "'>"
    );
?>

    <p>Title:
        <input name="question[title]" type="text" cols="92" />
    </p>

    <p>Question:
        <div class="resizable-textarea">
                <textarea id="input" class="textarea" tabindex="101" rows="15" cols="92" name="question[body]"></textarea>
        </div>
    </p>

    <p>Tags:
        <input name='question[tags]' type="text" cols="92" />
    </p> 
<!-- no form -tag, since it is at index.php -->
