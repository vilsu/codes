<?php

ob_start();

session_save_path("/tmp/");
session_start();

/** Ota kysymys lomakkeelta lomake_ask_question.php
 */

/** Ota sis\"{a}\"{a}nkirjautumistila
 * @param string $email
 * @return boolean
 */
function check_user_status () 
{
    #if ( empty ( $email ) ) exit("Please, fill your email."); 

    if( $_SESSION['login']['logged_in'] == 0 ) {
        header("Location: /codes/index.php"
            . "?unsuccessful"
        );
        return false;
    } 
    else if ( $_SESSION['login']['logged_in'] == 1 )
        return true;
    else
        return false;
}


/** Tarkasta otsikko
 * @param string $title
 * @return boolean
 */
function validate_title( $title )
{ 
    if ( empty ( $title ) ) {
        echo ("Tyhja title");
        return false;
    }
    else if ( mb_strlen ( $title ) > 200 ) {
        echo ("Liian pitka title");
        return false;
    }
    else 
        return true;
}

/** Tarkasta kysymys
 * @param string $body
 * @return boolean
 */
function validate_body( $body )
{
    if ( empty ( $body ) ) {
        echo ("Tyhja body");
        return false;
    }
    else
        return true;
}

/** Tarkasta tagit
 * @param string $tags
 * @return boolean
 */
function validate_tags( $tags )
{
    $tags = pg_escape_string ( $_POST['question']['tags'] );
    // to strip whitespaces at the end and beginning
    $tags_trimmed = preg_replace('/\s+/', '', $tags);
    // to make an array of the tags
    $tags_array = explode(",", $tags_trimmed);

    // max 5 tags
    if ( count ( $tags_array ) < 6 ) {
        for ( $i = 0; $i < count ( $tags ); $i++ ) 
        {
            if ( empty ($tags[$i] ) == 1 ) {
                echo ("Tyhja tagi");
                return false;
            }
        }
        return true;
    }
    else
        return false;
}

/** Tarkasta kysymys
 * @param string $title
 * @param string $body
 * @param string $tags
 * @return boolean
 */
function validate_input ( $title, $body, $tags) 
{
    echo ("sisalla validaatiossa");
    if ( !validate_title( $title ) ) {
        echo ("Virheellinen title");
        return false;
    }
    else if ( !validate_body( $body ) ) {
        echo ("Virheellinen body");
        return false;
    }
    else if ( !validate_tags( $tags ) ) {
        echo ("Virheellinen tag");
        return false;
    }
    else
        return true;
}

/** Aseta kysymys tietokantaan
 * @param integer $question_id
 * @param string $body
 * @param string $title
 * @return boolean
 */
function set_question ( $question_id ) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $body = $_POST['question']['body'];
    $title = $_POST['question']['title'];

    // This needs to be before Tags, since we need the question_id
    // Body of the question TO DB 
    $result_question = pg_query_params($dbconn, 
        'UPDATE questions
        SET body = $1, title = $2
        WHERE question_id = $3',
            array ( $body, $title, $question_id )
        );
    if ( $result_question ) 
        return true;
    else
        return false;
}



/** Aseta tagit tietokantaan
 * @param integer $question_id
 * @param string $tags
 * @param array $tags_array
 */
function set_tags ( $question_id) {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to sanitize data
    $tags = $_POST['question']['tags'];
    // to strip whitespaces at the end and beginning
    $tags_trimmed = preg_replace('/\s+/', '', $tags);
    // to make an array of the tags
    $tags_array = explode(",", $tags_trimmed);

    if ( !empty ( $tags_array ) ) {
        // to delete the old tags before inserting new ones
        $result = pg_query_params ( $dbconn,
            "DELETE FROM tags
            WHERE question_id = $1",
            array ( $question_id ) 
        );

        $result = pg_prepare ( $dbconn, "query_777",
            'INSERT INTO tags
            (tag, question_id)
            VALUES ($1, $2)'
        );


        if ( count ( $tags_array ) < 6 ) {
            // to save the cells in the array to db
            for ( $i = 0 ; $i < count ( $tags_array ) ; $i++ ) {
                echo $tags_array[$i];
                $result = pg_execute($dbconn, "query_777", 
                    array ( strtolower ( $tags_array[$i] ), $question_id )
                );
            }
        }
    }
}

/** Ota kysymystunniste
 * @param string $pattern
 * @param string $subject
 * @param string $query
 * @param integer $question_id
 * @return integer
 */
function get_question_id () {
    $pattern = '/(question_id=[^#&]*)/';
    $subject = $_SERVER['HTTP_REFERER'];
    // extract query from URL
    $query = preg_match($pattern, $subject, $match) ? $match[1] : '';  
    parse_str($query, $params);
    $question_id = explode ( '=', $query );
    $question_id = $question_id[1];

    return $question_id;
}

/** Laita kysymys tietokantaan
 * @param integer $question_id
 * @param string $title
 * @param string $body
 * @param string $tags
 */
function put_question_to_db ( $question_id ){
    if ( check_user_status () ) 
    {
        echo ("User status pelaa");

        $body = pg_escape_string ( $_POST['question']['body'] );
        $title = pg_escape_string ( $_POST['question']['title'] );
        $tags = $_POST['question']['tags'];

        if ( validate_input ( $title, $body, $tags ) ) 
        {
            echo ("User input pelaa");
            $title = $_POST['question']['title'];

            set_question ( $question_id );
            set_tags ( $question_id );

            header  ("Location: /codes/index.php?" 
                . "question_updated"
                . "&"
                . "question_id="
                . $question_id
                . "&"
                . $title  // for user
            );
        } 
        else 
            header("Location: /codes/index.php?"
                . "&unsuccessful_new_question"
            );
    }
    else
        header("Location: /codes/index.php"
                . "&unsuccessful_new_question"
            );
}




// Let's fire!

// Laita kysymystietokantaan
put_question_to_db ( get_question_id() );

ob_end_flush();

?>
