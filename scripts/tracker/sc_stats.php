<!-- :: PHP Super Counter v1.01 :: -->
<!-- Coded by Roel S.F. Abspoel (roel@abspoel.com) -->
<!-- http://www.abspoel.com/roel-karin/download.php -->

<HTML><HEAD>
<script language="JavaScript">
<!--
<!-- Begin
function printPage() {
  window.print();
}
//  End -->

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<?PHP INCLUDE"/home/philisoft/www/graphics/scripts/tracker/sc_information.php"; ?>
<title>Super Counter :: Statistics</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="author" content="root">
<meta name="Publisher" content="Roel S.F. Abspoel">
<meta name="Copyright" content="� 2003">
<meta name="Keywords" content="super,counter,php,statistics,hits,counter,country,browser,refferer,page">
<meta name="Description" content="These statistics are generated by PHP Super Counter v1.00 by Roel S.F. Abspoel, http://www.abspoel.com/roel-karin/download.php">
<meta name="Page-topic" content="PHP Super Counter :: Statistics">
<meta name="Audience" content="All">
<meta name="Content-language" content="EN">
<meta name="Page-type" content="Statistics">
<meta name="Robots" content="INDEX,FOLLOW">
</HEAD>
<BODY bgcolor="#EEEEEE" text="#000066" link="#990000" vlink="#990000" alink="#000066">
<div align="center"><b><font color="#999999" size="7"><a name="global"></a></font></b>
  <table width="80%" border="1" cellspacing="0" cellpadding="0" bordercolor="#999999">
    <tr>
      <td bgcolor="#CCCCCC" valign="middle">
        <div align="center">
          <p><b><font color="#999999" size="7">:: Super Counter :: </font></b><font size="7"><b><font color="#999999">Statistics</font></b></font></p>
          </div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="19%">
              <div align="center"><img src="sclogo.gif" width="150" height="150" alt="Super Counter"></div>
            </td>
            <td width="63%">
              <p align="center"><b><font size="6" color="#999999"><b>Statistics
                for :</b> <b><font color="#990000">
                <?PHP show_totalhits_countdate(); ?>
                </font></b></font></b></p>
              <p align="center"><b><font size="6" color="#999999">Total hits since
                activation:</font></b><font size="6" color="#990000"> </font>
                <b><font size="6" color="#990000">
                <?PHP show_totalhits(); ?>
                </font></b></p>
              <p align="center"><b><font color="#999999" size="7">
                <input type="submit" name="Submit" value="Print this page" onClick="MM_callJS('window.print();')">
                </font></b></p>
            </td>
            <td width="18%">
              <div align="right"><img src="sclogo.gif" width="150" height="150" alt="Super Counter"></div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">
        <div align="center"><font size="2"><b><font color="#999999" size="4">Global
          statistics</font><font color="#999999"> - <a href="#country">Country
          statistics</a> - <a href="#os">Operating System statistics</a> - <a href="#browser">Browser
          statistics</a> - <a href="#referer">Referer statistics</a> - <a href="#page">Page
          count statistics</a></font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">
        <p>&nbsp;</p><table border=0 width=100%>
          <tr>
            <td width="28%">
              <div align="center"><font color="#999999"><b>Hits today:</b> </font><font size="4" color="#999999">
                <?PHP show_todayhits(); ?>
                </font></div>
            </td>
            <td width="38%">
              <div align="center"><font color="#999999"><b>Hits this month: </b></font><font size="4" color="#999999">
                <?PHP show_thismonthhits(); ?>
                </font><font color="#999999"> </font></div>
            </td>
            <td width="34%">
              <div align="center"><font color="#999999"><b>Currently online:</b>
                </font><font size="4" color="#999999">
                <?PHP show_currentlyonline();?>
                </font><font color="#999999"> </font></div>
            </td>
          </tr>
        </table>
        <p align="center"><font color="#999999">The statistics below this line
          are generated from the traffic recieved today:</font></p>
      </td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">
        <div align="center"><font size="2"><b><font color="#999999"><a name="country"></a></font><font size="2"><b><font color="#999999"><a href="#global">Global
          statistics</a> - <font size="4">Country statistics</font> - <a href="#os">Operating
          System statistics</a> - <a href="#browser">Browser statistics</a> -
          <a href="#referer">Referer statistics</a> - <a href="#page">Page count
          statistics</a></font></b></font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"> <font color="#999999">
        <?PHP show_countryhits(); ?>
        </font></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">
        <div align="center"><font size="2"><b><font color="#999999"><a name="os"></a></font><font size="2"><b><font color="#999999"><a href="#global">Global
          statistics</a> - <a href="#country">Country statistics</a> - <font size="4">Operating
          System statistics</font> - <a href="#browser">Browser statistics</a>
          - <a href="#referer">Referer statistics</a> - <a href="#page">Page count
          statistics</a></font></b></font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><font color="#999999">
        <?PHP show_oshits(); ?>
        </font></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">
        <div align="center"><font size="2"><b><font color="#999999"><a name="browser"></a></font><font size="2"><b><font color="#999999"><a href="#global">Global
          statistics</a> - <a href="#country">Country statistics</a> - <a href="#os">Operating
          System statistics</a> - <font size="4">Browser statistics</font> - <a href="#referer">Referer
          statistics</a> - <a href="#page">Page count statistics</a></font></b></font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><font color="#999999">
        <?PHP show_browserhits(); ?>
        </font></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">
        <div align="center"><font size="2"><b><font color="#999999"><a name="referer"></a></font><font size="2"><b><font color="#999999"><a href="#global">Global
          statistics</a> - <a href="#country">Country statistics</a> - <a href="#os">Operating
          System statistics</a> - <a href="#browser">Browser statistics</a> -
          <font size="4">Referer statistics</font> - <a href="#page">Page count
          statistics</a></font></b></font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><font color="#999999">
        <?PHP show_referrerhits(); ?>
        </font></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC">
        <div align="center"><font size="2"><b><font color="#999999"><a name="page"></a></font><font size="2"><b><font color="#999999"><a href="#global">Global
          statistics</a> - <a href="#country">Country statistics</a> - <a href="#os">Operating
          System statistics</a> - <a href="#browser">Browser statistics</a> -
          <a href="#referer">Referer statistics</a> - <font size="4">Page count
          statistics</font></font></b></font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><font color="#999999">
        <?PHP show_pagehits(); ?>
        </font></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC" valign="middle">
        <div align="center">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="4%"><a href="http://www.abspoel.com/roel-karin/download.php" target="_blank"><img src="scicon.gif" width="35" height="35" border="0" alt="PHP SuperCounter"></a></td>
              <td width="93%">
                <div align="center"><font color="#999999"><b>:: <a href="http://www.abspoel.com/roel-karin/download.php" target="_blank">PHP
                  Super Counter</a> version 1.01 &copy; 2003 <a href="http://www.abspoel.com/roel-karin/response.php" target="_blank">Roel
                  S.F. Abspoel</a> :: </b></font></div>
              </td>
              <td width="3%">
                <div align="right"><a href="http://www.abspoel.com/roel-karin/download.php" target="_blank"><img src="scicon.gif" width="35" height="35" border="0" alt="PHP SuperCounter"></a></div>
              </td>
            </tr>
          </table>

        </div>
      </td>
    </tr>
  </table>
</div>
</BODY></HTML>