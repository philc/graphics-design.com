<?PHP

/*
***************************************************
***************************************************
*          :: PHP Super Counter v1.01 ::          *
* Coded by Roel S.F. Abspoel (roel@abspoel.com)   *
* http://www.abspoel.com/roel-karin/download.php  *
***************************************************
***************************************************
*/

require("/home/philisoft/scripts/graphics/dbvars.php");

$SQL_HOST="$dbAddress";
$SQL_USER="$dbUser";
$SQL_PWD="$dbPassword";
$SQL_DB="$dbDatabase";
$SQL_COUNTTABLE="SC_COUNTER";
$SQL_LOGTABLE="SC_LOG";

$TABLE_HEAD_COLOR = "#CCCCCC";
$TABLE_COLOR = "#0099CC";
$TEXT_COLOR = "#000066";


function show_totalhits() {

  unset($sqlrow);

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $COUNTERNAME = "VISITS";
  $REFERENCE = "All Pages";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
  $result = mysql_query($query)
            or die(mysql_error());
  $sqlrow = @mysql_fetch_array($result);
  $hits = $sqlrow["SC_COUNTER"];

  echo "$hits";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_totalhits_countdate() {
  $hits_since = date("F j, Y",mktime (0, 0, 0, date("m"),     date("d") , date("Y")));
  echo "$hits_since";
  return;
  exit;
}

function show_totalhits_currentpage() {
  $u_referrer = @getenv("SCRIPT_NAME");

  unset($sqlrow);

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $COUNTERNAME = $u_referrer;
  $REFERENCE = "PAGE";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
  $result = mysql_query($query)
              or die(mysql_error());
  $sqlrow = @mysql_fetch_array($result);
  $hitspage = $sqlrow["SC_COUNTER"];
  echo "$hitspage";

  mysql_free_result($result);
  mysql_close($link);

  //return $hits_since;
  return;
  exit;
}



function show_todayhits() {
  unset($sqlrow);
  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $TODAY_STAMP = strtotime(DATE("F j Y"));
  $query ="SELECT * FROM $GLOBALS[SQL_LOGTABLE] WHERE (SC_TIMESTAMP > \"$TODAY_STAMP\")";
  //echo "$query";
  $result = mysql_query($query)
            or die(mysql_error());

  $hits_today = @mysql_num_rows($result);

  echo "$hits_today";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_thismonthhits() {
  unset($sqlrow);
  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  //$TODAY_STAMP = strtotime((DATE("F"));
  $TODAY_STAMP = mktime (0, 0, 0, date("m") - 1, date("d"), date("Y"));

  $query ="SELECT * FROM $GLOBALS[SQL_LOGTABLE] WHERE (SC_TIMESTAMP > \"$TODAY_STAMP\")";
  //echo "$query";
  $result = mysql_query($query)
            or die(mysql_error());

  $hits_thismonth = @mysql_num_rows($result);

  echo "$hits_thismonth";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_currentlyonline() {

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $TODAY_STAMP = (time() - 300);
  //echo "$TODAY_STAMP<br>";
  $query ="SELECT * FROM $GLOBALS[SQL_LOGTABLE] WHERE (SC_TIMESTAMP > \"$TODAY_STAMP\")";
  //echo "$query<br>";
  $result = mysql_query($query)
            or die(mysql_error());

  $hits_thismonth = @mysql_num_rows($result);

  echo "$hits_thismonth";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_countryhits() {

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $REFERENCE = "LANGUAGE";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") ORDER BY SC_COUNTER desc";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);

  echo "<table width=100% border=0 cellpadding=1 cellspacing=1><tr bgcolor=\"$GLOBALS[TABLE_HEAD_COLOR]\"><td>";
  echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><b>Country</b></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\"><b>Hits</b></font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  while ($sqlrow = @mysql_fetch_array($result))
  {
    echo "<font color=\"$GLOBALS[TEXT_COLOR]\">" . $sqlrow["SC_NAME"] . "</font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\">". $sqlrow["SC_COUNTER"] . "</font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  }
  echo "</td></tr></table>";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_oshits() {

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $REFERENCE = "OS";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") ORDER BY SC_COUNTER desc";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);

  echo "<table width=100% border=0 cellpadding=1 cellspacing=1><tr bgcolor=\"$GLOBALS[TABLE_HEAD_COLOR]\"><td>";
  echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><b>Operating System</b></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\"><b>Hits</b></font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  while ($sqlrow = @mysql_fetch_array($result))
  {
    echo "<font color=\"$GLOBALS[TEXT_COLOR]\">" . $sqlrow["SC_NAME"] . "</font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\">". $sqlrow["SC_COUNTER"] . "</font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  }
  echo "</td></tr></table>";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_browserhits() {

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $REFERENCE = "BROWSER";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") ORDER BY SC_COUNTER desc";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);

  echo "<table width=100% border=0 cellpadding=1 cellspacing=1><tr bgcolor=\"$GLOBALS[TABLE_HEAD_COLOR]\"><td>";
  echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><b>Browser</b></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\"><b>Hits</b></font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  while ($sqlrow = @mysql_fetch_array($result))
  {
    echo "<font color=\"$GLOBALS[TEXT_COLOR]\">" . $sqlrow["SC_NAME"] . "</font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\">". $sqlrow["SC_COUNTER"] . "</font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  }
  echo "</td></tr></table>";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_referrerhits() {

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $REFERENCE = "REFERRER";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") ORDER BY SC_COUNTER desc";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);

  echo "<table width=100% border=0 cellpadding=1 cellspacing=1><tr bgcolor=\"$GLOBALS[TABLE_HEAD_COLOR]\"><td>";
  echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><b>Page of origin</b></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\"><b>Hits</b></font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  while ($sqlrow = @mysql_fetch_array($result))
  {
    if ($sqlrow["SC_NAME"] == "Bookmark or other") {
      echo "<font color=\"$GLOBALS[TEXT_COLOR]\">" . $sqlrow["SC_NAME"] . "</font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\">". $sqlrow["SC_COUNTER"] . "</font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
    }
    else {
      echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><a href=" . $sqlrow["SC_NAME"] . " target=_BLANK>" . $sqlrow["SC_NAME"] . "</a></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\">". $sqlrow["SC_COUNTER"] . "</font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
    }
  }
  echo "</td></tr></table>";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

function show_pagehits() {

  $link = mysql_connect($GLOBALS[SQL_HOST], $GLOBALS[SQL_USER], $GLOBALS[SQL_PWD])
          or die(mysql_error());

  mysql_select_db($GLOBALS[SQL_DB])
  or die(mysql_error());

  $REFERENCE = "PAGE";
  $query ="SELECT * FROM $GLOBALS[SQL_COUNTTABLE] WHERE (SC_REFERENCE LIKE \"$REFERENCE\") ORDER BY SC_COUNTER desc";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);

  echo "<table width=100% border=0 cellpadding=1 cellspacing=1><tr bgcolor=\"$GLOBALS[TABLE_HEAD_COLOR]\"><td>";
  echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><b>Hit Page</b></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\"><b>Hits</b></font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  while ($sqlrow = @mysql_fetch_array($result))
  {
    echo "<font color=\"$GLOBALS[TEXT_COLOR]\"><a href=" . $sqlrow["SC_NAME"] . " target=_BLANK>" . $sqlrow["SC_NAME"] . "</a></font></td><td><font color=\"$GLOBALS[TEXT_COLOR]\">". $sqlrow["SC_COUNTER"] . "</font></td></tr><tr bgcolor=\"$GLOBALS[TABLE_COLOR]\"><td>\n";
  }
  echo "</td></tr></table>";

  mysql_free_result($result);
  mysql_close($link);

  return;
  exit;
}

?>