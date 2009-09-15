<?php

/**
 * @brief   Sivuston esittely 
 * @file    /views/about.php
 */

if (array_key_exists('about', $_REQUEST)) {
    // change the layout by adding question form by getting data
    mainheader( "About", false );

    echo ("<p>
            This site is for nerds.
          </p>");
}
?>
