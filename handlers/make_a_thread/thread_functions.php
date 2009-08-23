<?php

// Functions

// to create the title of the question
function create_question_title( $title, $question_id )
{

// to read sanitized data
$title_clear = htmlentities ( $title, ENT_QUOTES );

    echo ("<div id='mainheader'>"
        . "<h2>"
        . "<a href='index.php?"
            . "question_id="
            . $question_id
            . "&"  
            . $title_clear . "'>" 
                . $title_clear
        . "</a>"
        . "</h2>"
        . "</div>"
        );
}

// this may be buggy
function create_answer ( $answer ) {

// to read sanitized data
$answer_clear = htmlspecialchars ( $answer, ENT_QUOTES );
    echo ("<div class='one_answer'>"
            . $answer_clear
        . "</div>"
    );
}

// organize answers according inside a question
function create_tab_box_thread( $question_id ) {

    echo ( "<div id='tabs'>" );
    if ( $_GET['sort'] == 'newest'
   OR !($_GET['sort'] == 'oldest') ) {
        echo ("<span id='active_button'>"
                    . "<a href='?sort=newest"
                    . "&"
                    . "question_id="
                    . $question_id 
                    . "'>newest</a>" 
            . "</span>"
            );
        echo ( "<a href='?sort=oldest"
            . "&"
            . "question_id="
                . $question_id 
            . "'>oldest</a>"
        );
    }

    if ( $_GET['sort'] == 'oldest' ) {
        echo ("<a href='?sort=newest"
                . "&"
                . "question_id="
                . $question_id 
                . "'>newest</a>" 
            );
        echo ("<span id='active_button'>"
                    . "<a href='?sort=oldest"
                    . "&"
                    . "question_id="
                        . $question_id 
                    . "'>oldest</a>"
                . "</span>"
        );
    }
    echo ("</div>");
}

function create_moderator_box_for_a_question ( $question_id, $user_id ) {

    // to allow the asker to remove his own questions if zero answers/*{{{*/
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $result = pg_prepare ( $dbconn, "question_removal", 
        "SELECT user_id
        FROM questions
        WHERE user_id = $1
        AND question_id = $2"
    );
    $result = pg_execute ( $dbconn, "question_removal", 
        array ( $_SESSION['login']['user_id'], $_GET['question_id'] ) );

    while ( $row = pg_fetch_array ( $result ) ) {
        $result_clear = (int) $row['user_id'];
    }

    if ( is_integer ( $result_clear ) ) {
            echo ("<div class='post_menu'>");
                echo ("<a href='#' class='delete_question'" 
                    . " id=question_id'" . $question_id . "'" // to have question_id777
                    . " title='vote to remove this post'>delete</a>"
                    . "<span class='link_separator'>|</span>"
                    );
            echo ("<a href='#'"
                    . "class='flag_question'"
                    . " question_id='" . $question_id . "'"
                    . " title='flag this post for serious problems'>flag</a>"
                );
            echo ("</div>");
    }/*}}}*/
    else if ( $_SESSION['login']['logged_in'] == 1 ) {
        echo ("<div class='post_menu'>");
        if ( $_SESSION['login']['a_moderator'] == 1 ) {
            echo ("<a href='#' class='delete_question'" 
                . " rel='" . $question_id . "'"
                . " title='vote to remove this post'>delete</a>"
                . "<span class='link_separator'>|</span>"
            );

            $result = pg_query_params ( $dbconn, 
                        "SELECT flagged_for_moderator_removal
                        FROM questions
                        WHERE question_id = $1",
                        array ( $question_id ) 
                    );

            while ( $row = pg_fetch_array ( $result ) ) {
                $flag_status = $row[0];
            }

            // to mark the question as `not spam` if 
            // needed by moderator
            if ( $flag_status == 1 ) {
                echo ("<a href='#' class='no_flag_question'"
                    . " rel='" . $question_id . "'"
                    . " title='this question is not spam'>not spam</a>"
                );
            } 
            else
            {
                echo ("<a href='#'"
                        . " class='flag_question'"
                        . " rel='" . $question_id . "'"
                        . " title='flag this post for serious problems'>flag</a>"
                    );
            }
        } 
        else 
        {
            echo ("<a href='#'"
                . " class='flag_question'"
                . " rel='" . $question_id . "'"
                . " title='flag this post for serious problems'>flag</a>"
            );
            echo ("</div>");
        }
    }
}



