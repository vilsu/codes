<div class="hlinks">
<ul>
<?php

/**
 * @brief   Tee linkit ylapalkkiin
 * @file    links_at_userbar.php
 */

/**
 * Tee harmaa linkkilaatikko sivunyl\"{a}osaan
 */
function make_links_bar_at_top () {
	if (!$_SESSION['login']['logged_in']) {
		echo ("<li><a href='index.php?"
				. "login"
				. "'>Login</a></li>"
		     );
	}
	if ($_SESSION['login']['logged_in']) {
		echo ("<li>" 
				. $_SESSION['login']['username'] 
				. "</li>"
		     );
		echo ("<li><a href='index.php?logout'>Logout</a></li>");
	}
	echo ("<li><a href='index.php?about"
			. "'>About</a></li>"
	     );
}

make_links_bar_at_top ();

?>
</ul>
</div>
