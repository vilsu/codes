<?php

// This handles the receiving of new questions to database
// and gives users feedback about the completion.

ob_start();

// to process question sent from the lomake_ask_question.php

session_save_path("/tmp/");
session_start();

$body = pg_escape_string ( $_POST['question']['body'] );
$title = pg_escape_string ( $_POST['question']['title'] );
$tags = $_POST['question']['tags'];



//$passhash_md5 = $_SESSION['login']['passhash_md5'];

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

function validate_body( $body )
{
    if ( empty ( $body ) ) {
        echo ("Tyhja body");
        return false;
    }
    else
        return true;
    #if ( mb_strlen ( $body ) > 1000 ) exit("Too long body.");
}

function validate_tags( $tags )
{
    // May fail if user gives " , hello" as a tag
    
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


function get_user_id () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $email = $_SESSION['login']['email'];

    $result = pg_query_params ( $dbconn,
        "SELECT user_id
        FROM users
        WHERE email = $1",
        array ( $email )
    );
    // to read the value
    while ( $row = pg_fetch_row ( $result ) ) {
        $user_id = $row[0];
    }

    return $user_id;
}


function set_question () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $body = $_POST['question']['body'];
    $title = $_POST['question']['title'];
    $user_id = get_user_id ();

    // This needs to be before Tags, since we need the question_id
    // Body of the question TO DB 
    $result_question = pg_query_params($dbconn, 
        "INSERT INTO questions
        (body, title, user_id)
        VALUES ($1, $2, $3)",
            array($body, $title, $user_id)
        );
    if ( $result_question ) 
        return true;
    else
        return false;
}

function get_question_id () {
    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    $user_id = get_user_id ();
    $body = $_POST['question']['body'];
    $title = $_POST['question']['title'];

    // to get the question_id from the db
    $result = pg_query_params($dbconn, 
        "SELECT question_id
        FROM questions
        WHERE title = $1
        AND body = $2
        AND user_id = $3",
        array( $title, $body, $user_id )
    );
    while ($row = pg_fetch_row($result)) {
        $question_id = $row[0];
    }

    return $question_id;
}

function set_tags () {
    $question_id = get_question_id ();

    $dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
    // to sanitize data
    $tags = pg_escape_string ( $_POST['question']['tags'] );
    // to strip whitespaces at the end and beginning
    $tags_trimmed = preg_replace('/\s+/', '', $tags);
    // to make an array of the tags
    $tags_array = explode(",", $tags_trimmed);

    if ( !empty ( $tags_array ) ) {
        // TAGS to DB
        $result = pg_prepare($dbconn, "query2", 
            "INSERT INTO tags
            (tag, question_id)
            VALUES ($1, $2)"
        );

        if ( count ( $tags_array ) < 6 ) {
            // to save the cells in the array to db
            for ( $i = 0; $i < count($tags_array); $i++ ) {
                $result = pg_execute($dbconn, "query2", 
                    array( strtolower ( $tags_array[$i] ), $question_id)
                            // to change tags to lowercase
                );
            }
        }
    }
}

// Let's fire!

if ( check_user_status () ) {
    echo ("User status pelaa");
    if ( validate_input ( $title, $body, $tags ) ) {
        echo ("User input pelaa");
        $title = $_POST['question']['title'];

        set_question ();
        set_tags ();
        $question_id = get_question_id ();      // question must be set before

        header  ("Location: /codes/index.php?" 
            . "question_sent"
            . "&"
            . "question_id="
            . $question_id
            . "&"
            . $title  // for user
        );
    } 
    else 
        header("Location: /codes/index.php?"
            . "ask_question"
            . "&unsuccessful_new_question"
        );
}
else
    header("Location: /codes/index.php"
            . "ask_question"
            . "&unsuccessful_new_question"
        );


ob_end_flush();

?>
