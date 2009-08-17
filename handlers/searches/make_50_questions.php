<?php

// Functions

// Create all the parts of a question.
function create_question($title, $tags)
{
    echo ("<div class='question_summary'>");
    create_title($title);
    create_tags($tags);
    echo ("</div>");
}

// Print the Title
function create_title($title)
{
    echo ("<h3>"
            . "<a class='question_hyperlink' href='?"
                . "question_id=" 
                . $titles_and_Qid['question_id']  // for computer
//                            . "&" 
//                            . $title  // for reader
                . "'>" 
                    . $title 
            . "</a>"
        . "</h3>"
    );
}

// Loop Through Each Tag and Print it
function create_tags($tags)
{
    echo ("<div class='tags'>");
    foreach($tags as $tag)
    {
        echo (
            "<a class='post_tag' href='?tag=" . $tag . "'>"
            . $tag . "</a>"
            );
    }
    echo ("</div>");
}

?>
