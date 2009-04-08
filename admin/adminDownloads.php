<html>
<title>Downloads Entry</title>
<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="downloadsAdd.php" method=post>

<center>Add a free image to the Database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=30 size=30><br></td>
</tr><tr>
<td>Path: </td>
<td><input type=text name=path maxlength=40 size=40><br></td>
</tr><tr>
<td>Thumbnail: </td>
<td><input type=text name=thumbnail maxlength=40 size=40><br></td>
</tr><tr>
<td>Author: </td>
<td><input type=text name=author maxlength=30 size=30><br></td>
</tr><tr>
<td>Description (Optional): </td>
<td><textarea name=description rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Rating: </td>
<td><input type=text name=rating maxlength=5 size=5></td>
</tr><tr>
<td>Average filesize (in K): </td>
<td><input type=text name=size maxlength=10 size=10></td>
</tr><tr>
<!-- <td>Date created "YYYY-MM-DD HH:MM:SS":</td><td><input type=text name=date maxlength=19 size=18></td></tr><tr> NOT NEEDED (now())-->
<td>Type (font, wallpaper, filter, other): </td>
<td><input type=text name=type maxlength=9 size=9</td>
</tr><tr>
<td>Subtype: </td>
<td><input type=text name=subtype maxlength=30 size=30</td>
</tr><tr>

<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<br><br><br>
Current table description:
<pre><font face="courier new">
+-------------+-------------------------------------------+------+-----+---------+----------------+
| Field       | Type                                      | Null | Key | Default | Extra          |
+-------------+-------------------------------------------+------+-----+---------+----------------+
| id          | int(10) unsigned                          |      | PRI | NULL    | auto_increment |
| title       | varchar(30)                               |      |     |         |                |
| path        | varchar(40)                               |      |     |         |                |
| thumbnail   | varchar(40)                               | YES  |     | NULL    |                |
| author      | varchar(30)                               | YES  |     | NULL    |                |
| description | text                                      | YES  |     | NULL    |                |
| rating      | int(11)                                   | YES  |     | NULL    |                |
| size        | int(10) unsigned                          | YES  |     | NULL    |                |
| date        | timestamp(6)                              | YES  |     | NULL    |                |
| type        | enum('font','wallpaper','filter','other') |      |     | font    |                |
| subtype     | varchar(30)                               | YES  |     | NULL    |                |
+-------------+-------------------------------------------+------+-----+---------+----------------+

</pre>
