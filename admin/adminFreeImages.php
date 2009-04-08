<html>
<title>Free Images Entry</title>

<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="freeImagesAdd.php" method=post>

<center>Add a free image to the Database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=30 size=30><br></td>
</tr><tr>
<td>Path (such as "01"): </td>
<td><input type=text name=path maxlength=30 size=30><br></td>
</tr><tr>
<td>Description (Optional):</td>
<td><textarea name=description rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Items In Set</td>
<td><input type=text name=itemsInSet maxlength=3 size=3></td>
</tr><tr>
<td>Average filesize (in K)</td>
<td><input type=text name=size maxlength=10 size=10></td>
</tr><tr>
<!-- <td>Date created "YYYY-MM-DD HH:MM:SS":</td><td><input type=text name=date maxlength=19 size=18></td></tr><tr> NOT NEEDED (now())-->
<td>Type (button, bullet, texture, line):</td>
<td><input type=text name=type maxlength=9 size=9</td>
</tr><tr>
<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<br><br><br>
Current table description:
<pre><font face="courier new">
+-------------+------------------------------------------+------+-----+---------+----------------+
| Field       | Type                                     | Null | Key | Default | Extra          |
+-------------+------------------------------------------+------+-----+---------+----------------+
| id          | int(10) unsigned                         |      | PRI | NULL    | auto_increment |
| path        | varchar(30)                              |      |     |         |                |
| title       | text                                     | YES  |     | NULL    |                |
| description | text                                     | YES  |     | NULL    |                |
| itemsInSet  | int(10) unsigned                         |      |     | 0       |                |
| size        | float unsigned                           | YES  |     | NULL    |                |
| date        | timestamp(4)                             | YES  |     | NULL    |                |
| type        | enum('button','bullet','texture','line') |      |     | button  |                |
+-------------+------------------------------------------+------+-----+---------+----------------+

</pre>
