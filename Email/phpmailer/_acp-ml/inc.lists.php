<?php
/*~ _acp-ml/inc.lists.php
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

if ( $_GET['nid'] ) {
  $def_list = $_GET['nid'];
  $_SESSION['def_list'] = $def_list;
  echo '<meta http-equiv="refresh" content="0;url=index.php?pg=lists" />';
  exit();
}

if ($_GET['proc'] == "del") {
  foreach ($_POST['frmDelete'] as $key => $value) {
    $query = "DELETE FROM " . $phpml['dbLists'] . "
                WHERE listid = $key";
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    echo $PHPML_LANG["deleted"] . "<br />";
  }
  echo '<meta http-equiv="refresh" content="3;url=index.php?pg=lists" />';
} elseif ($_GET['proc'] == "add" || $_GET['proc'] == "edit") { // section to add a new list
  if ($_POST['frmAction'] == 'save') {
    if ($_POST['frmDisplay'] == "Y") {
      $frmDisplay = 1;
    } else {
      $frmDisplay = 0;
    }
    if ($_GET['proc'] == "add") {
      $query = "INSERT INTO " . $phpml['dbLists'] . "
                  (title,description,display,listowner,listemail)
                VALUES
                  ('" . addslashes($_POST['frmTitle']) . "','" . addslashes($_POST['frmDesc']) . "','$frmDisplay','" . addslashes($_POST['frmOwnerName']) . "','" . addslashes($_POST['frmOwnerEmail']) . "')";
      $langVar = $PHPML_LANG["added"];
    } else {
      $query = "UPDATE " . $phpml['dbLists'] . "
                   SET title = '" . addslashes($_POST['frmTitle']) . "',
                       description = '" . addslashes($_POST['frmDesc']) . "',
                       display = '$frmDisplay',
                       listowner = '" . addslashes($_POST['frmOwnerName']) . "',
                       listemail = '" . addslashes($_POST['frmOwnerEmail']) . "'
                 WHERE listid = " . $_POST['frmListID'];
      $langVar = $PHPML_LANG["updated"];
    }
    $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
    echo '<div class="tpl_table">';
    echo $langVar . "... <br />";
    echo '<meta http-equiv="refresh" content="3;url=index.php?pg=lists" />';
    echo '</div>';
  } else {
    $dbChecked = " checked";
    if ($_GET['proc'] == "edit") {
      $query  = "SELECT *
                   FROM " . $phpml['dbLists'] . "
                  WHERE listid = " . $_GET['id'];
      $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
      $row    = mysql_fetch_assoc($result);
      $dbTitle      = $row['title'];
      $dbDesc       = $row['description'];
      $dbOwnerName  = $row['listowner'];
      $dbOwnerEmail = $row['listemail'];
      if ($row['display'] == 0) {
        $dbChecked = '';
      }
      $def_list = $_GET['id'];
    }
    ?>
    <div class="tpl_table">
      <table class="tpl_listing tpl_form" width="100%" cellpadding="0" cellspacing="0">
        <tr><form action="index.php?pg=lists&proc=<?php echo $_GET['proc']; ?>" method="post">
          <th class="tpl_full" colspan="2"><?php echo $PHPML_LANG["add_new_list"]; ?></th>
        </tr>
        <tr>
          <td width="30%" style="text-align:right;">Title</td>
          <td width="69%" style="text-align:left;"><input name="frmTitle" style="width:250px;" value="<?php echo $dbTitle; ?>"></td>
        </tr>
        <tr>
          <td style="text-align:right;">Description</td>
          <td style="text-align:left;"><input name="frmDesc" style="width:250px;" value="<?php echo $dbDesc; ?>"></td>
        </tr>
        <tr>
          <td style="text-align:right;">List owner name</td>
          <td style="text-align:left;"><input name="frmOwnerName" style="width:250px;" value="<?php echo $dbOwnerName; ?>"></td>
        </tr>
        <tr>
          <td style="text-align:right;">List owner email</td>
          <td style="text-align:left;"><input name="frmOwnerEmail" style="width:250px;" value="<?php echo $dbOwnerEmail; ?>"></td>
        </tr>
        <tr>
          <td style="text-align:right;">Display</td>
          <td style="text-align:left;"><input name="frmDisplay" type="checkbox" value="Y"<?php echo $dbChecked; ?>></td>
        </tr>
        <tr class="tpl_bg">
          <td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo $PHPML_LANG["submit"]; ?>"></td>
        </tr>
        <input type="hidden" name="frmAction" value="save">
        <input type="hidden" name="frmListID" value="<?php echo $_GET['id']; ?>">
        </form>
      </table>
    </div>
    <?php
  }
} else { // display the lists
  $query  = "SELECT *
               FROM " . $phpml['dbLists'];
  $result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
  $num    = mysql_num_rows($result);
  if ($num) {
    ?>
    <div class="tpl_table">
      <table class="tpl_listing tpl_form" width="100%" cellpadding="0" cellspacing="0">
        <tr><form action="index.php?pg=lists&proc=del" method="post">
          <th class="first">List ID</th>
          <th>Title</th>
          <th>Description</th>
          <th>Conf&#039;d</th>
          <th>Display?</th>
          <th colspan="3" class="last">Action</th>
        </tr>
    <?php
    $intNumber = 1;
    while ( $row    = mysql_fetch_assoc($result) ) {
      $dbListID     = $row['listid'];
      $dbTitle      = $row['title'];
      $dbDesc       = $row['description'];
      $dbDisplay    = $row['display'];

      $sql  = "SELECT *
                FROM " . $phpml['dbMembers'] . "
               WHERE listid = '" . $row['listid'] . "'
                 AND confirmed = '1'";
      $resultsql = mysql_query($sql) or die($PHPML_LANG["error_query"] . mysql_error());
      $members   = mysql_num_rows($resultsql);



      echo "<tr";
      echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
      echo ">\n";
      echo "<td class=\"first\">" . $dbListID;
      if ($_SESSION['def_list'] == $dbListID) {
        echo "<b>*</b>";
      }
      echo "</td>\n";
      echo "<td>" . $dbTitle . "</td>\n";
      echo "<td>" . $dbDesc . "</td>\n";
      echo "<td align=\"center\">" . $members . "</td>\n";
      echo "<td align=\"center\">";
      echo ($dbDisplay   == 1) ? "Y" : "N";
      echo "</td>\n";
      if ($dbListID == 1) {
        echo "<td class=\"last\" style=\"text-align:center;\">n/a</td>\n";
      } else {
        echo "<td class=\"last\" style=\"text-align:center;\"><input name=\"frmDelete[" . $dbListID . "]\" type=\"checkbox\" value=\"ON\"";
        echo "/></td>\n";
      }
      echo "<td><a href=\"index.php?pg=lists&proc=edit&id=$dbListID\"><img border=\"0\" src=\"appimgs/page_edit.png\" title=\"" . $PHPML_LANG["edit"] . "\"></a></td>\n";
      if ($_SESSION['def_list'] != $dbListID) {
        echo "<td><a href=\"index.php?pg=lists&nid=" . $dbListID . "\"><img border=\"0\" src=\"appimgs/accept.png\" title=\"" . $PHPML_LANG["makedefault"] . "\"></td>";
      } else {
        echo "<td>&nbsp;</td>\n";
      }
      echo "</tr>\n";
      $intNumber++;
    }
    echo "<tr";
    echo ($intNumber % 2 == 0 ) ? ' class="bg"' : '';
    echo ">\n";
    echo "<td colspan=\"8\" align=\"center\"><input type=\"submit\" name=\"redo\" value=\"" . $PHPML_LANG["deleteselected"] . "\"></td>";
    echo "</tr>";
    echo "</form></table>";
    echo "* = default<br />";
    echo "</div>";
  }
}
echo '</div>';

$pgArr['button'] = '<a href="index.php?pg=lists&proc=add" class="button"><img border="0" src="appimgs/add.png" title="' . $PHPML_LANG["add_new_list"] . '"></a>';
$pgArr['caption'] = $PHPML_LANG["list_records"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "Manage your lists. You have the ability to:<br />
  Add<br />
  Delete<br />";
ob_end_clean();
echo getSkin ($pgArr);

?>
