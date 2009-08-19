<?php

// Functions

// Create all the parts of a question.
function create_question( 
    $title, 
    $tags, 
    $question_id, 
    //user infos
    $user_id,
    $username, 
    $was_sent_at_time,
    // question or answer
    $describtion
)
{
    //organize_questions ( $tab, $end_array );
    echo ("<div class='question_summary'>");
        create_title($title, $question_id);
        create_tags($tags);
        create_user_info_box_question( $user_id, $username, $was_sent_at_time, $describtion );
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
                    . "&"
                    . $title  // for reader
                . "'>"
                    . $title
            . "</a>"
        . "</h3>"
    );
}

function create_user_info_box_question( $user_id, $username, $was_sent_at_time, $describtion ) {
    echo ("<div id='user_info_box'>"
        . "<div id='user_info_time'>"
            . $describtion . " " . $was_sent_at_time
        . "</div>"
        . "<div id='user_in_user_box'>"
            . "<a href=index.php?username="
                . $username
                . ">"
                . $username
                . "</a>"
            . "</div>"
        . "</div>"
    );
}


//function organize_questions ( $tab, $end_array ) {
//    if ( $_GET['tab'] == 'newest' ) {
//        echo ( "array_reverse (" . $end_array . ",  true )" );
//    }
//    if ( $_GET['tab'] == 'oldest' ) {
//        echo ( $end_array );
//    } else {
//        echo ( "array_reverse (" . $end_array . ",  true )" );
//    }
//}
//

function create_tab_box_question( ) {
    echo ( "<div id='subheader'>"
                . "<div id='tabs'>"
                    . "<a href='?tab=newest'>newest</a>"
                    . "<a href='?tab=oldest'>oldest</a>"
                . "</div>"
        . "</div>"
    );
}

function create_tab_box_thread( ) {
    echo ( "<div id='tabs'>"
                    . "<a href='?sort=newest'>newest</a>"
                    . "<a href='?sort=oldest'>oldest</a>"
            .  "</div>"
    );
}



?>
