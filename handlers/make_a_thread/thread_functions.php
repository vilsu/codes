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
    echo ("<div class='one_answer'>"
            . $answer
        . "</div>"
    );
}

// organize answers according inside a question
function create_tab_box_thread( $question_id ) {
    echo ( "<div id='tabs'>"
        . "<a href='?sort=newest"
            . "&"
            . "question_id="
            . $question_id 
            . "'>newest</a>" 
        );
    echo ( "<a href='?sort=oldest"
        . "&"
        . "question_id="
            . $question_id 
        . "'>oldest</a>"
        . "</div>"
    );
}

function create_moderator_box_for_a_question ( $question_id ) {
    echo ("<div class='post_menu'>");
    if ( $_SESSION['login']['a_moderator'] == true ) {
        echo ("<a href='#' class='delete_question'" 
            . " question_id='" . $question_id . "'"
            . " title='vote to remove this post'>delete</a>"
            . "<span class='link_separator'>|</span>"
            );
        echo ("<a href='#'"
            . "class='flag_question'"
            . " question_id='" . $question_id . "'"
            . " title='flag this post for serious problems'>flag</a>"
        );
    echo ("</div>");
    }
}

?>
