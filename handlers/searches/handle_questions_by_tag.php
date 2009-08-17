<?php
if( isset( $_GET['tag'] ) ) {
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");

    // to get titles and question_ids
    // When tag is given by the user
    $result_titles = pg_prepare( $dbconn, "tag_search",
        "SELECT q.question_id, q.title
            FROM questions q
                INNER JOIN tags t on q.question_id=t.question_id
            WHERE tag = $1
            ORDER BY q.was_sent_at_time
            DESC LIMIT 50;"
    );
    $result_titles = pg_execute( $dbconn, "tag_search", 
        array( $_GET['tag'] )
    );

    // TAGS
    $result_tags = pg_prepare( $dbconn, "tags_query_search", 
        "SELECT question_id, tag
            FROM tags
            WHERE question_id IN
            (
                SELECT question_id
                FROM tags
                WHERE tag = $1
                DESC LIMIT 50;
            )
            ORDER BY question_id;"
    );
    $result_tags = pg_execute( $dbconn, "tags_query_search", 
        array( $_GET['tag'] )
    );

    // First compile the Data


    // TODO titlen saaminen bugaa
    // tags
    while( $tags_and_Qid = pg_fetch_array( $result_tags )) {
        // Add the Tag to an array of tags for that question
        $end_array [ $tags_and_Qid['question_id'] ] ['tag'] [] = $tags_and_Qid['tag'];

    }






    // Go through each question
    while( $titles_and_Qid = pg_fetch_array( $result_titles ) ) {
        $titles [ $titles_and_Qid['question_id'] ] ['title'] = $titles_and_Qid['title'];
    }

foreach( $end_array as $tags_and_Qid['question_id'] => $titles_and_Qid['title'] )
    {
        // Grab the title for the first array
        $title = $titles_and_Qid['title'];
        echo "NB ! \n ";
        print_r( $titles_and_Qid['title'] );

        // Grab the tags for the question from the second array
        $tags = $end_array [ $tags_and_Qid['question_id'] ] ['tag'];

        // 1.1 Print the Title & 1.2 Print the Tags
        create_question($title, $tags);
    }
}

?>
