<?php
/*~ inc.proc.php
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

/* Prevent this page from loading without being an "include" of index.php */
IF (strtoupper(basename($_SERVER['SCRIPT_NAME'])) != "INDEX.PHP") {
  echo "<meta http-equiv=\"Refresh\" content=\"0; URL=index.php\">";
  exit();
}

require_once($_SESSION['acp'] . '/inc.settings.php');
require_once($_SESSION['acp'] . '/inc.functions.php');

$ip   = getIP();
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

$_SESSION['return_msg'] = "";

$address  = $_REQUEST['email'];
$memberid = $_REQUEST['mid'];

if ($_REQUEST['action'] == "confirm") {
  echo '<link href="' . $_SESSION['acp'] . '/appimgs/styles.css" rel="StyleSheet" />';
  echo '<div align="center">';
  echo '<br />';
  $mailid  = $_GET['mid'];
  $query   = "UPDATE " . $phpml['dbMembers'] . "
                 SET confirmed = '1'
               WHERE memberid = " . $mailid;
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . ": " . mysql_error($query));
  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE memberid = " . $mailid;
  $result = mysql_query($query) or die($$PHPML_LANG["error_query"] . ": " . mysql_error($query));
  $row    = mysql_fetch_assoc($result);
  $dbFirstName = $row['firstname'];
  $dbLastName  = $row['lastname'];
  $dbEmail     = $row['email'];
  $dbRegi      = $row['regdate'];
  $dbConfirmed = $row['confirmed'];
  $dbApproved  = $row['approved'];
  $dbDeleted   = $row['deleted'];
  $unsubscribeLink = $phpml['url_root'] . '/index.php?pg=d&action=unsubscribe&mid=' . $mailid . '&nid=' . md5($dbEmail);
  $message  = $dbEmail . $PHPML_LANG["now_subscribed_to"] . $phpml['ListName'] . $PHPML_LANG["compose2"] . ".<br /><br />\n";
  $message .= $PHPML_LANG["unsubscribe"] . ": <br />\n";
  $message .= $unsubscribeLink . " <br />\n";
  send_message($dbEmail, $message);
  if ($phpml['adminBcc']) {
    $query  = "SELECT *
                 FROM " . $phpml['dbLists'] . "
                WHERE listid    = 1";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error($query));
    $row = mysql_fetch_assoc($result);
    $phpml['FromName'] = $row['listowner'];
    $phpml['FromAddy'] = $row['listemail'];
    $message = "New subscriber confirmed: " . $dbFirstName . " " . $dbLastName . " (" . $dbEmail . ")";
    send_message($phpml['FromAddy'], $message);
  }
  echo $PHPML_LANG["Confirmed"] . " <br />";
  echo $PHPML_LANG["thankyou"] . " <br />";
  echo '</div>';
  echo '<meta http-equiv="refresh" content="5;url=index.php" />';
  exit(); // exiting here so that we don't display default page
} elseif ($_REQUEST['action'] == "subscribe") {
  if ($address) {
    $first   = addslashes($_POST['firstname']);
    $last    = addslashes($_POST['lastname']);
    $city    = addslashes($_POST['city']);
    $state   = addslashes($_POST['state']);
    $country = addslashes($_POST['country']);
    $message = addslashes($_POST['message']);
    if (is_subscribed($address,$listid) === false) {
      if ( is_array($_POST['frmWhichList']) ) {
        $linkmsg = '';
        foreach ($_POST['frmWhichList'] as $value) {
          $listid  = $value;
          // insert into database
          $query = "INSERT INTO " . $phpml['dbMembers'] . "
                      ( listid,email,firstname,lastname,city,state,country,message,regdate,IP,RH )
                    VALUES
                      ( '$listid','$address','$first','$last','$city','$state','$country','$message','" . time() . "','$ip','$host' )";
          $result = mysql_query($query) or die($PHPML_LANG["error_query"] . ": " . mysql_error());
          $mailid = mysql_insert_id();
          $confirmLink = $phpml['url_root'] . '/index.php?pg=subscribe&action=confirm&mid=' . $mailid;
          $linkmsg .= $PHPML_LANG["selfsubscribe1"] . '<a href="' . $confirmLink . '">' . $confirmLink . '</a> <br />' . "\n";
        }
        $linkmsg .= $PHPML_LANG["selfsubscribe2"];
      } else {
        $listid  = addslashes($_POST['frmWhichList']);
        // insert into database
        $query = "INSERT INTO " . $phpml['dbMembers'] . "
                    ( listid,email,firstname,lastname,city,state,country,message,regdate,IP,RH )
                  VALUES
                    ( '$listid','$address','$first','$last','$city','$state','$country','$message','" . time() . "','$ip','$host' )";
        $result = mysql_query($query) or die($PHPML_LANG["error_query"] . ": " . mysql_error());
        $mailid = mysql_insert_id();
        // send confirmation email
        $confirmLink = $phpml['url_root'] . '/index.php?pg=subscribe&action=confirm&mid=' . $mailid;
        $linkmsg  = $PHPML_LANG["selfsubscribe1"] . '<a href="' . $confirmLink . '">' . $confirmLink . '</a> <br />' . "\n";
        $linkmsg .= $PHPML_LANG["selfsubscribe2"];
        $linkmsg .= "<br /><br />\nLinks to: " . $confirmLink . " <br />\n";
      }
      send_message($address, $linkmsg);
      // return message
      $_SESSION['return_msg'] = $address . $PHPML_LANG["now_registered"] . $PHPML_LANG["subscribe_confirm"] . "  <br/><br />\n";
    } else {
      $_SESSION['return_msg'] = $address . $PHPML_LANG["already_subscribed"] . "<br/><br />\n";
    }
  } else {
    $_SESSION['return_msg'] = $PHPML_LANG["no_email"];
  }
} elseif ($_REQUEST['action'] == "unsubscribe") {
  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE memberid = " . $memberid . "
                AND md5(email) = '" . $_GET['nid'] . "'";
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . ": " . mysql_error());
  if ($row    = mysql_fetch_assoc($result)) {
    $dbFirstName = $row['firstname'];
    $dbLastName  = $row['lastname'];
    $dbEmail     = $row['email'];
    $dbRegi      = $row['regdate'];
    $dbConfirmed = $row['confirmed'];
    $dbApproved  = $row['approved'];
    $dbDeleted   = $row['deleted'];
    $newEmail    = str_replace('@','[at]',$dbEmail);
    if (is_subscribed($dbEmail)) {
      $query   = "UPDATE " . $phpml['dbMembers'] . "
                     SET email = '" . $newEmail . "',
                         confirmed = '0',
                         deleted = '1',
                         deldate = '" . time() . "',
                         IP = CONCAT(IP, '," . $ip . "')
                   WHERE memberid = " . $memberid;
      $result = mysql_query($query) or die($PHPML_LANG["error_query"] . ": " . mysql_error());
      $_SESSION['return_msg'] .= $dbEmail . $PHPML_LANG["unsubscribed"];
      $subscribeLink = $phpml['url_root'] . '/index.php?pg=subscribe';
      $message  = $dbEmail . $PHPML_LANG["now_unsubscribed_from"] . $phpml['ListName'] . $PHPML_LANG["compose2"] . ".<br /><br />\n";
      $message .= $PHPML_LANG["subscribe"] . ":<br />\n";
      $message .= $subscribeLink . " <br />\n";
      send_message($dbEmail, $message);
      if ($phpml['adminBcc']) {
        $query  = "SELECT *
                     FROM " . $phpml['dbLists'] . "
                    WHERE listid    = 1";
        $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error($query));
        $row = mysql_fetch_assoc($result);
        $phpml['FromName'] = $row['listowner'];
        $phpml['FromAddy'] = $row['listemail'];
        $message = "Member has unsubscribed: " . $dbFirstName . " " . $dbLastName . " (" . $dbEmail . ")";
        send_message($phpml['FromAddy'], $message);
      }
      echo '<meta http-equiv="refresh" content="0;url=index.php" />';
      exit();
    } else {
      $_SESSION['return_msg'] = $address . $PHPML_LANG["not_subscribed"];
    }
  } else {
    $_SESSION['return_msg'] = $PHPML_LANG["error_unsubscribe"];
  }
}

