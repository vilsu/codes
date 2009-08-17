<?php
if(isset($_GET['tag'])) {
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    // to get titles and question_ids
    // When tag is given by the user
    $result_titles_tags = pg_prepare( $dbconn, "tag_search",
        "SELECT question_id, title
        FROM questions
        WHERE question_id IN
        ( 
            SELECT question_id
            FROM questions
            ORDER BY was_sent_at_time
            DESC LIMIT 50
        ) 
        AND tag IN
        (
            SELECT tag FROM tags
            WHERE tag = $1
        )
        ORDER BY was_sent_at_time
        DESC LIMIT 50;" 
    );

    // do NOT show other tags for the user
    $result_titles = pg_execute( $dbconn, "tag_search", 
        array($_POST['tag'] )
    );





    // First compile the Data

    // Go through each question

    // Go through each Tag
    while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
        // Add the Tag to an array of tags for that question
        $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];
    }


    // TODO
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];
    }


//            echo ("<h3>"/*{{{*/
//                    . "<a class='question_hyperlink' href='?"
//                        . "question_id=" 
//                        . $titles_and_Qid['question_id']  // for computer
////                            . "&" 
////                            . $titles_and_Qid['title']  // for reader
//                        . "'>" 
//                            . $titles_and_Qid['title'] 
//                    . "</a>"
//                . "</h3>"
//            );/*}}}*/

    $i = 0;
    // Then Loop Through each question
    foreach( $end_array as $tags_and_Qid['question_id'] => $tags_and_Qid['tag'] )
    {
        echo ("<div class='question_summary'>");

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

?>
