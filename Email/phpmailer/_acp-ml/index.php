<?php
/*~ _acp-ml/index.php
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
session_register("def_list");
session_register("acp");

if ($_SESSION['acp'] == '') {
  $_SESSION['acp'] = '_acp-ml';
}

if ($_GET['pg'] == '') {
  $_GET['pg'] == 'lists';
}

require_once('inc.settings.php');
require_once('inc.functions.php');

if ( $def_list == '' ) {
  if ( trim($_SESSION['def_list']) != '' ) {
    $def_list = $_SESSION['def_list'];
  } else {
    $def_list = 1;
    $_SESSION['def_list'] = $def_list;
  }
}

$pgArr['title'] = "PHPMailer-ML Admin";

$address = $_REQUEST['email'];

ob_start();
if ($_GET['pg'] == "campaigns") {
  require_once("inc.campaigns.php");
  exit(); // exiting here so that we don't display default page
} elseif ($_GET['pg'] == "opt") {
  require_once("inc.configuration.php");
  exit(); // exiting here so that we don't display default page
} elseif ($_GET['pg'] == "subscribers") {
  require_once("inc.subscribers.php");
  exit(); // exiting here so that we don't display default page
} elseif ($_GET['pg'] == "upld") {
  require_once("inc.import.php");
  exit(); // exiting here so that we don't display default page
} elseif ($_GET['pg'] == "lists" || $_GET['pg'] == "") {
  require_once("inc.lists.php");
  exit(); // exiting here so that we don't display default page
}

$url = $phpml['ReturnPage'];
echo "<meta http-equiv=\"Refresh\" content=\"0; URL=$url\">";
exit();

/* FUNCTIONS ************************************ */

function send_message($address, $message) {
  // global $return_msg;
  global $phpml;
  global $PHPML_LANG;

  $rc = false;
  if ($phpml['EmailSend']) {
    $mail = new MyMailer;
    $mail->Subject = stripslashes('[' . $phpml['ListName'] . '] Mailing List' );
    $mail->Body = stripslashes($message);
    $mail->AddAddress($address);
    if(!$mail->Send()) {
      $_SESSION['return_msg'] = $PHPML_LANG["error_sending"] . " (" . $address . "): " . $mail->ErrorInfo;
    } else {
      $rc = true;
    }
    $mail->ClearAddresses();
  }
  return $rc;
}

function is_subscribed($address) {
  //global $return_msg;
  global $phpml;
  global $PHPML_LANG;

  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE email = '" . $address . "'";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num == 0) {
    return false;
  } else {
    return true;
  }
}

?>
