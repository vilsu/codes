<?php

// This fetches the question and its answers to a thread
// according to the $_GET['question_id'].

function get_raw_data_list () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to get title and body of the question
    $result = pg_query_params ( $dbconn,
        "SELECT q.title, q.body, u.username, q.was_sent_at_time, u.user_id
        FROM questions q
        LEFT JOIN users u ON q.user_id = u.user_id
        WHERE question_id = $1",
        // array( $_GET['question_id'] ) 
        array( get_question_id () ) 
    );
    return $result;
}

function get_question_id () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    if ( !( empty ( $_GET['question_id'] ) ) ) {
        $question_id = $_GET['question_id'];
    }
    else if ( empty ( $_GET['question_id'] ) ) {
            $pattern = '/question_id=([^&#]*)/';
            $subject = $_SERVER['HTTP_REFERER'];
            $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  // extract query from URL
            parse_str($query, $params);
            $question_id = explode( "=", $query );
            $question_id = $question_id[1];
    }
    return $question_id;
}



function get_tag_list () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $question_id = get_question_id ();

    // to get the tags of the question
    $result_tags = pg_query_params ( $dbconn,
        "SELECT tag
        FROM tags
        WHERE question_id = $1",
        array( $question_id ) 
    );
    $tags_array = pg_fetch_all ( $result_tags );

    return $tags_array;
}

function create_headings () {
    $question_id = get_question_id ();
    $title = get_title ();

    echo ("<div id='top_header_main'>");
    // To print the header of the question
    create_question_title( $title, $question_id );
    echo ("</div>");        // to end question_title block
}

function get_username () {
    $raw_data = get_raw_data_list();
    while ( $question = pg_fetch_array( $raw_data ) ) {
        $username = $question['username'];
    }
    return $username;
}

function get_user_id () {
    $raw_data = get_raw_data_list();
    while ( $question = pg_fetch_array( $raw_data ) ) {
        $user_id = $question['user_id'];
    }
    return $user_id;
}

function get_body () {
    $raw_data = get_raw_data_list();
    while ( $question = pg_fetch_array( $raw_data ) ) {
        $body = $question['body'];
    }
    return $body;
}

function get_title () {
    $raw_data = get_raw_data_list ();
    while ( $question = pg_fetch_array ( $raw_data ) ) {
        $title = $question['title'];
    }
    return $title;
}

function create_body () {
    $body = get_body ();
    echo ("<div class='question_box'>"
        . "<div class='question_body'>"
        . "<div id='question_content'>"
        . $body
        . "</div>"
        . "</div>"
    );
}

function get_was_sent_at_time () {
    $raw_data = get_raw_data_list();

    while ( $question = pg_fetch_array( $raw_data ) ) {
        // Grab the was_sent_at_time for the question from the second array
        $was_sent_at_time_unformatted = $question['was_sent_at_time'];
        $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
        $was_sent_at_time = $was_sent_at_time_array[0];
    }
    return $was_sent_at_time;
}

function create_tag_list () {
    $tags_array = get_tag_list ();
    $raw_data = get_raw_data_list();

    echo ("<div id='tag_list'>");
    for ( $i = 0; $i < count( $tags_array ); $i++ ) {
        create_tags ( $tags_array[$i] );
    }
    echo ("</div>");
}

function create_bottom_bar () {
    $was_sent_at_time = get_was_sent_at_time();
    $user_id = get_user_id ();
    $username = get_username ();
    $question_id = get_question_id ();

    echo ("<div class='user_info_bottom_box'>");
    // print the user box for the question
    create_moderator_box_for_a_question ( $question_id, $user_id );
    create_user_info_box_question( $user_id, $username, $was_sent_at_time, "asked" );
    echo ("</div>");

    // to end the body of the question
    echo ("</div>");
}





function create_question_content () {
    create_headings ();
    create_body ();
    create_tag_list ();
    create_bottom_bar ();
}


// Let's fire!
create_question_content ();

?>
