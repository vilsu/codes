<?php

// Functions

// Create all the parts of a question.
function create_question($title, $tags, $question_id)
{
    echo ("<div class='question_summary'>");
    create_title($title, $question_id);
    create_tags($tags);
    echo ("</div>");
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

// Functions which need database connection

// Print the Title
function create_title($title, $question_id)
{
    echo ("<h3>"
            . "<a class='question_hyperlink' href='?"
                . "question_id=" 
                . $question_id
//                            . "&" 
// TODO bugaa kysymysten lahettaminen                           . $title  // for reader
                . "'>" 
                    . $title 
            . "</a>"
        . "</h3>"
    );
}
?>
