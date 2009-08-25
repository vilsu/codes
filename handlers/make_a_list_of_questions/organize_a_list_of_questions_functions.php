<?php

// Organizing functions

// list of questions at the homepage
function create_tab_box_question( ) {
    echo ( "<div id='tabs'>");
    if ( $_GET['tab'] == 'newest'
        OR !( $_GET['tab'] == 'oldest' ) ) {
            echo ("<span id='active_button'>"
                . "<a name='newest' href='?tab=newest#newest'>newest</a>"
                . "</span>"
                . "<a name='oldest' href='?tab=oldest#oldest'>oldest</a>"
            );
        }
    if ( $_GET['tab'] == 'oldest' ) {
        echo ("<a name='newest' href='?tab=newest#newest'>newest</a>"
            . "<span id='active_button'>"
            . "<a name='oldest' href='?tab=oldest'#oldest>oldest</a>"
            . "</span>"
        );
    }
    echo ("</div>");
}

// list of questions by the given tag or username
function create_tab_box_question_tags( $tag ) {
    echo ( "<div id='tabs'>");
    if ( ( $_GET['tab_tag'] == 'newest' )
        OR !( $_GET['tab_tag'] == 'oldest' ) ) {
            echo ("<span id='active_button'>"
                . "<a name='newest' href='?tab_tag=newest#newest"
                . "&tag="
                . $tag
                . "'>newest</a>"
                . "</span>"
                . "<a name='oldest' href='?tab_tag=oldest#oldest"
                . "&tag="
                . $tag
                . "'>oldest</a>"
            );
        }
    if ( $_GET['tab_tag'] == 'oldest' ) {
        echo ("<a name='newest' href='?tab_tag=newest#newest"
            . "&tag="
            . $tag
            . "'>newest</a>"
            . "<span id='active_button'>"
            . "<a name='oldest' href='?tab_tag=oldest#oldest"
            . "&tag="
            . $tag
            . "'>oldest</a>"
            . "</span>"
        );
    } 
    echo ("</div>");
}

// list of questions by the given tag or username
function create_tab_box_question_usernames ( $username ) {
    echo ( "<div id='tabs'>" );
    if ( ( $_GET['tab_user'] == 'newest' )
        OR !( $_GET['tab_user'] == 'oldest' ) ) {
            echo ("<span id='active_button'>"
                . "<a name='newest' href='?tab_user=newest"
                . "&username="
                . $username
                . "#newest'>newest</a>"
                . "</span>"
                . "<a name='oldest' href='?tab_user=oldest"
                . "&username="
                . $username
                . "#oldest'>oldest</a>"
                . "</div>"
            );
        }
    if ( $_GET['tab_user'] == 'oldest' ) {
        echo ("<a name='newest' href='?tab_user=newest"
            . "&username="
            . $username
            . "#newest'>newest</a>"
            . "<span id='active_button'>"
            . "<a name='oldest' href='?tab_user=oldest"
            . "&username="
            . $username
            . "#oldest'>oldest</a>"
            . "</span>"
        );
    } 
    echo ("</div>");
}




?>
