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
        "SELECT question_id, tag
        FROM tags
        WHERE question_id IN 
            ( SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
            );"
    );
    $result_tags = pg_execute( $dbconn, "query9", array());




    // First compile the Data

    // Go through each question

    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        echo ("<div class='question_summary'>"/*{{{*/
        // TITLE
                    . "<h3>"
                        . "<a class='question_hyperlink' href='?"
                            . "question_id=" 
                            . $titles_and_Qid['question_id']  // for computer
//                            . "&" 
//                            . $titles_and_Qid['title']  // for reader
                            . "'>" 
                                . $titles_and_Qid['title'] 
                        . "</a>"
                    . "</h3>"
            );
/*}}}*/


        // Go through each Tag
        while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
            // Add the Tag to an array of tags for that question
            $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];
        }

        echo ("\n\nHUOM! ");
        echo $tags_and_id[1]['tag'][0];

        $i = 0;
        // Then Loop Through each question
        foreach( $end_array as $tags_and_Qid['question_id'] => $tags_and_Qid['tag'] )
        {

        echo ("\n\nITERATION NUMBER IS " . $i);

        // Create the starting HTML
        echo ("<div class='tags'>");
            // Go through each tag

        // TODO bug: invalid argument supplied for foreach()
                foreach( $end_array[$tags_and_Qid['question_id']] ['tag'] as $tag )
                {/*{{{*/
                    echo ( "<a class='post_tag' href='?tag="
                    . $tag
                    . "'>"
                        . $tag
                    . "</a>"
                    );
                }
        // end the html
            echo '</div>';/*}}}*/
        $i++; 
        }
        echo ("</div>");
    }
}

?>
