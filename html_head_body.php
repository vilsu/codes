<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Forum</title>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>

<?php
include ("./jQuery.php");
?>

<style>#field { margin-left: .5em; float: left; }
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
    </head>



    <body>
