<?php
/*~ index.php (calls subscribe page, process, and is also landing page)
.---------------------------------------------------------------------------.
|  Software: PHPMailer-ML - PHP mailing list                                |
|   Version: 1.6                                                            |
|   Contact: via sourceforge.net support pages (also www.codeworxtech.com)  |
|      Info: http://phpmailer.sourceforge.net                               |
|   Support: http://sourceforge.net/projects/phpmailer/                     |
| ------------------------------------------------------------------------- |
|    Author: Andy Prevost (project admininistrator)                         |
| Copyright (c) 2004-2009, Andy Prevost. All Rights Reserved.               |
| ------------------------------------------------------------------------- |
|   License: Distributed under the General Public License (GPL)             |
|            (http://www.gnu.org/licenses/gpl.html)                         |
| This program is distributed in the hope that it will be useful - WITHOUT  |
| ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or     |
| FITNESS FOR A PARTICULAR PURPOSE.                                         |
| ------------------------------------------------------------------------- |
| We offer a number of paid services (www.codeworxtech.com):                |
| - Web Hosting on highly optimized fast and secure servers                 |
| - Technology Consulting                                                   |
| - Oursourcing (highly qualified programmers and graphic designers)        |
'---------------------------------------------------------------------------'

/**
 * PHPMailer-ML - PHP mailing list manager
 * @package PHPMailer-ML
 * @author Andy Prevost
 * @copyright 2004 - 2009 Andy Prevost. All Rights Reserved.
 */

if ( ini_get( 'zlib.output_compression' ) ) {
  if ( ini_get( 'zlib.output_compression_level' ) != 5) {
    ini_set( 'zlib.output_compression_level', '5' );
  }
  ob_start();
} else {
  if(strstr($_SERVER['HTTP_ACCEPT_ENCODING'],"gzip")) {
    ob_start("ob_gzhandler");
  } else {
    ob_start();
  }
}

session_start();
session_register("return_msg");
session_register("acp");

if ($_SESSION['acp'] == '') {
  $_SESSION['acp'] = '_acp-ml';
}

require_once($_SESSION['acp'] . '/inc.settings.php');
require_once($_SESSION['acp'] . '/inc.functions.php');

echo '<link href="' . $_SESSION['acp'] . '/appimgs/styles.css" rel="StyleSheet" />';

$continueLink = "<a href=\"index.php\">" . $PHPML_LANG["click_continue"] . "</a><br />\n";

if ($_GET['pg'] == 'd') {
  include_once("inc.proc.php");
} elseif ($_GET['pg'] == 'subscribe' || $_GET['pg'] == 'add') {
  include_once("inc.proc.php");
} elseif ($_SESSION['return_msg'] == '') {
  include_once("subscribe.php");
} else {
  echo $_SESSION['return_msg'];
  echo "<br /><br />\n" . $continueLink . "<br /><br />\n";
}

$_SESSION['return_msg'] = '';

?>
