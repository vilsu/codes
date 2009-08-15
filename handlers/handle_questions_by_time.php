<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

if( empty($_GET) ) {
    // to get titles and question_ids
    $result_titles_tags = pg_prepare( $dbconn, "query777", 
        "SELECT question_id, title
        FROM questions
        WHERE question_id IN
        ( 
            SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
        ) 
        ORDER BY was_sent_at_time
        DESC LIMIT 50;" 
    );

    $result_titles = pg_execute( $dbconn, "query777", array());



    // TAGS
    $result_tags = pg_prepare( $dbconn, "query9", 
        "SELECT questions_question_id, tag
        FROM tags
        WHERE questions_question_id IN 
            ( SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
            );"
    );
    $result_tags = pg_execute( $dbconn, "query9", array());


//    $result = pg_fetch_all( $result_tags );
//    var_dump( $result );


    // print the title of each question: title
    // to make the URL for each title: question_id, title
    //      index.php?question_id=777&title
    //                |               |--- for reader
    //                |------------------- for computer: lomake_question_answer.ph
    // LIST OF 50 QUESTIONS
    
    //$array = pg_fetch_row( $result_titles_tags, 0 );

//    var_dump( $result_tags );


//    require './handlers/handle_a_list_of_questions.php';





    while($row = pg_fetch_row( $result_titles )) {

        $question_id = $row[0];

        echo ("<div class='question_summary'>"
                . "<div class='summary'>"
        // TITLE
                    . "<h3>"
                        . "<a class='question_hyperlink' href='?"
                            . "question_id=" 
                            . $row[0]  // for computer
                            . "&" 
                            . $row[1]  // for reader
                            . "'>" 
                                . $row[1] 
                        . "</a>"
                    . "</h3>"
            );

        // TAGS
        echo ("Result tags are outside while ");
        print_r( $result_tags );

        echo ("<div class='tags'>");
        while( $row2 = pg_fetch_row( $result_tags )) {


            echo ("Result tags are inside while ");
            print_r( $result_tags );

            echo ("question_id on at 1st foreach " . $question_id);
            $end_array = array();
            foreach( $result_tags as $question_id => $data )
            {
                /* the first part of this creates an array key for the ID.
                Then we define a sub array that holds 'tags'.
                Finally, we add a new value to the array with the tag name.
                Because the brackets contain nothing, it means we  don't care
                about the key of the value. */
                $end_array[$question_id]['tags'][] = $data['tag'];
            }

            print_r($end_array);
            // Then You can access all the tags for question 1 through
            // We go through each tag of the question ID of $i and then echo it

            echo ("question_id on at 2nd foreach " . $question_id);
            foreach( $end_array[1]['tags'] as $tag )
            {
                echo ( "<a class='post_tag' href='?tag="
                . $tag
                . "'>"
                    . $tag
                . "</a>"
                );
            }

           // to access first tag
           var_dump( $end_array );
           
           echo ("End array on ");
           print_r( $end_array );
           echo ("Result tags are ");
           print_r( $result_tags );

           reset( $end_array );     // to return the pointer to the start
           echo $end_array[1]['tags'][0];
        }
        echo ("</div>");

        // Username
//        echo ("<div class='user_started'>"
//                . "<a href='?'>"
//                    . $row[3]
//                . "</a>"
//            . "</div>"
//            );

        echo ("</div>"
        . "</div>"
        );
    }
}

?>
