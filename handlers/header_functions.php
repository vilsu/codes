<?php

/** 
 * @file    header_functions.php
 * @brief   Luo otsikot HTML koodin kanssa
 */

/** Luo paaotsikko
 * @param $mainheader string 
 * @param $link boolean 
 */
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

/** Luo alaotsikko
 * @param $subheader string 
 */
function subheader( $subheader ) {
    echo ("<div id='subheader'>"
        . "<h2>"
        . $subheader
        . "</h2>"
        . "</div>"
    );
}

?>
