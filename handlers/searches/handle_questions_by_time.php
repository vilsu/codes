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




    // First compile the Data

    // Go through each question

    while($row = pg_fetch_row( $result_titles )) {
        $question_id = $row[0];/*{{{*/

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
/*}}}*/

    // Go through each Tag
        while( $row2 = pg_fetch_row( $result_tags )) {
            // Add the Tag to an array of tags for that question
            $end_array[$question_id]['tags'][] = $data['tag'];
        }

    }
    // Then Loop Through each question
        print_r( $end_array );
    foreach($end_array as $question_id => $data)
    {
    // Create the starting HTML
    echo '<div class="tags">';
        // Go through each tag

            foreach( $end_array[1]['tags'] as $tag )
            {
                echo ( "<a class='post_tag' href='?tag="
                . $tag
                . "'>"
                    . $tag
                . "</a>"
                );
            }
    // end the html
        echo '</div></div>';
   }


    echo ("</div>"
    );
}

?>
