<?php

/**
 * @brief   Jarjesta kysymyslista ajan mukaan, kun valintana on aika, aihe tai 
 * kayttajanimi
 * @file    organize_a_list_of_questions_functions.php
 */

/** Luo HTML kysymysten j\"{a}rjest\"{a}miseen listassa
 */
function create_tab_box_question( ) {
    echo ( "<div id='tabs'>");
    if ( $_GET['tab'] == 'newest'
        OR !( $_GET['tab'] == 'oldest' ) ) {
            echo ("<span id='active_button'>"
                . "<a name='newest' href='?tab=newest#newest'>newest</a>"
                . "</span>"
                . "<a name='oldest' href='?tab=oldest#oldest'>oldest</a>"
            );
        }
    if ( $_GET['tab'] == 'oldest' ) {
        echo ("<a name='newest' href='?tab=newest#newest'>newest</a>"
            . "<span id='active_button'>"
            . "<a name='oldest' href='?tab=oldest'#oldest>oldest</a>"
            . "</span>"
        );
    }
    echo ("</div>");
}

/** Luo HTML j\"{a}rjestyslaatikko kysymyksille listassa tagihaun tai yleishaun
 * GET muuttujan mukaan
 * @param $tag string
 */
function create_tab_box_question_tags( $tag ) {
    echo ( "<div id='tabs'>");
    if ( ( $_GET['tab_tag'] == 'newest' )
        OR !( $_GET['tab_tag'] == 'oldest' ) ) {
            echo ("<span id='active_button'>"
                . "<a name='newest' href='?tab_tag=newest"
                . "&tag="
                . $tag
                . "#newest'>newest</a>"
                . "</span>"
                . "<a name='oldest' href='?tab_tag=oldest"
                . "&tag="
                . $tag
                . "#oldest'>oldest</a>"
            );
        }
    if ( $_GET['tab_tag'] == 'oldest' ) {
        echo ("<a name='newest' href='?tab_tag=newest"
            . "&tag="
            . $tag
            . "#newest'>newest</a>"
            . "<span id='active_button'>"
            . "<a name='oldest' href='?tab_tag=oldest"
            . "&tag="
            . $tag
            . "#oldest'>oldest</a>"
            . "</span>"
        );
    } 
    echo ("</div>");
}


/** Luo HTML jarjestyslaatikko kysymyksille listassa k\"{a}ytt\"{a}j\"{a}nimi-
 * tai tagihaun GET muuttujan mukaan
 * @param $username string
 */
function create_tab_box_question_usernames ( $username ) {
    echo ( "<div id='tabs'>" );
    if ( ( $_GET['tab_user'] == 'newest' )
        OR !( $_GET['tab_user'] == 'oldest' ) ) {
            echo ("<span id='active_button'>"
                . "<a name='newest' href='?tab_user=newest"
                . "&username="
                . $username
                . "#newest'>newest</a>"
                . "</span>"
                . "<a name='oldest' href='?tab_user=oldest"
                . "&username="
                . $username
                . "#oldest'>oldest</a>"
                . "</div>"
            );
        }
    if ( $_GET['tab_user'] == 'oldest' ) {
        echo ("<a name='newest' href='?tab_user=newest"
            . "&username="
            . $username
            . "#newest'>newest</a>"
            . "<span id='active_button'>"
            . "<a name='oldest' href='?tab_user=oldest"
            . "&username="
            . $username
            . "#oldest'>oldest</a>"
            . "</span>"
        );
    } 
    echo ("</div>");
}



?>
