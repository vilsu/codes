<?php

/**
 * @brief   Jos lause about nakymalle
 * @file    /views/about.php
 */

if (array_key_exists('about', $_REQUEST)) {
    // change the layout by adding question form by getting data
    mainheader( "About", false );
    include './official_content/about.php';
}
?>
