<?php

function create_user_info_box_question( 
    $user_id,    // not put in
    $username, 
    $was_sent_at_time, 
    $describtion 
) {
    echo ("<div id='user_info_box'>"
            . "<div id='user_info_time'>"
                . $describtion . " " . $was_sent_at_time
            . "</div>"
            . "<div id='user_in_user_box'>"
                . "<a href=index.php?username="
                    . $username
                    . ">"
                    . $username
                . "</a>"
            . "</div>"
        . "</div>"
    );
}

?>
