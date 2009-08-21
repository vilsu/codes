<?php

// Organizing functions

// list of questions at the homepage
function create_tab_box_question( ) {
        echo ( "<div id='tabs'>"
                    . "<a href='?tab=newest'>newest</a>"
                    . "<a href='?tab=oldest'>oldest</a>"
                . "</div>"
            );
}

// list of questions by the given tag or username
function create_tab_box_question_tags( $tag ) {
        echo ( "<div id='tabs'>"
            . "<a href='?tab_tag=newest"
            . "&tag="
            . $tag
            . "'>newest</a>"
            . "<a href='?tab_tag=oldest"
                . "&tag="
                . $tag
            . "'>oldest</a>"
            . "</div>"
        );
} 

// list of questions by the given tag or username
function create_tab_box_question_usernames ( $username ) {
        echo ( "<div id='tabs'>"
            . "<a href='?tab_user=newest"
            . "&username="
            . $username
            . "'>newest</a>"
            . "<a href='?tab_user=oldest"
                . "&username="
                . $username
            . "'>oldest</a>"
            . "</div>"
        );
} 




?>
