<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

if( empty($_GET) ) {
    // QUESTION IDs

    
    $result_titles_tags = pg_prepare( $dbconn, "query777", 
        "SELECT questions.title, questions.question_id, tags.tag
        FROM questions
        LEFT JOIN tags
        ON questions.question_id in 
        ( 
            SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
        ) 
        ORDER BY was_sent_at_time
        DESC LIMIT 50;" );

    $result_titles_tags = pg_execute( $dbconn, "query777", array());

    $result = pg_fetch_all( $result_titles_tags );
    var_dump( $result );
    $echo "\n---\n";

//    // to get titles_id from the db by the question ids 
//    $result_titles = pg_prepare( $dbconn, "query8", "SELECT title 
//        FROM questions
//        WHERE question_id in ( SELECT question_id
//            FROM questions
//            ORDER BY was_sent_at_time
//            DESC LIMIT 50
//            ) 
//        ORDER BY was_sent_at_time 
//        DESC LIMIT 50;"
//    );
//    $result_titles = pg_execute( $dbconn, "query8", array());
//
//    // TAGS
//    $result_tags = pg_prepare( $dbconn, "query9", "SELECT tag
//        FROM tags
//        WHERE questions_question_id in (SELECT question_id
//            FROM questions
//            ORDER BY was_sent_at_time
//            DESC LIMIT 50
//        )  
//    ;");
//    $result_tags = pg_execute( $dbconn, "query9", array());


    // print the title of each question: title
    // to make the URL for each title: question_id, title
    //      index.php?question_id=777&title
    //                |               |--- for reader
    //                |------------------- for computer: lomake_question_answer.ph
    // LIST OF 50 QUESTIONS
    
    $array = pg_fetch_all_columns($result_titles_tags, 1);

    var_dump($array);

}

?>
