<?php 
set_include_path(':/var/www/codes/handlers/:/var/www/codes/lomakkeet/:');

// otetaan yhteys kantaan
$dbconn = pg_connect("host=localhost port=5432 dbname=noa user=noa password=123");
if(!$dbconn) {
    echo "An error occurred - Hhhh\n";
    exit;
}

if (isset($_GET['email'])) {
    // check the login status
    include 'handle_login_status.php';
}

?>

<html>
<head>

    <link rel="stylesheet" type="text/css" href="style.css" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">

    <title>Keskustelusivu</title>
</head>

<body>

<div class="container">

<div class="header">

<div id="userbar">
<ul>

<?php
    if (!array_key_exists('email', $_GET)) {
    //if(isset($_GET['email'])) {
        echo "<li><a href='index.php?registration'>Register</a></li>";
        echo "<li><a href='index.php?login'>Login</a></li>";
    }
    else {
        //echo "'<li>' . $_GET['email'] . '</li>'";
        echo $_GET['email'];
    }

// varmistetaan, etta URLiin jaa muuttujat, kun ollaan kirjautuneena
// Always escape & by &amp;
if (isset($_GET['email'])) {
    echo  ("<li><a href='?about&amp;email=" .    
        $_GET['email'] . 
        "&amp;passhash_md5=" . 
        $_GET['passhash_md5'] . 
        "'>About</a></li>");
} else {
    echo "<li><a href='index.php?about'>About</a></li>";
}
?>



</ul>
</div>


<div id="logo">
    <h1 id="logo">Keskustelusivu</h1>
</div>

</div>

<div id="navbar">
    <!-- to change the layout of the "Ask question" -button -->
    <!-- default: 
                <div class="ask_question">
         active:  
                <div class="ask_question" id='ask_question_active'>
    -->
    <div class='ask_question'>

    <?php
    if (isset($_GET['email'])) {

        if(isset($_GET['ask_question'])) {
            echo  ("<li id='ask_question_active'><a href='?ask_question&amp;email=" .
            $_GET['email'] . 
            "&amp;passhash_md5=" . 
            $_GET['passhash_md5'] . 
            "'>Ask question</a></li>");

        }
        else {
            echo  ("<li><a href='?ask_question&amp;email=" .
            $_GET['email'] . 
            "&amp;passhash_md5=" . 
            $_GET['passhash_md5'] . 
            "'>Ask question</a></li>");

        }
    } else {
        echo "<li><a href='?ask_question'>Ask question</a></li>";
    }
    ?>

</div>

</div>







<div id="mainbar">
<?php

// REGISTRATION at USERBAR
if (array_key_exists('registration', $_GET)) {
    // change the layout by adding question form by getting data
    include 'lomake_registration.php';
}

// LOGIN at USERBAR
if (array_key_exists('login', $_GET)) {
    // change the layout by adding question form by getting data
    include 'lomake_login.php';
}



// ABOUT 
if (array_key_exists('about', $_GET)) {
    // change the layout by adding question form by getting data
    include 'about.php';
}

// ASK QUESTION -view
if (array_key_exists('ask_question', $_GET)) {
    // change the layout by adding question form by getting data from 
    // lomakkeet/lomake_ask_question.php
    include 'lomakkeet/lomake_ask_question.php';

    // LOGIN at the bottom of Ask_question
    if (!array_key_exists('email', $_GET)) {
        // change the layout by adding question form by getting data
        echo "<div id='notice'>";
        echo "<p>Ole kirjautuneena, niin voit kysya.</p>";
        include 'lomake_login.php';
        echo "</div>";
    } else {
            echo "<input type='submit' value='Ask Your Quostion' /></form>";
    }
}



// LIST OF 10 QUESTIONS
// if there is no data in $_GET, then the print 10 questions
if (array_key_exists('', $_GET)) {
    $result = pg_prepare($dbconn, "query8", "SELECT question_id, title FROM questions
        ORDER BY was_sent_at_time DESC LIMIT 10;");
    $result = pg_execute($dbconn, "query8", array());
    // print the title of each question: title
    // to make the URL for each title: question_id, title
    //      index.php?question_id=777&title
    //                |               |--- for reader
    //                |------------------- for computer: lomake_question_answer.php
    while($row = pg_fetch_row($result)) {
        echo "<div id='question_summary'>
                
                    <h3>
                        <a href='?question_id=" . $row[0] . "&" . $row[1] . "'>" . $row[1] . "</a>
                    </h3>
                </div>";
    }
}

// A QUESTION SELECTED BY USER 
// to generate the answers for the given question 
if (array_key_exists('question_id', $_GET)) {

    // to get the title and body of the question
    $result = pg_prepare($dbconn, "query9", "SELECT title, body  
        FROM questions WHERE question_id = $1;");
    // TODO I am not sure if the syntax is correct for parametr inside $_GET
    $result_title_body = pg_execute($dbconn, "query9", array($_GET['question_id']));

    // to get answers for the question
    $result = pg_prepare($dbconn, "query10", "SELECT answer FROM answers
        WHERE questions_question_id = $1;");
    $result_answer = pg_execute($dbconn, "query10", array($_GET['question_id']));
}
?>



<div class="successful">
<p>
<?php
// SUCCESSFUL REGISTRARATION
if (array_key_exists('successful_registration', $_GET)) {
    echo ("Successful registration. You are now logged in too.");
}

// SUCCESSFUL LOGIN
if (array_key_exists('successful_login', $_GET)) {
    echo ("Successful login");
}

// QUESTION SENT
if (array_key_exists('question_sent', $_GET)) {
    echo ("Question sent");
}



?>
</div>

<div class="unsuccessful">
<?php
// UNSUCCESSFUL LOGIN
if (array_key_exists('unsuccessful_login', $_GET)) {
    echo ("Unsuccessful login. Please try again.");
}


// UNSUCCESSFUL REGISTRARATION: wrong email
if (array_key_exists('registration_wrong_email', $_GET)) {
    echo ("Unsuccessful registration. Wrong email address.");
}
// UNSUCCESSFUL REGISTRARATION: 2 accounts for one email
if (array_key_exists('2email', $_GET)) {
    echo ("Unsuccessful login. You already have an accout.
           Please, use Login.");
}


// UNSUCCESSFUL random bugs
if (array_key_exists('unsuccessful', $_GET)) {
    echo ("This is an unknown bug. Please, report it to the moderator."); 
}



?>
</p>
</div>





</div>


</div>
</div>
</body>
</html>
