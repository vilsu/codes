<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Keskustelusivu</title>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>

<script type="text/javascript"> 

jQuery('a.delete_question').live('click', function(){
    jQuery.post('/codes/handlers/delete_a_question.php', 
        { question_id: jQuery(this).attr('rel') }, 
        function(){
            $(".question_box").removeClass("yellow");
            $(".question_box").addClass("red");
            alert ("Question was removed.");
        })
});

jQuery('a.flag_question').live('click', function(){
    jQuery.post('/codes/handlers/flag_question.php', 
        { question_id: jQuery(this).attr('rel') });
            $(".question_box").addClass("yellow");
            alert ("Question is now flagged as spam.");
});
 

</script>

</head>

<body>

<script type="text/javascript">

$(document).ready(function(){

    function notEmpty() {
        //put this in a function and call it when the user tries to submit
        var tags = $("#required").val();
        if (tags == '' || tags == null) {
            alert('Please enter one or more tags');
            return false;
        }
        return true;
    }

});

</script>
