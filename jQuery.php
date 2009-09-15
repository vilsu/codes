<script type="text/javascript"> 

/*
 * @file    jQuery.php
 * @brief   Laukaise huomautukset, jos tapahtuma onnistuu.
 *
 * Tiedosto laukaisee huomautukset, jos tiedostot /handlers/flag_question.php ja 
 * /handlers/delete_a_question.php suoritetaan onnistuneesti.
 */

// Detele and Flag buttons in reading questions
jQuery('a.delete_question').live('click', function(){
    jQuery.post('/pgCodesS/handlers/delete_a_question.php', 
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
    jQuery.post('/pgCodesS/handlers/flag_question.php', 
        { question_id: jQuery(this).attr('rel') });
            $(".question_box").addClass("yellow");
            $("div.successful").append("<strong class=\"addedtext\">Question was flagged as Spam.</strong>");
});

</script>
