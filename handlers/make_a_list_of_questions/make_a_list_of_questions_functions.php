<?php

// Functions

// Create all the parts of a question in a list
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
    // to get the status of the question/*{{{*/
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $result = pg_query_params ( $dbconn,    
        "SELECT flagged_for_moderator_removal 
        FROM questions 
        WHERE question_id = $1",
        array ( $question_id ) 
    );

    while ( $row = pg_fetch_array ( $result ) ) {
        $flag_status = $row['flagged_for_moderator_removal'];
    }
/*}}}*/

    // to get the number of answers for the question
    $result = pg_query_params ( $dbconn,
        "SELECT count(answer)
        FROM answers
        WHERE question_id = $1",
        array ( $question_id ) );

    while ( $row = pg_fetch_array ( $result ) ) {
        $number_of_answers[$question_id]['count'] = $row['count'];
    }


    // to have opacity for flagged questions
    if ( $flag_status == 1 ) {
        echo ("<div class='question_summary' id='flagged_list'>");


            echo ( "<a id='no_underline' href='?question_id=" . $question_id . "'>");
                if ( $number_of_answers[$question_id]['count'] == 1 ) {
                    echo ( "<div id='answered'>"
                            . "<div id='answer_count'>" 
                                .  $number_of_answers[$question_id]['count']
                            . "</div>"
                            . "<div> answer</div>"
                        . "</div>" 
                    );
                }
                else if ( $number_of_answers[$question_id]['count'] > 1 ) {
                    echo ( "<div id='answered'>"
                            . "<div id='answer_count'>"
                                . $number_of_answers[$question_id]['count']
                            . "</div>"
                            . "<div> answers</div>"
                        . "</div>" 
                    );
                }
                if ( $number_of_answers[$question_id]['count'] == 0 ) {
                    echo ( "<div id='unanswered'>"
                            . "<div id='answer_count'>"
                                .  $number_of_answers[$question_id]['count']
                            . "</div>"
                            . "<div> answers</div>"
                        . "</div>" 
                    );
                }
            echo ("</a>");

                create_title( $title, $question_id );
                create_tags( $tags );
                create_user_info_box_question( 
                    $user_id,
                    $username, 
                    $was_sent_at_time, 
                    $describtion 
                );
        echo ("</div>");
    }
    else 
    {
        echo ("<div class='question_summary'>");
            echo ( "<a id='no_underline' href='?question_id=" . $question_id . "'>");
                if ( $number_of_answers[$question_id]['count'] == 1 ) {
                    echo ( "<div id='answered'>"
                            . "<div id='answer_count'>" 
                                .  $number_of_answers[$question_id]['count']
                            . "</div>"
                            . "<div> answer</div>"
                        . "</div>" 
                    );
                }
                else if ( $number_of_answers[$question_id]['count'] > 1 ) {
                    echo ( "<div id='answered'>"
                            . "<div id='answer_count'>"
                                . $number_of_answers[$question_id]['count']
                            . "</div>"
                            . "<div> answers</div>"
                        . "</div>" 
                    );
                }
                if ( $number_of_answers[$question_id]['count'] == 0 ) {
                    echo ( "<div id='unanswered'>"
                            . "<div id='answer_count'>"
                                .  $number_of_answers[$question_id]['count']
                            . "</div>"
                            . "<div> answers</div>"
                        . "</div>" 
                    );
                }
            echo ("</a>");

            create_title( $title, $question_id );
            create_tags( $tags );
            create_user_info_box_question( 
                $user_id,
                $username, 
                $was_sent_at_time, 
                $describtion 
            );
        echo ("</div>");
    }
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

function organize_questions (
    $end_array, 
    $tags_and_Qid,
    $titles_and_Qid,
    $titles,
    $was_sent_at_times,
    $usernames,
    $user_ids )
{
    foreach( $end_array as $tags_and_Qid['question_id'] => $titles_and_Qid['title'] )
        {
            // $title should be the actual string, not an array
            // $tags should be single, non-multidimensional array containing tag names

            // Grab the title 
            $title = $titles [ $tags_and_Qid['question_id'] ] ['title'];

            // Grab the tags for the question 
            $tags = $end_array [ $tags_and_Qid['question_id'] ] ['tag'];

            // Grab the username for the question 
            $username = $usernames [ $tags_and_Qid['question_id'] ] ['username'];

            // Grab the user_id for the question 
            $user_id = $user_ids [ $tags_and_Qid['question_id'] ] ['user_id'];

            // Grab the was_sent_at_time for the question
            $was_sent_at_time_unformatted = $was_sent_at_times [ $tags_and_Qid['question_id'] ] ['was_sent_at_time'];
            $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
            $was_sent_at_time = $was_sent_at_time_array[0];

            // Grap the question_id
            $question_id = $tags_and_Qid['question_id'];

            create_question( 
                $title, 
                $tags, 
                $question_id, 
                $user_id,            // to have spaces in user-names
                $username, 
                $was_sent_at_time, 
                "asked"
            );
        }
}


?>
