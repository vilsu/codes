<?php
    while($row = pg_fetch_row( $result_titles )) {

        $question_id = $row[1];

        echo ("<div class='question_summary'>"
                . "<div class='summary'>"
        // TITLE
                    . "<h3>"
                        . "<a class='question_hyperlink' href='?question_id=" 
                            . $row[1] 
                            . "&" 
                            . $row[0] 
                            . "'>" 
                                . $row[0] 
                        . "</a>"
                    . "</h3>"
            );

        // TAGS
        echo ("<div class='tags'>"
        while( $tag = pg_fetch_row( $result_tags )) {
            echo ( "<a class='post_tag' href='?tag="
                    . $tag[0][$question_id]
                    . "'>"
                        . $tag[0][$question_id]
                    . "</a>"
                );
        }
        echo ("</div>");

        // Username
        echo ("<div class='user_started'>"
                . "<a href='?'>"
                    . $row[3]
                . "</a>"
            . "</div>"
            );

        echo ("</div>"
        . "</div>"
        );
    }
?>
