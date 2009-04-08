<html>
<title>News Post Entry</title>

<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="newsAdd.php" method=post>

<center>Add a free image to the Database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=40 size=40><br></td>
</tr><tr>
<td>Poster: </td>
<td><input type=text name=poster maxlength=3 size=3><br></td>
</tr><tr>
<td>Message:</td>
<td><textarea name=message rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Category (news, update, other) </td>
<td><input type=text name=category maxlength=30 size=30></td>
</tr><tr>
<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<br><br><br>
Current table description:
<pre><font face="courier new">
+----------+-------------------------------+------+-----+---------+----------------+
| Field    | Type                          | Null | Key | Default | Extra          |
+----------+-------------------------------+------+-----+---------+----------------+
| id       | int(10) unsigned              |      | PRI | NULL    | auto_increment |
| title    | varchar(40)                   |      |     |         |                |
| date     | timestamp(14)                 | YES  |     | NULL    |                |
| poster   | int(11)                       |      |     | 0       |                |
| message  | text                          |      |     |         |                |
| category | enum('news','update','other') | YES  |     | NULL    |                |
+----------+-------------------------------+------+-----+---------+----------------+
</pre>