$url = $phpml['ReturnPage'];
echo "<meta http-equiv=\"Refresh\" content=\"0; URL=$url\">";
exit();

/* FUNCTIONS ************************************ */

function send_message($address, $message) {
  global $phpml;

  require_once($phpml['PHPMailer_path'] . "/class.html2text.php"); // added by Steve Morton
  $rc = false;
  if ($phpml['EmailSend']) {
    if ( !class_exists( "MyMailer" ) ) {
      _load_PHPMailer();
    }
    // code added by Steve Morton
    $h2t     =& new html2text($message);
    $textmsg = $h2t->get_text();
    // end of code added by Steve Morton
    $mail = new MyMailer;
    $mail->Subject = stripslashes('[' . $phpml['ListName'] . '] Mailing List' );
    // code added by Steve Morton
    $mail->AltBody    = $textmsg;
    $mail->MsgHTML($message);
    // end of code added by Steve Morton
    $mail->AddAddress($address);
    if(!$mail->Send()) {
      $_SESSION['return_msg'] = "There has been a mail error sending to " . $address . ": " . $mail->ErrorInfo;
    } else {
      $rc = true;
    }
    $mail->ClearAddresses();
  }
  return $rc;
}

function is_subscribed($address,$listid='1') {
  global $phpml;

  $query  = "SELECT *
               FROM " . $phpml['dbMembers'] . "
              WHERE email = '" . $address . "'
                AND listid = '" . $listid . "'";
  $result = mysql_query($query) or die($$PHPML_LANG["error_query"] . ": " . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num == 0) {
    return false;
  } else {
    return true;
  }
}

?>
