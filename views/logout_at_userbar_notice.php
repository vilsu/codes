<?php
// LOGOUT at USERBAR
if (isset($_REQUEST['logout'])) {
    echo "Successful logout";
    session_destroy();
}
?>
