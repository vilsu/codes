<?php

/**
 * @brief   Tee lista kysymyksista erikoisominaisuuksineen
 * @file    make_a_list_of_questions_functions.php
 */



/** Ota vastausten lukum\"{a}\"{a}
 * @param integer $question_id
 * @param array $number_of_answers
 * @return integer
 */
function get_answer_count ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to get the number of answers for the question
    $result = pg_query_params ( $dbconn,
        'SELECT count(answer)
        FROM answers
        WHERE question_id = $1',
        array ( $question_id ) 
    );

    while ( $row = pg_fetch_array ( $result ) ) {
        $number_of_answers[$question_id]['count'] = $row['count'];
    }
    return $number_of_answers;
}

/** Luo HTML vastausten lukum\"{a}\"{a}r\"{a}lle
 * @param integer $question_id
 * @param array $number_of_answers
 */

function create_question_count_box ( $question_id ) {
    $number_of_answers = get_answer_count ( $question_id );

    echo ("<div class='question_summary'>");
    echo ( "<a class='username_box' id='no_underline' href='?question_id=" . $question_id . "'>");
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
}

/** Luo HTML kysymykselle
 * @param string $title
 * @param array $tags
 * @param integer $question_id
 * @param integer $user_id
 * @param string $username
 * @param string $was_sent_at_time
 * @param string $describtion
 */
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

    create_question_count_box ( $question_id );

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

/** Luo HTML otsikolle kysymyslistassa
 * @param string $title
 * @param integer $question_id
 */
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

/** J\"{a}rjest\"{a} kysymykset ajan mukaan
 * @param array $end_array
 * @param array $tags_and_Qid
 * @param array $titles_and_Qid
 * @param array $titles
 * @param array $was_sent_at_times
 * @param array $usernames
 * @param array $user_ids
 */
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
