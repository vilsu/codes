<?php
/*~ _acp-ml/inc.configuration.php
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

defined('_WRX') or die( _errorMsg('Restricted access') );

echo '<div align="center">';
echo '<br />';

if (is_writable('inc.settings.php') && $_POST['frmAction'] == "save" ) {
  $frmType         = trim($_POST['frmType']);
  $frmSMTPhost     = trim($_POST['frmSMTPhost']);
  $frmSMTPauth     = trim($_POST['frmSMTPauth']);
  $frmSMTPusername = trim($_POST['frmSMTPusername']);
  $frmSMTPpassword = trim($_POST['frmSMTPpassword']);
  $frmSMTPport     = trim($_POST['frmSMTPport']);

  $frmEmailName     = trim($_POST['frmEmailName']);
  $frmEmailAddy     = trim($_POST['frmEmailAddy']);
  $frmLangPref      = trim($_POST['frmLangPref']);
  $frmAppName       = trim($_POST['frmAppName']);
  if ( trim($_POST['frmBcc']) == 'ON' ) {
    $frmBcc           = 'true';
  } else {
    $frmBcc           = 'false';
  }
  if ( trim($_POST['frmSendEmails']) == 'ON' ) {
    $frmSendEmails    = 'true';
  } else {
    $frmSendEmails    = 'false';
  }
  if ( trim($_POST['frmAdminBcc']) == 'ON' ) {
    $frmAdminBcc    = 'true';
  } else {
    $frmAdminBcc    = 'false';
  }
  $frmDBhost       = trim($_POST['frmDBhost']);
  $frmDBname       = trim($_POST['frmDBname']);
  $frmDBuser       = trim($_POST['frmDBuser']);
  $frmDBpass       = trim($_POST['frmDBpass']);
  $buildLines      = '';
  $handle          = fopen("inc.settings.php", "r");
  $minLength       = 24;
  if ($handle) {
    while (!feof($handle)) {
      $line = fgets($handle, 4096);
      // SMTP / Sendmail
      $testStart = '$phpml[\'SendType\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmType . "';\n";
      }
      $testStart = '$phpml[\'SMTPhost\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmSMTPhost . "';\n";
      }
      $testStart = '$phpml[\'SMTPauth\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        if ( $frmSMTPauth == '' ) { $frmSMTPauth = "''"; }
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = " . $frmSMTPauth . ";\n";
      }
      $testStart = '$phpml[\'SMTPpassword\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmSMTPusername . "';\n";
      }
      $testStart = '$phpml[\'SMTPusername\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmSMTPpassword . "';\n";
      }
      $testStart = '$phpml[\'SMTPport\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmSMTPport . "';\n";
      }
      // Preferences
      $testStart = '$phpml[\'FromAddy\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmEmailName . "';\n";
      }
      $testStart = '$phpml[\'FromName\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmEmailAddy . "';\n";
      }
      $testStart = '$phpml[\'LangPref\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmLangPref . "';\n";
      }
      $testStart = '$phpml[\'ListName\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = '" . $frmAppName . "';\n";
      }
      $testStart = '$phpml[\'useBcc\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = " . $frmBcc . ";\n";
      }
      $testStart = '$phpml[\'EmailSend\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = " . $frmSendEmails . ";\n";
      }
      $testStart = '$phpml[\'adminBcc\']';
      if (substr($line,0,strlen($testStart)) == $testStart) {
        $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
        $line = $testStart . " = " . $frmAdminBcc . ";\n";
      }
      // Database
      if ( DBHOST == '' || DBNAME == '' || DBUSER == '' || DBPASSWD == '' ) {
        $testStart = 'define(\'DBHOST\',';
        if (substr($line,0,strlen($testStart)) == $testStart) {
          $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
          $line = $testStart . " '" . $frmDBhost . "');\n";
        }
        $testStart = 'define(\'DBNAME\',';
        if (substr($line,0,strlen($testStart)) == $testStart) {
          $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
          $line = $testStart . " '" . $frmDBname . "');\n";
        }
        $testStart = 'define(\'DBUSER\',';
        if (substr($line,0,strlen($testStart)) == $testStart) {
          $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
          $line = $testStart . " '" . $frmDBuser . "');\n";
        }
        $testStart = 'define(\'DBPASSWD\',';
        if (substr($line,0,strlen($testStart)) == $testStart) {
          $testStart = $testStart.str_repeat(" ", ($minLength - strlen($testStart)) );
          $line = $testStart . " '" . $frmDBpass . "');\n";
        }
      }
      $buildLines .= $line;
    }
    fclose($handle);
  }
  if ($buildLines != '') {
    $handle          = fopen("inc.settings.php", "w+");
    if ($handle) {
      fwrite($handle, $buildLines);
    }
    fclose($handle);
  }

  echo $PHPML_LANG["updating"] . " ...<br />";
  echo '<meta http-equiv="refresh" content="3;url=index.php?pg=opt" />';
  exit();
} else {
  ?>
  <script type="text/javascript">
  function changeState() {
    if ( document.configform.frmType.value == 'smtp' ) {
      document.configform.frmSMTPauth.removeAttribute('disabled');
      document.configform.frmSMTPhost.removeAttribute('disabled');
      document.configform.frmSMTPusername.removeAttribute('disabled');
      document.configform.frmSMTPpassword.removeAttribute('disabled');
      document.configform.frmSMTPport.removeAttribute('disabled');
      document.getElementById('displaySMTP').setAttribute("style", "display:block;");
    } else {
      document.configform.frmSMTPhost.value        = '';
      document.configform.frmSMTPusername.value    = '';
      document.configform.frmSMTPpassword.value    = '';
      document.configform.frmSMTPport.value        = '';

      document.configform.frmSMTPauth.disabled     = "true";
      document.configform.frmSMTPhost.disabled     = "true";
      document.configform.frmSMTPusername.disabled = "true";
      document.configform.frmSMTPpassword.disabled = "true";
      document.configform.frmSMTPport.disabled     = "true";
      document.getElementById('displaySMTP').setAttribute("style", "display:none;");
    }
  }
  </script>
  <?php
  $optBuild = '<select name="frmType" onchange="changeState();">';
  /* Sendmail */
  $optBuild .= '<option';
  $optBuild .= ($phpml['SendType'] == 'sendmail') ? ' selected' : '';
  $optBuild .= ' value="sendmail">Sendmail</option>';
  /* SMTP */
  $optBuild .= '<option';
  $optBuild .= ($phpml['SendType'] == 'smtp') ? ' selected' : '';
  $optBuild .= ' value="smtp">SMTP</option>';
  $optBuild .= '</select>';

  if ($phpml['SMTPauth'] === false) {
    $smtpAuth  = '<select name="frmSMTPauth"';
    if ( $phpml['SendType'] != 'smtp' ) { $smtpAuth .= ' disabled="disabled"'; };
    $smtpAuth .= '<option value="true">' . $PHPML_LANG["true"] . '</option>';
    $smtpAuth .= '><option selected value="false">' . $PHPML_LANG["false"] . '</option>';
    $smtpAuth .= '</select>';
  } else {
    $smtpAuth  = '<select name="frmSMTPauth"';
    if ( $phpml['SendType'] != 'smtp' ) { $smtpAuth .= ' disabled="disabled"'; };
    $smtpAuth .= '><option selected value="true">' . $PHPML_LANG["true"] . '</option>';
    $smtpAuth .= '<option value="false">' . $PHPML_LANG["false"] . '</option>';
    $smtpAuth .= '</select>';
  }
  ?>
  <div class="tpl_table">
    <table class="tpl_listing tpl_form" width="95%" cellpadding="0" cellspacing="0">
      <tr><form name="configform" action="index.php?pg=opt" method="post">
        <th class="full" colspan="2"><?php echo strtoupper($PHPML_LANG["settings_email"]); ?></th>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["type"]; ?></td>
        <td width="69%" style="text-align:left;"><?php echo $optBuild; ?></td>
      </tr>
    </table>
    <?php
    if ( $phpml['SendType'] != 'smtp' ) {
      ?>
      <div style="display:none;" id="displaySMTP">
      <?php
    } else {
      ?>
      <div style="display:block;" id="displaySMTP">
      <?php
    }
    ?>
    <table class="tpl_listing tpl_form" width="95%" cellpadding="0" cellspacing="0">
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["SMTPhost"]; ?></td>
        <td width="69%" style="text-align:left;"><input name="frmSMTPhost" style="width:250px;" value="<?php echo $phpml['SMTPhost']; ?>" <?php if ( $phpml['SendType'] != 'smtp' ) { echo ' disabled="disabled"'; } ?>></td>
      </tr>
      <tr>
        <td style="text-align:right;"><?php echo $PHPML_LANG["SMTPauth"]; ?></td>
        <td style="text-align:left;"><?php echo $smtpAuth; ?></td>
      </tr>
      <tr>
        <td style="text-align:right;"><?php echo $PHPML_LANG["SMTPusername"]; ?></td>
        <td style="text-align:left;"><input name="frmSMTPusername" style="width:250px;" value="<?php echo $phpml['SMTPusername']; ?>"<?php if ( $phpml['SendType'] != 'smtp' ) { echo ' disabled="disabled"'; } ?>></td>
      </tr>
      <tr>
        <td style="text-align:right;"><?php echo $PHPML_LANG["SMTPpassword"]; ?></td>
        <td style="text-align:left;"><input name="frmSMTPpassword" style="width:250px;" value="<?php echo $phpml['SMTPpassword']; ?>"<?php if ( $phpml['SendType'] != 'smtp' ) { echo ' disabled="disabled"'; } ?>></td>
      </tr>
      <tr>
        <td style="text-align:right;"><?php echo $PHPML_LANG["SMTPport"]; ?></td>
        <td style="text-align:left;"><input name="frmSMTPport" style="width:250px;" value="<?php echo $phpml['SMTPport']; ?>"<?php if ( $phpml['SendType'] != 'smtp' ) { echo ' disabled="disabled"'; } ?>></td>
      </tr>
    </table>
    </div>
    <table class="tpl_listing tpl_form" width="95%" cellpadding="0" cellspacing="0">
      <tr>
        <th class="full" colspan="2"><?php echo strtoupper($PHPML_LANG["preferences"]); ?></th>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["fromname"]; ?></td>
        <td style="text-align:left;"><input name="frmEmailName" style="width:250px;" value="<?php echo $phpml['FromAddy']; ?>"></td>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["fromaddy"]; ?></td>
        <td style="text-align:left;"><input name="frmEmailAddy" style="width:250px;" value="<?php echo $phpml['FromName']; ?>"></td>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["language"]; ?></td>
        <td style="text-align:left;"><select name="frmLangPref"><option selected value="en"> <?php echo $PHPML_LANG["english"]; ?></option></select></td>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["appname"]; ?></td>
        <td style="text-align:left;"><input name="frmAppName" style="width:250px;" value="<?php echo $phpml['ListName']; ?>"></td>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["usebcc"]; ?></td>
        <td style="text-align:left;"><input type="checkbox" name="frmBcc" value="ON" <?php echo ($phpml['useBcc'] === true) ? 'checked' : ''; ?>> <?php echo $PHPML_LANG["usebcc_explain"]; ?></td>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["sendemails"]; ?></td>
        <td style="text-align:left;"><input type="checkbox" name="frmSendEmails" value="ON" <?php echo ($phpml['EmailSend'] === true) ? 'checked' : ''; ?>> <?php echo $PHPML_LANG["sendemails_explain"]; ?></td>
      </tr>
      <tr>
        <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["adminBcc"]; ?></td>
        <td style="text-align:left;"><input type="checkbox" name="frmAdminBcc" value="ON" <?php echo ($phpml['adminBcc'] === true) ? 'checked' : ''; ?>> <?php echo $PHPML_LANG["adminBcc_explain"]; ?></td>
      </tr>
      <?php
      if ( DBHOST == '' || DBNAME == '' || DBUSER == '' || DBPASSWD == '' ) {
        ?>
        <tr>
          <th class="full" colspan="2"><?php echo strtoupper($PHPML_LANG["settings_db"]); ?></th>
        </tr>
        <tr>
          <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["db_host"]; ?></td>
          <td style="text-align:left;"><input name="frmDBhost" style="width:250px;" value="<?php echo DBHOST; ?>"></td>
        </tr>
        <tr>
          <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["db_name"]; ?></td>
          <td style="text-align:left;"><input name="frmDBname" style="width:250px;" value="<?php echo DBNAME; ?>"></td>
        </tr>
        <tr>
          <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["db_user"]; ?></td>
          <td style="text-align:left;"><input name="frmDBuser" style="width:250px;" value="<?php echo DBUSER; ?>"></td>
        </tr>
        <tr>
          <td width="30%" style="text-align:right;"><?php echo $PHPML_LANG["db_pass"]; ?></td>
          <td style="text-align:left;"><input name="frmDBpass" style="width:250px;" value="<?php echo DBPASSWD; ?>"></td>
        </tr>
        <?php
      }
      ?>
      <tr class="bg">
        <td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $PHPML_LANG["submit"]; ?>"></td>
      </tr>
      <input type="hidden" name="frmAction" value="save">
      </form>
    </table>
  </div>
  <?php
}
echo '</div>';
$pgArr['caption'] = $PHPML_LANG["configuration"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "{unsubscribe}<br />
  is a variable that will get substituted for the full unsubscribe link with the subscriber&#039;s ID at time of sending.<br />";
ob_end_clean();
echo getSkin ($pgArr);

?>
