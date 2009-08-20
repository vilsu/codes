<?php

// Functions

// Create all the parts of a question in a list
function create_question( 
    $title,
    $tags,
    $question_id,
    //user infos
    $user_id,                  // not put in
    $username,
    $was_sent_at_time,
    // question or answer
    $describtion
)
{
    echo ("<div class='question_summary'>");
        create_title($title, $question_id);
        create_tags($tags);
        create_user_info_box_question( 
            $user_id,       // not put in
            $username, 
            $was_sent_at_time, 
            $describtion 
        );
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

// Print the Title for a list of questions
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
        . "</h3>"
    );
}

function create_user_info_box_question( 
    $user_id,    // not put in
    $username, 
    $was_sent_at_time, 
    $describtion 
) {
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

function organize_questions (
    $end_array, 
    $tags_and_Qid,
    $titles_and_Qid,
    $titles,
    $was_sent_at_times,
    $usernames )
{
    foreach( $end_array as $tags_and_Qid['question_id'] => $titles_and_Qid['title'] )
        {
            // $title should be the actual string, not an array
            // $tags should be single, non-multidimensional array containing tag names

            // Grab the title for the first array
            $title = $titles [ $tags_and_Qid['question_id'] ] ['title'];

            // Grab the tags for the question from the second array
            $tags = $end_array [ $tags_and_Qid['question_id'] ] ['tag'];

            // Grab the username for the question from the second array
            $username = $usernames [ $tags_and_Qid['question_id'] ] ['username'];

            // Grab the was_sent_at_time for the question from the second array
            $was_sent_at_time_unformatted = $was_sent_at_times [ $tags_and_Qid['question_id'] ] ['was_sent_at_time'];
            $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
            $was_sent_at_time = $was_sent_at_time_array[0];

            // Grap the question_id
            $question_id = $tags_and_Qid['question_id'];

            create_question( 
                $title, 
                $tags, 
                $question_id, 
                $user_id,            // not put in
                $username, 
                $was_sent_at_time, 
                "asked"
            );
        }
}


?>
