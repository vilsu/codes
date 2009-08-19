<?php

// we cannot use the function name `header`
// because it is taken by PHP

// this is for headers without values in the variable OR
// for headers without varibles
function mainheader( $mainheader, $link ) {
    if( $link ) {
    echo ("<div id='mainheader'>"
        . "<h2>"
            . "<a href='index.php?" . $mainheader . "'>" 
                . $mainheader
            . "</a>"
        . "</h2>"
        . "</div>"
        );
    } else {
    echo ("<div id='mainheader'>"
        . "<h2>"
            . $mainheader
        . "</h2>"
        . "</div>"
    );
    }
}

function subheader( $subheader ) {
     echo ("<div id='subheader'>"
        . "<h2>"
        . $subheader
        . "</h2>"
        . "</div>"
        );
}

?>
