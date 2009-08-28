<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Keskustelusivu</title>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>

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

var input = $(":button").css({background:"yellow", border:"3px red solid"});
$("div").text("For this type jQuery found " + input.length + ".")
        .css("color", "red");
$("form").submit(function () { return false; }); // so it won't submit

var $submit = $("input[type=submit]");
if ( $("input:empty").length > 0 ) {
   $submit.attr("disabled","disabled");
} else {
   $submit.removeAttr("disabled");
}



//$(document).ready(function(){
//    $("#ask_form").validate(){
//        rules: {
//            username {
//                required: true,
//                minlenghth: 2
//            },
//            email: {
//                required: true;
//                minlength: 6
//            },
//            password {
//                required: true,
//                minlength: 6
//            }
//        } 
//    });
//}


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
