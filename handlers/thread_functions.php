<?php

// Functions

// to create the title of the question
function create_question_title( $title, $question_id )
{
    echo ("<div id='mainheader'>"
        . "<h2>"
        . "<a href='index.php?"
            . "question_id="
            . $question_id
            . "&"  
            . $title . "'>" 
                . $title
        . "</a>"
        . "</h2>"
        . "</div>"
        );
}

// this may be buggy
function create_answer ( $answer ) {
    echo ("<div class='answer'>"
        . $answer
        . "</div>"
    );
}
