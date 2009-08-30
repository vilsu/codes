<?php

/** Luo otsikot HTML koodin kanssa
 */

/** Luo p\"{a}\"{a}otsikko
 * @param string $mainheader
 * @param boolean $link
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
 * @param string $subheader
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