function create_moderator_box_for_an_answer ( $answer_id, $user_id ) {

    // to allow the answerer to remove his own questions /*{{{*/
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result = pg_query_params( $dbconn, 
            "SELECT user_id
            FROM answers
            WHERE user_id = $1
            AND question_id = $2",
            array ( $_SESSION['login']['user_id'], 
                $_GET['question_id'] )
        );

    while ( $row = pg_fetch_array ( $result ) ) {
        $result_clear = (int) $row['user_id'];
    }
    
    // to allow the user remove his own answer
    if ( is_integer ( $result_clear ) ) {
            echo ("<div class='post_menu'>");
                echo ("<a href='#' class='delete_answer'" 
                    . " id=answer_id'" . $answer_id . "'"
                    . " title='vote to remove this post'>delete</a>"
                    . "<span class='link_separator'>|</span>"
                    );
    // user can flag his own answer
            echo ("<a href='#'"
                    . "class='flag_answer'"
                    . " answer_id='" . $answer_id . "'"
                    . " title='flag this answer for serious problems'>flag</a>"
                );
            echo ("</div>");
    }/*}}}*/

    // user can flag other answers
    else if ( $_SESSION['login']['logged_in'] == 1 ) {
        echo ("<div class='post_menu'>");
        if ( $_SESSION['login']['a_moderator'] == 1 ) {
 // to mark the answer as `not spam` if 
// needed by moderator
            
        // to get flag status/*{{{*/
        $question_id = $_GET['question_id'];
        if ( empty ( $_GET['question_id'] ) ) {
            // to get the question_id 
            // To redirect the user back to the question where he logged in
            $pattern = '/\?([^#&]*)/';
            $subject = $_SERVER['HTTP_REFERER'];
            // extract query from URL
            $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
            parse_str($query, $params);
            $question_id_array = explode ( '=', $query );
            $question_id = $question_id[0];
        }

        $result = pg_query_params ( $dbconn, 
            "SELECT flagged_for_moderator_removal, answer_id
            FROM answers
            WHERE question_id = $1",
            array ( $question_id ) 
        );


        $datas = pg_fetch_all ( $result );
        foreach ( $datas as $data ) {
            $flag_status [ $data [ 'answer_id' ] ] ['flagged_for_moderator_removal'] = (int) $data['flagged_for_moderator_removal'];
        }/*}}}*/

            if ( $flag_status [$answer_id] ['flagged_for_moderator_removal'] == 1 ) {
                echo ("<a href='#' class='delete_answer'" 
                    . " rel=' " . $answer_id . "'"
                    . " title='vote to remove this answer'>delete</a>"
                    . "<span class='link_separator'>|</span>"
                );
                echo ("<a href='#' class='no_flag_answer'"
                    . " rel='" . $answer_id . "'"
                    . "title='this answer is not spam'>not spam</a>"
                );
            } 
            else
            {
                echo ("<a href='#' class='delete_answer'" 
                        . " rel=' " . $answer_id . "'"
                        . " title='vote to remove this answer'>delete</a>"
                        . "<span class='link_separator'>|</span>"
                );
                echo ("<a href='#'"
                        . " class='flag_answer'"
                        . " rel='" . $answer_id . "'"
                        . " title='flag this answer for serious problems'>flag</a>"
                    );
            }

        } 
        else
        {
        echo ("<a href='#'"
                . "class='flag_answer'"
                . " rel='" . $answer_id . "'"
                . " title='flag this answer for serious problems'>flag</a>"
            );
        }
        echo ("</div>");
    }
}


function create_tags_summary ( $question_id ) {

$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    // to get tags
    $result = pg_prepare ( $dbconn, "query_tag_only",
        "SELECT tag
        FROM tags 
        WHERE question_id = $1"
    );
    $result = pg_execute ( $dbconn, "query_tag_only", array ( $_GET['question_id'] ) );
    $tags_array_summary = pg_fetch_all ( $result );

    // to get the amout of tags Globally
    $result = pg_prepare ( $dbconn, "query_tag_amount",
        "SELECT count(tag)
        FROM tags 
        WHERE tag = $1"
    );


    echo ("<div class='tags_summary'>");
    echo ("<p>tagged</p>");
    for ( $i = 0; $i < count ( $tags_array_summary ); $i++ ) {
        echo ("<div id='one_tag_line'>");
            $result = pg_execute ( $dbconn, "query_tag_amount", array ( $tags_array_summary[$i]['tag'] ) );
            $figure = pg_fetch_all ( $result );

            for ( $j = 0; $j < count ( $figure ); $j++ ) {
                create_tags ( $tags_array_summary[$i] );
                echo "<span id='multiplier'> × " 
                . $figure[$j]['count']
                . "</span>";
            }
        echo ("</div>");
    }
    echo ("</div>");

}

?>
