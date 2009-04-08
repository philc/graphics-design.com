<html>
<title>Creations Entry</title>

<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="creationsAdd.php" method=post>

<center>Add a Creation to the Database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=30 size=30><br></td>
</tr><tr>
<td>Path: </td>
<td><input type=text name=path maxlength=30 size=30><br></td>
</tr><tr>
<td>Description (Optional):</td>
<td><textarea name=description rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Date created "YYYY-MM-DD HH:MM:SS":</td>
<td><input type=text name=date maxlength=19 size=18></td>
</tr><tr>
<td>Type (logo, artwork, interface, desktop, other):</td>
<td><input type=text name=type maxlength=9 size=9</td>
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
| title       | varchar(30)                                |      |     |         |                |
| path        | varchar(30)                                |      |     |         |                |
| description | text                                       | YES  |     | NULL    |                |
| date        | timestamp(4)                               | YES  |     | NULL    |                |
| type        | enum('logo','artwork','interface','other') |      |     | logo    |                |
+-------------+--------------------------------------------+------+-----+---------+----------------+

</pre>
