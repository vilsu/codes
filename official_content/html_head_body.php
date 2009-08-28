<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Keskustelusivu</title>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript" src="http://dev.jquery.com/view/trunk/plugins/validate/jquery.validate.js"></script>

<script type="text/javascript"> 

// Detele and Flag buttons in reading questions
jQuery('a.delete_question').live('click', function(){
    jQuery.post('/codes/handlers/delete_a_question.php', 
        { question_id: jQuery(this).attr('rel') }, 
        function(){
            $(".question_box").removeClass("yellow");
            $(".question_box").addClass("red");
            $("strong").removeClass("addedtext");
            $("div.successful").append("<strong class=\"addedtext\">Question was removed.</strong>");
        })
});

jQuery('a.flag_question').live('click', function(){
    jQuery.post('/codes/handlers/flag_question.php', 
        { question_id: jQuery(this).attr('rel') });
            $(".question_box").addClass("yellow");
            $("div.successful").append("<strong class=\"addedtext\">Question was flagged as Spam.</strong>");
});

// TODO buggy
//$(document).ready(function(){
//    // if ( $("textarea:empty").val().length() == 0 && $("input.title:empty").length() == 0 ) {
//    if ( $('input.title').is(":empty") ) 
//    {
//        $('.ask_question').attr('enabled', 'enabled'); 
//    }
//    else
//    {
//        $('.ask_question').attr('disabled', 'disabled'); 
//    }
//});
//





</script>

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
