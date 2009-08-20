<?php

// Organizing functions

// list of questions at the homepage
function create_tab_box_question( ) {

    if ( isset ( $_GET['tag'] ) ) {
        echo ( "<div id='tabs'>"
            . "<a href='?tab=newest"
            . "&tag="
            . $_GET['tag']
            . "'>newest</a>"
            . "<a href='?tab=oldest"
                . "&tag="
                . $_GET['tag']
            . "'>oldest</a>"
            . "</div>"
        );
    } 
    else {
        echo ( "<div id='tabs'>"
                    . "<a href='?tab=newest'>newest</a>"
                    . "<a href='?tab=oldest'>oldest</a>"
                . "</div>"
            );
    }
}

// list of questions by the given tag or username
function create_tab_box_question_tags(
    $result_titles,
    $result_tags
) {
    if ( isset ( $_GET['tag'] ) ) {
        echo ( "<div id='tabs'>"
            . "<a href='?tab=newest"
            . "&tag="
            . $_GET['tag']
            . "'>newest</a>"
            . "<a href='?tab=oldest"
                . "&tag="
                . $_GET['tag']
            . "'>oldest</a>"
            . "</div>"
        );
    } 
    else {
        echo ( "<div id='tabs'>"
                    . "<a href='?tab=newest'>newest</a>"
                    . "<a href='?tab=oldest'>oldest</a>"
                . "</div>"
            );
    }
}

?>
