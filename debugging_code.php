<?php
/**
 * @brief   Ohjelmiston virheiden etsinta koodi
 * @file    debugging_code.php
 */


echo "POST: " . session_id();
session_id();
var_dump($_POST);

echo "COOKIE";
var_dump($_COOKIE);

echo "SESSION";
var_dump($_SESSION);

echo "GET";
var_dump($_GET);

echo ("HTTP_REFERER\n"
    . $_SERVER['HTTP_REFERER']
    );

?>
<style>
    p { background:yellow; font-weight:bold; cursor:pointer; 
        padding:5px; }
    p.over { background: #ccc; }
    span { color:red; }

#field { margin-left: .5em; float: left; }
#field, label { float: left; font-family: Arial, Helvetica, sans-serif; font-size: small; }
br { clear: both; }
input { border: 1px solid black; margin-bottom: .5em;  }
input.error { border: 1px solid red; }
label.error {
    background: url('http://dev.jquery.com/view/trunk/plugins/validate/demo/images/unchecked.gif') no-repeat;
    padding-left: 16px;
    margin-left: .3em;
    }
    label.valid {
        background: url('http://dev.jquery.com/view/trunk/plugins/validate/demo/images/checked.gif') no-repeat;
        display: block;
        width: 16px;
        height: 16px;
    }
</style>

