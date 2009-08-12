<?php 
include './views/login_by_session.php';
include './official_content/html_head_body.php';
?>

<div class="container">
    <div class="header">
        <div id="userbar">
            <?php
            include './views/links_at_userbar.php';
            ?>
        </div>

        <div id="logo">
            <h1 id="logo">Keskustelusivu</h1>
        </div>
    </div>

    <div id="navbar">
        <div class='ask_question'>
            <?php
            include './views/ask_question_link.php';
            ?> 
        </div>
    </div>

    <div id="mainbar">
    <?php
        // Notices
        include './views/registration_at_userbar_notice.php';
        include './views/login_at_userbar_notice.php';
        include './views/logout_at_userbar_notice.php';

        include 'views/ask_question.php';

        include 'views/list_of_50_questions.php';
        include 'views/question_selected_by_user.php';

        include 'views/successful_notice.php';
        include 'views/unsuccessful_notice.php';

        // Static content
        include './views/about.php';
    ?>
    </div>
</div>

</body>
</html>
