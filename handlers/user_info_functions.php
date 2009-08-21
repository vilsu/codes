<?php

function create_user_info_box_question( 
    $user_id,       // to allow users to have spaces in their names 
    $username, 
    $was_sent_at_time, 
    $describtion 
) {
    $username_trimmed = explode ( " ",  $username );
    echo ("<div id='user_info_box'>"
            . "<div id='user_info_time'>"
                . $describtion . " " . $was_sent_at_time
            . "</div>"
            . "<div id='user_in_user_box'>"
                . "<a href=index.php?username="
                    . $username_trimmed[0]  // only the first word
                    . "&"
                    . "user_id="
                    . $user_id
                    . ">"
                    . $username
                . "</a>"
            . "</div>"
        . "</div>"
    );
}

?>
