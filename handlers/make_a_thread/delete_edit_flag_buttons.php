<?php

function create_moderator_box_for_a_question ( $question_id, $user_id ) {
    echo ("<div class='post_menu'>");
    if ( check_authority_for_a_question ( $question_id, $user_id ) ) {
        echo ("<a href='#' class='delete_question'" 
            . " class='question_id'"
            . " rel='" . $question_id . "'"
            . " title='vote to remove this post'>delete</a>"
            . "<span class='link_separator'>|</span>"
        );
        // user can edit his answer
        echo ("<a href='?edit_question" . "&question_id=" . $question_id . "'"
            . " class='edit_question'"
            . " title='edit your question'>edit</a>"
            . "<span class='link_separator'>|</span>"
        );
        echo ("<a href='#'"
            . "class='flag_question'"
            . " rel='" . $question_id . "'"
            . " title='flag this post for serious problems'>flag</a>"
        );
    }
    else 
    {
        echo ("<a href='#'"
            . " class='flag_question'"
            . " rel='" . $question_id . "'"
            . " title='flag this post for serious problems'>flag</a>"
        );
    }
    echo ("</div>");
}


function create_moderator_box_for_an_answer ( $answer, $user_id ) {

    echo ("<div class='post_menu'>");
    echo ("<div class='answer_" . $answer . "'>");
    if ( check_authority_for_an_answer( $answer, $user_id ) ) {
        // user can delete his own answer
        echo ("<a href='#'"
            . "class='delete_answer'"
            . " rel='" . $answer . "'"
            . " title='delete your this answer'>delete</a>"
            . "<span class='link_separator'>|</span>"
        );
        // user can flag his own answer
        echo ("<a href='#'"
            . "class='flag_answer'"
            . " rel='" . $answer . "'"
            . " title='flag this answer for serious problems'>flag</a>"
        );
    }
    else
    {
        echo ("<a href='#'"
            . "class='flag_answer'"
            . " rel='" . $answer . "'"
            . " title='flag this answer for serious problems'>flag</a>"
        );
    }
    echo ("</div>");
    echo ("</div>");
}


?>
