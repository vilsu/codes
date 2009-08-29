<script type="text/javascript"> 

/*
 *    Questions
 */

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
// Flag
jQuery('a.flag_question').live('click', function(){
    jQuery.post('/codes/handlers/flag_question.php', 
        { question_id: jQuery(this).attr('rel') });
            $(".question_box").addClass("yellow");
            $("div.successful").append("<strong class=\"addedtext\">Question was flagged as Spam.</strong>");
});



/*
 * Answers
 */

// TODO
var answer = $('#answer').val();
jQuery('div.answer_' + answer + ' a.delete_answer').live('click', function(){
    jQuery.post('/codes/handlers/delete_an_answer.php', 
        { delete_answer: jQuery(this).attr('rel') });
            $("#one_answer").addClass("red");
            $("div.successful").append("<strong class=\"addedtext\">Answer was removed.</strong>");
});


jQuery('a.flag_answer').live('click', function(){
    jQuery.post('/codes/handlers/flag_answer.php', 
        { flag_answer: jQuery(this).attr('rel') });
            $("#one_answer").addClass("yellow");
            $("div.successful").append("<strong class=\"addedtext\">Answer was flagged as Spam.</strong>");
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
