<html>
<title>Portfolio Entry</title>

<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="portfolioAdd.php" method=post>

<center>Add a portfolio entry into the database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=40 size=40><br></td>
</tr><tr>
<td>Description (Optional): </td>
<td><textarea name=description rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Date created "YYYY-MM-DD HH:MM:SS":</td>
<td><input type=text name=date maxlength=19 size=18></td>
</tr><tr>
<td>URL (of actual website, if it still exists): </td>
<td><input type=text name=url maxlength=45 size=45><br></td>
</tr><tr>
<td>Cached URL (if a copy of the site is still on the server): </td>
<td><input type=text name=cacheUrl maxlength=45 size=45><br></td>
</tr><tr>
<td>Thumbnail: </td>
<td><input type=text name=thumbnail maxlength=45 size=45></td>
</tr><tr>
<td>Type (website, logo, interface, other): </td>
<td><input type=text name=type maxlength=20 size=20</td>
</tr><tr>

<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<br><br><br>
Current table description:
<pre><font face="courier new">
+-------------+--------------------------------------------+------+-----+---------+----------------+
| Field       | Type                                       | Null | Key | Default | Extra          |
+-------------+--------------------------------------------+------+-----+---------+----------------+
| id          | int(10) unsigned                           |      | PRI | NULL    | auto_increment |
| title       | varchar(40)                                |      |     |         |                |
| description | text                                       | YES  |     | NULL    |                |
| date        | timestamp(14)                              | YES  |     | NULL    |                |
| url         | varchar(45)                                | YES  |     | NULL    |                |
| chacheUrl   | varchar(45)                                | YES  |     | NULL    |                |
| thumbnail   | varchar(30)                                | YES  |     | NULL    |                |
| type        | enum('website','logo','interface','other') | YES  |     | NULL    |                |
+-------------+--------------------------------------------+------+-----+---------+----------------+

</pre>
