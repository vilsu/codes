<?php
/*~ _acp-ml/inc.import.php
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

if ( !defined('DBNAME') ) {
  require_once('inc.settings.php');
  require_once('inc.functions.php');
}

if ( !is_writable($phpml['path_admin'] . '/files/') ) {
  $errormsg .= 'Sorry, problem with configuration ... <br />';
  $errormsg .= 'CSV uploads directory is not writable<br />';
  $errormsg .= '(' . $phpml['path_admin'] . '/files/)<br />';
  $errormsg .= 'Please correct and try again.<br /><br />';
  $errormsg = '<div style="font-size:18px;font-weight:bold;color:red;text-align:center;font-family:sans-serif;">' . $errormsg;
  $errormsg .= '</div>';
  echo $errormsg;
  exit();
}

$ignoreFieldsArray = array('memberid','listid','regdate','confirmed','approved','deleted','deldate','IP','RH');

echo "\n";

?>
<style>
#upld table, th, td, input {
  font-family:Arial,Helvetica,sans-serif;
  font-size:11px;
}
</style>
<div id="upld">
<?php
$docontinue = true;
$dbname     = DBNAME; //$_POST['dbname'];
$tablename  = $phpml['dbMembers']; //$_POST['tablename'];
$submit     = $_POST['submit'];
$userfile   = $_POST['userfile'];

if ( trim($_POST['headerRow']) == '1' ) {
  $headerRow = '1';
} else {
  $headerRow = '0';
}

if ( trim($_POST['sepchar']) != '' ) {
  $sepchar = $_POST['sepchar'];
} else {
  $sepchar = 'TAB';
}
if ( trim($_POST['encchar']) != '' ) {
  if ( trim($_POST['encchar']) == '\"' ) {
    $encchar = "&#34;";
  } elseif ( trim($_POST['encchar']) == "\'" ) {
    $encchar = "&#39;";
  }
} else {
  $encchar = '&#34;';
}
$suppressDisplay = true;

if ( trim($_POST['uploadfile']) != '' ) {
  $uploadfile = $_POST['uploadfile'];
}

if( $_FILES ) {
  $uploaddir  = $phpml['path_admin'] . '/files/';
  $filename   = $_FILES['userfile']['name'];
  $uploadfile = $uploaddir . $_FILES['userfile']['name'];
  if ( !move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile) ) {
    print $PHPML_LANG["error_uploading_file"] . "\n";
  }
}

echo "<p align=\"left\">\n";

// select database
if ( trim($dbname) == '' ) {
  $db_list   = mysql_list_dbs();
  while ($row = mysql_fetch_object($db_list)) {
    if ( trim($dbname) == $row->Database ) {
      $cr .= "<option selected value=".$row->Database.">".$row->Database."</option>";
    } else {
      $cr .= "<option value=".$row->Database.">".$row->Database."</option>";
    }
  }
  $db_select="<select Name=\"dbname\">$cr</select>";
} else {
  $cr .= "<option value=".$dbname.">".$dbname."</option>";
  $db_select="<select Name=\"dbname\">$cr</select>";
}

echo "<table>\n";
if ( !$suppressDisplay && !$dbname ) {
  echo "  <tr>\n";
  echo "    <td valign=\"top\"><form name=\"tableselect\" method=\"post\" action=\"index.php?pg=upld\"><nobr>" . $PHPML_LANG["databases"] . ":</nobr><br />" . $db_select . "<input type=\"submit\" value=\"" . $PHPML_LANG["select"] . "\"></form></td>\n";
  echo "  <tr>\n";
  echo "</table>\n";
  echo "</p>\n";
  $docontinue = false;
}

// select table
if ( trim($tablename) == '' && $docontinue ) {
  $result = mysql_list_tables($dbname);
  while ($row = mysql_fetch_array($result)) {
    if ( trim($tablename) == $row[0] ) {
      $cr1 .= "<option selected value=".$row[0].">".$row[0]."</option>";
    } else {
      $cr1 .= "<option value=".$row[0].">".$row[0]."</option>";
    }
  }
  $table_select="<select name=\"tablename\"><option value=\"" . $tablename . "\">" . $tablename . "</option>" . $cr1 . "</select>";
} else {
  $cr1 .= "<option value=" . $tablename . ">" . $tablename . "</option>";
  $table_select = "<select name=\"tablename\">" . $cr1 . "</select>";
}

if ( !$suppressDisplay && !$tablename && $docontinue ) {
  echo "    <td valign=\"top\"><form name=\"tableselector\" method=\"post\" action=\"index.php?pg=upld\"><nobr>Tables:</nobr><br />" . $table_select . "<input type=\"submit\" value=\"" . $PHPML_LANG["select"] . "\"><input type=\"hidden\" name=\"dbname\" value=\"" . $dbname . "\"></form></td>\n";
  echo "  <tr>\n";
  echo "</table>\n";
  echo "</p>\n";
  $docontinue = false;
} elseif ( !$_FILES && trim($uploadfile) == '' )  {
  echo "    <form enctype=\"multipart/form-data\" action=\"index.php?pg=upld\" method=\"post\">\n";
  echo "      <input type=\"hidden\" name=\"dbname\" value=\"" . $dbname . "\">\n";
  echo "      <input type=\"hidden\" name=\"tablename\" value=\"" . $tablename . "\">\n";
  echo "      <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"30000000\" >\n";
  echo "    <td valign=\"top\">\n";
  echo "      " . $PHPML_LANG["uploadfile"] . ":<br /><input name=\"userfile\" type=\"file\" ><br />\n";
  echo "      <div style=\"height:25px;\"></div>\n";
  echo "      <strong>" . $PHPML_LANG["import_options"] . ":</strong><br />\n";
  echo "      <table cellpadding=\"3\">\n";
  echo "        <tr>\n";
  echo "          <td align=\"right\" valign=\"top\">" . $PHPML_LANG["field_separator"] . "</td>\n";
  echo "          <td>";
  echo "            <input type=\"radio\" value=\"comma\" checked name=\"checkSep\"> " . $PHPML_LANG["comma"] . "<br />";
  echo "            <input type=\"radio\" value=\"tab\" name=\"checkSep\"> " . $PHPML_LANG["tab"] . "<br />";
  echo "            " . $PHPML_LANG["or"] . "<br />";
  echo "            <input type=\"text\" name=\"sepchar\" value=\"\"><br />";
  echo "          </td>\n";
  echo "        </tr>\n";
  echo "        <tr>\n";
  echo "          <td align=\"right\" valign=\"top\">" . $PHPML_LANG["field_enclosure"] . "</td>\n";
  echo "          <td>";
  echo "            <input type=\"radio\" value=\"double\" checked name=\"checkEnc\"> " . $PHPML_LANG["quotedouble"] . "<br />";
  echo "            <input type=\"radio\" value=\"single\" name=\"checkEnc\"> " . $PHPML_LANG["quotesingle"] . "<br />";
  echo "            <input type=\"radio\" value=\"none\" name=\"checkEnc\"> " . $PHPML_LANG["none"] . "<br />";
  echo "          </td>\n";
  echo "        </tr>\n";
  echo "        <tr>\n";
  if ( trim($headerRow) == '1' ) {
    echo "          <td colspan=\"2\"><input type=\"checkbox\" name=\"headerRow\" value=\"1\" checked>&nbsp;" . $PHPML_LANG["CSVheader"] . "</td>\n";
  } else {
    echo "          <td colspan=\"2\"><input type=\"checkbox\" name=\"headerRow\" value=\"1\">&nbsp;" . $PHPML_LANG["CSVheader"] . "</td>\n";
  }
  echo "        </tr>\n";
  echo "      </table>\n";
  echo "      <input type=\"submit\" name=\"submit\" value=\"" . $PHPML_LANG["go"] . "\" >\n";
  echo "    </td>\n";
  echo "    </form>\n";
  echo "    </tr>\n";
  mysql_free_result($result);
}

echo "</table>\n";

$tfields = mysql_list_fields($dbname,$tablename);
$columns = mysql_num_fields($tfields);
for ( $i = 0; $i < $columns; $i++ ) {
  if ( !in_array(mysql_field_name($tfields,$i),$ignoreFieldsArray) ) {
    $fieldsArr[] = mysql_field_name($tfields,$i);
  }
}
mysql_free_result($tfields);

if ( $submit == $PHPML_LANG["go"] ) {

  // Field Separator used in CSV file
  if ( trim($_POST['sepchar']) != '' ) {
    if ( trim($_POST['sepchar']) == 'TAB' ) {
      $csv_file['sepa'] = "\t";
    } else {
      $csv_file['sepa'] = trim($_POST['sepchar']);
    }
  } elseif ( trim($_POST['comma']) == 'comma' ) {
    $csv_file['sepa'] = ",";
  } elseif ( trim($_POST['comma']) == 'tab' ) {
    $csv_file['sepa'] = "\t";
  } else {
    $csv_file['sepa'] = ",";
  }
  // Field Enclosure Character used in CSV file

  foreach($_POST as $key => $value) {
    echo $key . ': ' . $value . '<br />';
  }

  if ( trim($_POST['checkEnc']) == '' ) {
    $csv_file['sepatxt'] = "'";
  } elseif ( trim($_POST['checkEnc']) == 'single' ) {
    $csv_file['sepatxt'] = "'";
  } elseif ( trim($_POST['checkEnc']) == 'double' ) {
    $csv_file['sepatxt'] = '"';
  } elseif ( trim($_POST['checkEnc']) == 'none' ) {
    $csv_file['sepatxt'] = '';
  }

  $file_contents_line = @file($uploadfile)
    or die ("CSV file not found.");

  $values = explode($csv_file['sepa'], $file_contents_line[0]);
  if ( $_POST['field'][0] == '' ) {
    for ($v = 0; $v < count($values); $v++) {
      $currValue = trim($values[$v]);
      if ( !in_array($currValue,$fieldsArr) ) {
        echo $PHPML_LANG["need_to_map"] . "<br />";
        echo '<form name="fieldmap" method="post" action="index.php?pg=upld">' . "\n";
        echo "<input type=\"hidden\" name=\"dbname\" value=\"" . $dbname . "\">\n";
        echo "<input type=\"hidden\" name=\"tablename\" value=\"" . $tablename . "\">\n";
        echo "<input type=\"hidden\" name=\"uploadfile\" value=\"" . $uploadfile . "\">\n";
        echo "<input type=\"hidden\" name=\"headerRow\" value=\"" . $headerRow . "\">\n";
        echo "<input type=\"hidden\" name=\"checkSep\" value=\"" . $_POST['checkSep'] . "\">\n";
        echo "<input type=\"hidden\" name=\"checkEnc\" value=\"" . $_POST['checkEnc'] . "\">\n";
        echo "<input type=\"hidden\" name=\"mapproc\" value=\"1\">\n";
        echo '<table border="1" cellpadding="3" style="border-collapse:collapse;">';
        for ($f = 0; $f < count($values); $f++) {
          $p1  = "<select name=\"field[$f]\">\n";
          $p1 .= "<option value=\"none\">- none -</option>\n";
          for ( $p = 0; $p < count($fieldsArr); $p++ ) {
            if ( !in_array($fieldsArr[$p],$ignoreFieldsArray) ) {
              if ( $fieldsArr[$p] == trim($values[$f]) ) {
                $p1 .= "<option selected value=\"" . $fieldsArr[$p] . "\">" . $fieldsArr[$p] . "</option>\n";
              } else {
                $p1 .= "<option value=\"" . $fieldsArr[$p] . "\">" . $fieldsArr[$p] . "</option>\n";
              }
            }
          }
          $p1 .= "</select>\n";
          echo '<tr><td align="right">' . $values[$f] . "</td><td> -> </td><td>" . $p1 . "</td></tr>\n";
        }
        echo '</table><input name="submit" type="submit" value="' . $PHPML_LANG["go"] . '"></form><br />';
        $docontinue = false;
        $v = count($values);
      }
    }
  }

  if ( $docontinue ) {
    $file_contents_line = @file($uploadfile)
      or die ("CSV file not found.");

    $fin = $file_contents_line[0];
    $values = explode($csv_file['sepa'], $fin );
    $inserts2 .= "(`";
    for ($j = 0; $j <= count($values)-1; $j++) {
      if ( $_POST['field'][$j] != 'none' ) {
        if ( trim($_POST['field'][$j]) != '' ) {
          $values[$j] = $_POST['field'][$j];
        }
        $inserts2 .= addslashes(utf8_decode(trim(str_replace("'","",$values[$j]),"[\r\t\n\v\' ]" ))).(($j != (count($values)-1)) ? "`,`" : "");
      }
    }
    $inserts2 .= "`,`regdate`,`confirmed`,`approved`,`listid";
    $inserts2 .= "`)";

    $field1=0;
    $recCount = 0;
    foreach ($file_contents_line as $key => $val) {
      $field1++; //skip field names or first line
      if ( $_POST['mapproc'] != '1' ) {
        if ( empty($val) || $_POST['headerRow'] == '1' ) { // Skip empty lines
          continue;
        }
      }
      $resetvalues = explode($csv_file['sepa'], $val);
      for ($q = 0; $q < count($resetvalues); $q++){
        if ( $_POST['field'][$q] != 'none' ) {
          $newVal[] = $resetvalues[$q];
        }
      }
      $val = implode(",", $newVal);
      unset($newVal);

      if ( ($headerRow != '1' && $field1 == 1) || ($field1 > 1) ) {
        if ( $headerRow != '1' ) {
          $inserts .= ( ($key >= 1) ? ", " : "" ) . "(`";
        } else {
          $inserts .= ( ($key >= 2) ? ", " : "" ) . "(`";
        }
        if ( $csv_file['sepatxt'] != '' ) {
          $prevalues = explode($csv_file['sepatxt'], $val);
          for ($j = 0; $j < count($prevalues); $j++){
            $pos = strpos($prevalues[$j], ",");
            if ($pos === false ) {
               $val1 .= $prevalues[$j];
            } elseif ( $pos > 0 ) {
              $val1 .= str_replace(",","~",$prevalues[$j]);
            } else {
              $val1 .= $prevalues[$j];
            }
          }
        } else {
          $val1 = $val;
        }
        $values = explode($csv_file['sepa'], $val1);
        for ($j = 0; $j <= count($values)-1; $j++) {
          $inserts .= addslashes(utf8_decode(trim(str_replace("~","`,`",$values[$j]),"[\r\t\n\v\' ]"))).(($j != (count($values) - 1)) ? "','" : "");
          $val=$val1="";
          $recCount++;
        }
        $mkdate   = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $inserts .= '`,' . $mkdate . ',`1`,`1`,`' . $_SESSION['def_list'];
        $inserts .= "`)";
      }
    }

    $inserts .=" ;";
    $inserts  = str_replace("`","'",$inserts);
    if ( $inserts != " ;" ) {
      $sql = "INSERT INTO `" . $tablename . "` " . $inserts2 . " VALUES ".$inserts;
    }

    if ( $tablename && $submit == $PHPML_LANG["go"] ) {
      if ( $inserts != " ;" ) {
        $res = mysql_query($sql) or die(mysql_error());
      }
      if ( $res ) {
        echo "<span style=\"font-weight:bold;font-size:18px;\"><br />CSV upload complete - " . $recCount . " records uploaded.</span><br />\n";
      } else {
        echo mysql_error() . "<br />";
      }
      unlink($uploadfile);
      echo "<a href=\"index.php?pg=subscribers\"class=\"button\"><img border=\"0\" src=\"appimgs/accept.png\" title=\"" . $PHPML_LANG["continue"] . "\"></a><br />\n";
    }
  }

}

?>
</div>
<?php
echo '</div>';

$query  = "SELECT *
             FROM " . $phpml['dbLists'] . "
            WHERE listid    = " . $_SESSION['def_list'];
$result = mysql_query($query) or die($PHPML_LANG["error_query"] . mysql_error());
$row = mysql_fetch_assoc($result);

$pgArr['caption'] = $PHPML_LANG["import"] . ' ' . $PHPML_LANG["to"] . ' \'' . $row['title'] . '\' ' . $PHPML_LANG["mailinglist"];
$pgArr['contents'] = ob_get_contents();
$pgArr['help']     = "{firstname}<br />
  {lastname}<br />
  {unsubscribe}<br />
  {reg_date}<br />
  {ip}<br />
  {remote_host}<br />
  are variables that will get substituted with the subscriber&#039;s data at time of sending.<br />";
ob_end_clean();
echo getSkin ($pgArr);

?>
