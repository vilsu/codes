<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>Keskustelusivu</title>

   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript"> 

jQuery('a.delete_post').live('click', function(){

    jQuery.post('delete.php', {id: jQuery(this).attr('id')}, function(data){
        //do something with the data returned
    })
});
 
    $(".delete-button").click(function() {
        var id = this.href.slice(this.href.lastIndexOf('/')+1);
        // perform AJAX call using this id
        return false; // return false so that we don't follow the link!
    });

    $(document).ready(function(){

        $("p").live("click", function(){
            $(this).after("<p>Another paragraph!</p>");
        });

    });

</script>

        <style>
        p { background:yellow; font-weight:bold; cursor:pointer; 
            padding:5px; }
        p.over { background: #ccc; }
        span { color:red; }
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
