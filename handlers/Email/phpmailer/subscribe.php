<?php
/*~ subscribe.php
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

if (strtoupper(basename($_SERVER['SCRIPT_NAME'])) != "INDEX.PHP") {
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
}

if ($_SESSION['acp'] == '') {
  $_SESSION['acp'] = '_acp-ml';
}

if ( !function_exists('getIP') ) {
  echo '<meta http-equiv="refresh" content="0;url=index.php" />';
  exit();
}

$ip   = getIP();
$host = gethostbyaddr($_SERVER['REMOTE_ADDR']);

error_reporting(E_ALL ^ E_NOTICE);  // All errors execpt E_NOTICE
if ($_POST["country"] != ""){
  $_SESSION['iso3cc']    = $_POST["country"];
} else {
  include_once('_src/inc.ip2cc.php');
  $_SESSION['iso3cc'] = getISO3();
}

?>

<style type="text/css">
<!--
body {
  background-color: #022a57;
  margin-left: 0px;
  margin-top: 5px;
  margin-right: 0px;
  margin-bottom: 5px;
}
body,td,th {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #022A57;
}
.name {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #000000;
  width: 160px;
  background-color: #D7E6FB;
  border: 1px solid #022A57;
  padding-right: 3px;
  padding-left: 3px;
}
.state {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #000000;
  width: 168px;
  background-color: #D7E6FB;
  border: 1px solid #022A57;
}
.address {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #000000;
  width: 160px;
  height:60px;
  background-color: #D7E6FB;
  border: 1px solid #022A57;
  padding-right: 3px;
  padding-left: 3px;
}
.message {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #000000;
  width: 428px;
  height:100px;
  background-color: #D7E6FB;
  border: 1px solid #022A57;
  padding-right: 3px;
  padding-left: 3px;
}
.message2 {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 11px;
  color: #000000;
  width: 300px;
  height:100px;
  background-color: #D7E6FB;
  border: 1px solid #022A57;
  padding-right: 3px;
  padding-left: 3px;
}
-->
</style>
<table width="470" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF" style="border:10px solid #ffffff;">
  <tr>
    <td align="center" valign="top">
      <table width="450" border="0" cellspacing="10" cellpadding="0" >
        <form action="index.php?pg=subscribe" method="post">
        <input type="hidden" name="action" value="subscribe">
        <input type="hidden" name="callback" value="1">
        <input type="hidden" value="countrySelect" name="cs_config_country_field" id="cs_config_country_field">
        <input type="hidden" value="stateSelect"   name="cs_config_state_field"   id="cs_config_state_field">
        <input type="hidden" value="countryDefault" name="cs_config_country_default" id="cs_config_country_default">
        <input type="hidden" value="stateDefault"   name="cs_config_state_default"   id="cs_config_state_default">
        <input type="hidden" value="USA" name="countryDefault" id="countryDefault">
        <input type="hidden" value="" name="stateDefault"   id="stateDefault">
        <script type="text/javascript" src="_src/country_state.js"></script>
        <tr>
          <th colspan="2"><big><big><strong>Subscribe</strong></big></big></th>
        </tr>
        <tr>
          <td align="right" width="50%">First Name:</td>
          <td width="50%"><input type="text" name="firstname" id="firstname" class="name" style="width:300px;" /></td>
        </tr>
        <tr>
          <td align="right" >Last Name:</td>
          <td><input type="text" name="lastname" id="lastname" class="name" style="width:300px;" /></td>
        </tr>
        <tr>
          <td align="right" >City:</td>
          <td><input type="text" name="city" id="city" class="name" style="width:300px;" /></td>
        </tr>
        <tr>
          <td align="right" >State/Province:</td>
          <td><input id='stateSelect' name="state" type="text" value="" class="state" style="width:300px;" maxlength="30" /></td>
        </tr>
        <tr>
          <td align="right" >Country:</td>
          <td><?php require_once('_src/inc.ccdropdown.php'); ?>
            <script type="text/javascript">initCountry(); </script></td>
        </tr>
        <tr>
          <td align="right" >Email:</td>
          <td><input type="text" name="email" id="email" class="name" style="width:300px;" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" >Message:</td>
          <td><input type="text" name="message" id="message" class="message2" /></td>
        </tr>

        <tr>
          <td align="right" >Mailing List:</td>
          <td><?php echo _getList(); ?></td>
        </tr>

        <tr>
          <td colspan="2" align="center"><span class="text13">When you press "Submit", you are agreeing<br />
            to receive our Email Mailer regularly.</span></td>
        </tr>
        <tr>
          <td align="right" valign="top" >&nbsp;</td>
          <td><input type="image" src="_src/btn_submit.jpg"  name="button2" id="button2" />&nbsp;&nbsp;&nbsp;
            <input type="image" src="_src/btn_reset.jpg"  name="button" id="button" /></td>
        </tr>
        <tr>
          <td align="right" valign="top" >&nbsp;</td>
          <td><small><?php echo $ip . "<br />" . $host; ?></small></td>
        </tr>
        </form>
      </table>
    </td>
  </tr>
</table>
<script type="text/javascript">
window.onload = function() {
  var form = document.forms[0];
  if (form != null && form.elements[0] != null) {
    for (var i = 0; i < form.elements.length; ++i) {
      var field = form.elements[i];
      if (field.type!="hidden" && (field.type=="text" || field.type=="textarea")) {
        field.focus();
        break;
      }
    }
  }
}
</script>
