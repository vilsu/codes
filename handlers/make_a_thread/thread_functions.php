<?php

/**
 * @brief   Tee kysymyksen sisalto
 * @file    thread_functions.php
 */

include ("check_authority_functions.php");
include ("delete_edit_flag_buttons.php");

/** Luo HTML otsikko kysymykselle
 * @param $title string
 * @param $question_id integer
 */
function create_question_title( $title, $question_id )
{
 /* 
  * $title_clear string
  */
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

/** Luo HTML vastaukselle
 * @param $answer string
 */
function create_answer ( $answer ) {
 /* 
  * $answer_clear string
  */
    // to read sanitized data
    $answer = preg_replace('/\n\s*\n/', "<br />\n<br />\n", htmlentities( $answer ) );
    $answer_clear = $answer;
    echo ("<div class='one_answer'>"
        . $answer_clear
        . "</div>"
    );
}

/** Luo aikaj\"{a}rjestys tekstihaun mukaan
 * @param $question_id integer
 */
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
    else if ( $_GET['sort'] == 'oldest' ) {
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


/** Ota tagit kysymykselle
 * @param $question_id integer
 * @return array
 */
function get_tags_for_a_question ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");

 /* $tags_array_summary array
 * $result resource
 */
    // to get tags
    $result = pg_query_params ( $dbconn,
        'SELECT tag
        FROM tags 
        WHERE question_id = $1',
        array ( $_GET['question_id'] ) 
    );
    $tags_array_summary = pg_fetch_all ( $result );

    return $tags_array_summary;
}

/** Luo HTML sivustolaajuinen tagilistam\"{a}\"{a}r\"{a}t kysymykselle
 * @param $question_id integer
 */
function create_global_tag_count_box_for_a_question ( $question_id ) {
 /* $result resource
 * $tags_array_summary array
 * $figure array
 */
    $tags_array_summary = get_tags_for_a_question ( $question_id );

    $dbconn = pg_connect("host=localhost port=5432 dbname=noaa user=noaa password=123");
    // to get the amout of tags Globally
    $result = pg_prepare ( $dbconn, "query_tag_amount",
        'SELECT count(tag)
        FROM tags 
        WHERE tag = $1'
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
