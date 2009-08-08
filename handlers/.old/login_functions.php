<?php

function not_logged_in($file)
{
    if(!isset($_COOKIE['login']))
    {
       include($file);
    }
}

function logged_in($file)
{
    if(isset($_COOKIE['login']) AND login_function(true))
    {
       include($file);
    }
}

?>
