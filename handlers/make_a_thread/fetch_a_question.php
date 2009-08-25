<?php

// This fetches the question and its answers to a thread
// according to the $_GET['question_id'].

function get_raw_data_list ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to get title and body of the question
    $result = pg_query_params ( $dbconn,
        "SELECT q.title, q.body, u.username, q.was_sent_at_time, u.user_id
        FROM questions q
        LEFT JOIN users u ON q.user_id = u.user_id
        WHERE question_id = $1",
        // array( $_GET['question_id'] ) 
        array( $question_id ) 
    );
    return $result;
}

function get_question_id_for_question () {
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



function get_tag_list ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

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

function create_headings ( $question_id ) {
    $title = get_title ( $question_id );

    echo ("<div id='top_header_main'>");
    // To print the header of the question
    create_question_title( $title, $question_id );
    echo ("</div>");        // to end question_title block
}

function get_username ( $question_id ) {
    $raw_data = get_raw_data_list( $question_id );
    while ( $question = pg_fetch_array( $raw_data ) ) {
        $username = $question['username'];
    }
    return $username;
}

function get_user_id ( $question_id ) {
    $raw_data = get_raw_data_list( $question_id );
    while ( $question = pg_fetch_array( $raw_data ) ) {
        $user_id = $question['user_id'];
    }
    return $user_id;
}

function get_body ( $question_id ) {
    $raw_data = get_raw_data_list( $question_id );
    while ( $question = pg_fetch_array( $raw_data ) ) {
        $body = $question['body'];
    }
    $body = preg_replace('/\n\s*\n/', "<br />\n<br />\n", htmlentities( $body ) );
    return $body;
}

function get_title ( $question_id ) {
    $raw_data = get_raw_data_list ( $question_id );
    while ( $question = pg_fetch_array ( $raw_data ) ) {
        $title = $question['title'];
    }
    return $title;
}

function create_body ( $question_id ) {
    $body = get_body ( $question_id );
    echo ("<div class='question_box'>"
        . "<div class='question_body'>"
        . "<div id='question_content'>"
        . $body
        . "</div>"
        . "</div>"
    );
}

function get_was_sent_at_time ( $question_id ) {
    $raw_data = get_raw_data_list( $question_id );

    while ( $question = pg_fetch_array( $raw_data ) ) {
        // Grab the was_sent_at_time for the question from the second array
        $was_sent_at_time_unformatted = $question['was_sent_at_time'];
        $was_sent_at_time_array = explode( " ", $was_sent_at_time_unformatted, 4 );
        $was_sent_at_time = $was_sent_at_time_array[0];
    }
    return $was_sent_at_time;
}

function create_tag_list ( $question_id ) {
    $tags_array = get_tag_list ( $question_id );
    $raw_data = get_raw_data_list( $question_id );

    echo ("<div id='tag_list'>");
    for ( $i = 0; $i < count( $tags_array ); $i++ ) {
        create_tags ( $tags_array[$i] );
    }
    echo ("</div>");
}

function create_bottom_bar ( $question_id ) {
    $was_sent_at_time = get_was_sent_at_time( $question_id );
    $user_id = get_user_id ( $question_id );
    $username = get_username ( $question_id );

    echo ("<div class='user_info_bottom_box'>");
    // print the user box for the question
    create_moderator_box_for_a_question ( $question_id, $user_id );
    create_user_info_box_question( $user_id, $username, $was_sent_at_time, "asked" );
    echo ("</div>");

    // to end the body of the question
    echo ("</div>");
}





function create_question_content ( $question_id ) {
    create_headings ( $question_id );
    create_body ( $question_id );
    create_tag_list ( $question_id );
    create_bottom_bar ( $question_id );
}


// Let's fire!
create_question_content ( get_question_id_for_question () );

?>
