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

// organize answers according inside a question
function create_tab_box_thread( ) {
    echo ( "<div id='tabs'>"
            . "<a href='?sort=newest'>newest</a>"
            . "<a href='?sort=oldest'>oldest</a>"
        .  "</div>"
    );
}

?>
