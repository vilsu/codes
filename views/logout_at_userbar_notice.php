<?php
// LOGOUT at USERBAR
if (isset($_GET['logout'])) {
    echo "Successful logout";
    session_destroy();
    header("Location: index.php");
} 
?>
