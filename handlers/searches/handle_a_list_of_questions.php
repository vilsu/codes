<?php

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
        echo ("<div class='tags'>");
        while( $row2 = pg_fetch_row( $result_tags )) {
            $end_array = array();
            foreach( $row2 as $question_id => $data )
            {
                /* the first part of this creates an array key for the ID.
                Then we define a sub array that holds 'tags'.
                Finally, we add a new value to the array with the tag name.
                Because the brackets contain nothing, it means we  don't care
                about the key of the value. */
                $end_array[$question_id]['tags'][] = $data['tag'];
            }

            // print_r($end_array);

            // Then You can access all the tags for question 1 through
            // We go through each tag of the question ID of $i and then echo it
            foreach( $end_array[1]['tags'] as $tag )
            {
            //echo ("data2 on ");
            print_r( $end_array[1]['tags'] );

                echo ( "<a class='post_tag' href='?tag="
                . $tag
                . "'>"
                    . $tag
                . "</a>"
                );
            }

            echo (" end-array tassa ");
            print_r( $end_array );

           //reset( $end_array );     // to return the pointer to the start
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

?>
