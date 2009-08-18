<?php
echo "POST: " . session_id();
session_id();
var_dump($_POST);

echo "COOKIE";
var_dump($_COOKIE);

echo "SESSION";
var_dump($_SESSION);
print_r( $_SESSION );

echo "GET";
var_dump($_GET);

echo ("HTTP_REFERER\n"
    . $_SERVER['HTTP_REFERER']
    );

echo ("NB SESSION koodia");
print_r($_SESSION);
?>
