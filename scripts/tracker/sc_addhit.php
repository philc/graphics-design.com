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

require ("/home/philisoft/www/graphics/scripts/tracker/sc_information.php");
$SQL_COUNTTABLE="SC_COUNTER";
$SQL_LOGTABLE="SC_LOG";
$SQL_REFERENCETABLE="SC_REFERENCE";
$SQL_BLOCKIPTABLE="SC_BLOCKIPS";

$showicon = false;
$os_search = array("Windows 2000", "Windows 98", "Windows 95", "Win95", "Win98", "Windows NT 4.0", "Windows NT 5.0", "Windows NT 5.1", "Windows XP", "Windows ME", "WinNT", "Mac_PowerPC", "Macintosh", "SunOS", "Linux", "Windows NT");
$os = array("Windows 2000", "Windows 98", "Windows 95", "Windows 95", "Windows 98", "Windows NT 4.0", "Windows NT 5.0", "Windows XP", "Windows XP", "Windows ME", "WinNT", "Macintosh", "Macintosh", "SunOS", "Linux", "WinNT");
$browser_search = array("MSIE 6.0", "MSIE 5.5", "MSIE 5.0", "MSIE 4.0","Opera","Konqueror","Mozilla/5", "Mozilla/4", "Mozilla");
$browser = array("Internet Explorer 6","Internet Explorer 5.5", "Internet Explorer 5", "Internet Explorer 4", "Opera","Konqueror","Netscape 6.x", "Netscape 4.x", "Netscape");

