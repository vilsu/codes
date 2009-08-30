<?php

/**
 * @file    edit_question.php
 * @brief   Muokkaustoiminnot
 */


include ("getters_at_question.php");

/** Luo kysymys
 * @param string $body
 * @param integer $question_id
 * @return string
 */
function get_question_body ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result = pg_query_params ( $dbconn,
        'SELECT body
        FROM questions
        WHERE question_id = $1',
        array ( $question_id  ) 
    );
    while ( $row = pg_fetch_array ( $result ) ) {
        $body = $row['body'];
    }
    return $body;
}

/** Luo kysymyksen otsikko 
 * @param string $title
 * @param integer $question_id
 * @return string
 */
function get_question_title ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result = pg_query_params ( $dbconn,
        'SELECT title 
        FROM questions
        WHERE question_id = $1',
        array ( $question_id  ) 
    );
    while ( $row = pg_fetch_array ( $result ) ) {
        $title = $row['title'];
    }
    return $title;
}

/** Ota kysymysksen tagit 
 * @param string $tags
 * @param integer $question_id
 * @return string
 */
function get_question_tags ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    $result = pg_query_params ( $dbconn,
        'SELECT tag
        FROM tags 
        WHERE question_id = $1',
        array ( $question_id  ) 
    );
    while ( $row = pg_fetch_array ( $result ) ) {
        $tags[] = $row['tag'];
    }
    $tags = implode ( ", ", $tags );
    // put tags to this form `a, b, c,` from the array TODO

    return $tags;
}


/** Luo HTML kysymykselle
 * @param string @body
 */
function create_body_at_question ( $body ) {
    echo ("<div class='resizable-textarea'>"
        . "<textarea id='input' class='textarea' id='required' tabindex='101' rows='15' cols='92' name='question[body]'>"
        . $body
        . "</textarea>"
        . "</div>");
}

/** Luo HTML kysymyksen otsikolle 
 * @param string @title
 */
function create_title_at_question ( $title ) {
    echo ("<label for='title'>Title</label>"
        . "<input name='question[title]' type='text' cols='92' class='title' id='required'"
        . " value='" . $title . "' />"
    );
}


/** Luo HTML tageille 
 * @param string @tags
 */
function create_tags_at_question ( $tags ) {
    echo ("<label for='tags'>Tags</label>"
        . "<input name='question[tags]' type='text' cols='92' class='tags' id='required'"
        . " value='" . $tags . "' />"
    );
    echo ( "<div id='notice'><p>"
        . "Please, use at least one tag and maximum five tags. Separate them by commas (,)."
        . "</p></div>"
    );

}

// TODO
/** Luo kysymys muokkausn\"{a}kym\"{a}ss\"{a}
 * @param string $body
 * @param string $title
 * @param string $tags
 * @param integer $question_id
 */
function create_edit_box ( $question_id ) {
    $body = get_question_body ( $question_id ); 
    $title = get_question_title ( $question_id );
    $tags = get_question_tags ( $question_id );

    echo ("<form id='update_question_form' method='post' "
        . "action='./handlers/update_question.php"
        . "'>"
    );
    echo ("<fieldset>"
        . create_title_at_question ( $title )
    . create_body_at_question ( $body )
    . create_tags_at_question ( $tags )
    . "</fieldset>"
    );
    echo ("<input class='update_question' onclick='checkFields();' type='submit' value='Update Your Question' /></form>");
}


// Let's fire!
/** Luo muokkauslaatikko
 */
create_edit_box ( get_questionID_at_question ()  );

?>
