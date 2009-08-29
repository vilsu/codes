<?php
/*~ _acp-ml/inc.settings.php
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

/* CONFIGURATION SETTINGS (note: trailing slashes on all paths and URLs) */

if ( !$_SESSION ) {
  session_start();
}

/* GENERAL & PATH SETTINGS */

$phpml['FromAddy']       = 'you@yourdomain.com'; // Your email address
$phpml['FromName']       = 'Your Name';           // Your Full Name

// NOTE: You should not have to edit anything below here. If you do, make sure you know what you are doing.
$phpml['iProtocol']      = "http://"; // option is "https://";
$phpml['path_base']      = getBasePath(); // PHPMailer-ML (Mailing List) root path
$phpml['path_root']      = $_SERVER['DOCUMENT_ROOT'] . '/' . $phpml['path_base'];
$phpml['path_admin']     = $phpml['path_root'] . "/" . $_SESSION['acp'];
$phpml['url_root']       = $phpml['iProtocol']  . $_SERVER["HTTP_HOST"] . '/' . $phpml['path_base'];
$phpml['url_admin']      = $phpml['url_root'] . "/" . $_SESSION['acp'];
$phpml['PHPMailer_path'] = $phpml['path_admin'] . "/phpmailer"; // Path to PHPMailer class
$phpml['LangPref']       = 'en';
$phpml['ListName']       = 'PHPMailer-ML';
$phpml['ReturnPage']     = "index.php";    // default return page if HTTP_REFERER not found
$phpml['useBcc']         = false;
$phpml['EmailSend']      = true;
$phpml['adminBcc']       = true;
define('_WRX', 1);

/* include other config and settings */
require_once($phpml['path_root'] . '/_acp-ml/inc.settings_smtp.php');
require_once($phpml['path_root'] . '/_acp-ml/inc.settings_db.php');
require_once($phpml['path_root'] . '/' . $_SESSION['acp'] . '/language/phpml.lang-' . $phpml['LangPref'] . '.php');

/* check writable state of files and folders */
$errormsg = '';
if ( !is_writable($phpml['path_admin'] . '/spaw2/uploads') ) {
  $errormsg .= 'Sorry, problem with configuration ... <br />';
  $errormsg .= 'uploads directory is not writable (for image uploads)<br />';
  $errormsg .= '(' . $phpml['path_admin'] . '/spaw2/uploads/)<br />';
  $errormsg .= 'Please correct and try again.<br /><br />';
}

if ( substr(sprintf('%o', fileperms($phpml['path_admin'] . '/inc.settings.php')), -4) < '0664' ) {
  $errormsg .= 'Sorry, problem with settings file ... <br />';
  $errormsg .= 'settings file is not writable (for updating application settings)<br />';
  $errormsg .= '(' . $phpml['path_admin'] . '/inc.settings.php)<br />';
  $errormsg .= 'Please correct and try again.<br />';
}

if ( $errormsg != '' ) {
  $errormsg = '<div style="font-size:18px;font-weight:bold;color:red;text-align:center;font-family:sans-serif;">' . $errormsg;
  $errormsg .= '</div>';
  echo $errormsg;
  exit();
}

/* FUNCTION */

function getBasePath() {
  $pathSelf    = dirname($_SERVER['PHP_SELF']);
  $pos         = strpos($pathSelf,'_acp');
  if ($pos) {
    $pathSelf = substr($pathSelf,0,$pos);
  }
  if (substr($pathSelf,0,1) == '/') {
    $pathSelf = substr($pathSelf,1);
  }
  if (substr($pathSelf,-1) == '/') {
    $pathSelf = substr($pathSelf,0,-1);
  }
  return $pathSelf;
}
?>