$ip = $_SERVER['REMOTE_ADDR'];



  $link = mysql_connect($SQL_HOST, $SQL_USER, $SQL_PWD)
          or die(mysql_error());

  mysql_select_db($SQL_DB)
  or die(mysql_error());


  $time = time();
  $DELOLDTIME = mktime (0, 0, 0, date("m"),     date("d") , date("Y"));
  $COUNTERNAME = "TODAY";
  $REFERENCE = "WHEN";
  $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\") AND (SC_SINCE LIKE \"$DELOLDTIME\")";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);
  if ($sql_numrows == 0) {

    $COUNTERNAME = "VISITS";
    $REFERENCE = "All Pages";
    $query ="DELETE FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE <> \"$REFERENCE\") AND (SC_NAME <> \"$COUNTERNAME\")";
    $result = mysql_query($query)
            or die(mysql_error());

    $COUNTERNAME = "TODAY";
    $REFERENCE = "WHEN";
    $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,\"$DELOLDTIME\")";
    $result = mysql_query($query)
            or die(mysql_error());
  }

  $query ="DELETE FROM $SQL_LOGTABLE WHERE SC_TIMESTAMP <= $DELOLDTIME";
        $result = mysql_query($query)
		or die(mysql_error());


  $query ="SELECT * FROM $SQL_BLOCKIPTABLE WHERE (SC_IP LIKE \"$ip\")";
  $result = mysql_query($query)
            or die(mysql_error());

  $sql_numrows = @mysql_num_rows($result);
  if ($sql_numrows == 0) {


  $time_limit = (time() - 300);
  $ip = $_SERVER['REMOTE_ADDR'];
  $query= "SELECT * FROM $SQL_LOGTABLE WHERE (SC_IP LIKE \"$ip\") AND (SC_TIMESTAMP > \"$time_limit\")";
  $result = mysql_query($query)
  			or die(mysql_error());
  $sql_numrows = @mysql_num_rows($result);
  if ($sql_numrows == 0) {

    $time = time();
    $u_lang = @explode(",", @getenv("HTTP_ACCEPT_LANGUAGE"));
    $u_lang = @strtolower($u_lang[0]);
    if (strlen($u_lang) > 6) { $u_lang = 'Unknown'; }
    elseif (empty($u_lang) == true) { $u_lang = 'Unknown'; }

    $REFERENCE = $u_lang;
    $query ="SELECT * FROM $SQL_REFERENCETABLE WHERE (SC_CODE LIKE \"$REFERENCE\")";
    $result = mysql_query($query)
              or die(mysql_error());

    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $name = "Unknown";
      $query ="INSERT INTO $SQL_REFERENCETABLE (SC_CODE, SC_NAME) VALUES (\"$u_lang\", \"$name\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $u_lang = 'Unknown';
    }
    else {
     $sqlrow = @mysql_fetch_array($result);
     $u_lang = $sqlrow["SC_NAME"];
    }


    $u_referrer = @getenv("HTTP_REFERER");
    if (empty($u_referrer) == true) { $u_referrer = 'Bookmark or other'; }
    $u_page = @getenv("SCRIPT_NAME");
    if (empty($u_page) == true) { $u_page = 'Direct link to counter'; }
    $other = 1;
    while(list($key, $value) = each ($browser_search)) {
      $pos = strpos ($HTTP_USER_AGENT, $value);
      if($pos !== false){
         $IBROWSER = $browser[$key];
        $other = 0;
        break 1;
      }
    }
    if($other != "0"){ $IBROWSER = "Unknown"; }
    $other = 1;
    while(list($key, $value) = each ($os_search)) {
      $pos = strpos ($HTTP_USER_AGENT, $value);
      if($pos !== false){
        $OPSYS = $os[$key];
        $other = 0;
        break 1;
      }
    }
    if($other != 0){ $OPSYS = "Unknown"; }
    $HOSTMASK = gethostbyaddr($REMOTE_ADDR);
    $query ="INSERT INTO $SQL_LOGTABLE (SC_TIMESTAMP ,SC_IP ,SC_HOST ,SC_BROWSER ,SC_OS ,SC_LANGUAGE ,SC_REFFERER ,SC_PAGE) VALUES (\"$time\",\"$ip\",\"$HOSTMASK\",\"$IBROWSER\",\"$OPSYS\",\"$u_lang\",\"$u_referrer\",\"$u_page\")";
    $result = mysql_query($query)
              or die(mysql_error());

    $time = mktime (0, 0, 0, date("m"),     date("d"), date("Y"));
    $COUNTERNAME = "VISITS";
    $REFERENCE = "All Pages";
    $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
    $result = mysql_query($query)
              or die(mysql_error());

    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,$time)";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
    else {
      $query ="UPDATE $SQL_COUNTTABLE SET SC_COUNTER=(SC_COUNTER+1) WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $query ="UPDATE $SQL_COUNTTABLE SET SC_SINCE=$time WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
    }

    $COUNTERNAME = $u_lang;
    $REFERENCE = "LANGUAGE";
    $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
    $result = mysql_query($query)
              or die(mysql_error());


    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,$time)";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
    else {
      $query ="UPDATE $SQL_COUNTTABLE SET SC_COUNTER=(SC_COUNTER+1) WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $query ="UPDATE $SQL_COUNTTABLE SET SC_SINCE=$time WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());


    }

    $COUNTERNAME = $OPSYS;
    $REFERENCE = "OS";
    $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
    $result = mysql_query($query)
              or die(mysql_error());


    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,$time)";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
    else {
      $query ="UPDATE $SQL_COUNTTABLE SET SC_COUNTER=(SC_COUNTER+1) WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $query ="UPDATE $SQL_COUNTTABLE SET SC_SINCE=$time WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
	$COUNTERNAME = $IBROWSER;
	$REFERENCE = "BROWSER";
    $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
    $result = mysql_query($query)
              or die(mysql_error());


    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,$time)";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
    else {
      $query ="UPDATE $SQL_COUNTTABLE SET SC_COUNTER=(SC_COUNTER+1) WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $query ="UPDATE $SQL_COUNTTABLE SET SC_SINCE=$time WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
	$COUNTERNAME = $u_referrer;
	$REFERENCE = "REFERRER";
    $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
    $result = mysql_query($query)
              or die(mysql_error());


    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,$time)";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
    else {
      $query ="UPDATE $SQL_COUNTTABLE SET SC_COUNTER=(SC_COUNTER+1) WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $query ="UPDATE $SQL_COUNTTABLE SET SC_SINCE=$time WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
	$COUNTERNAME = $u_page;
	$REFERENCE = "PAGE";
    $query ="SELECT * FROM $SQL_COUNTTABLE WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME LIKE \"$COUNTERNAME\")";
    $result = mysql_query($query)
              or die(mysql_error());


    $sql_numrows = @mysql_num_rows($result);
    if ($sql_numrows == 0) {
      $query ="INSERT INTO $SQL_COUNTTABLE (SC_REFERENCE ,SC_NAME ,SC_COUNTER ,SC_SINCE) VALUES (\"$REFERENCE\",\"$COUNTERNAME\" ,1 ,$time)";
      $result = mysql_query($query)
	        or die(mysql_error());
    }
    else {
      $query ="UPDATE $SQL_COUNTTABLE SET SC_COUNTER=(SC_COUNTER+1) WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
      $query ="UPDATE $SQL_COUNTTABLE SET SC_SINCE=$time WHERE (SC_REFERENCE LIKE \"$REFERENCE\") AND (SC_NAME = \"$COUNTERNAME\")";
      $result = mysql_query($query)
	        or die(mysql_error());
    }


    if ($GLOBALS[showicon] == true) { echo "<a href=sc_stats.php target=new><img src=scicon.gif alt=\"Visit logged by PHP Super Counter.\" border=0></a>"; }

  }
  else {
     if ($GLOBALS[showicon] == true) { echo "<a href=sc_stats.php target=new><img src=scicon.gif alt=\"Your Visit was already logged by PHP Super Counter.\" border=0></a>"; }
  }

  }
  else {
    if ($GLOBALS[showicon] == true) { echo "<a href=sc_stats.php target=new><img src=scicon.gif alt=\"This IP is blocked. Hit has been ignored.\" border=0></a>"; }
  }




  mysql_close($link);


?>
