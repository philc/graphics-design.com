<html>
<title>Tutorial Entry</title>

<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="tutorialsAdd.php" method=post>

<center>Add a tutorial to the database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=30 size=30><br></td>
</tr><tr>
<td>Path (such as "customDropShadow"): </td>
<td><input type=text name=path maxlength=30 size=30><br></td>
</tr><tr>
<td>Thumbnail (such as "thumbnail.jpg"): </td>
<td><input type=text name=thumbnail maxlength=30 size=30><br></td>
</tr><tr>
<td>Author: </td>
<? echo "<td><input type=hidden name=author value=$id>$id<br></td>"; ?>
</tr><tr>
<td>Description (Optional):</td>
<td><textarea name=description rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Type (photoshop, paintShopPro, gimp, generic)</td>
<td><input type=text name=type maxlength=20 size=10></td>
</tr><tr>
<td>Subtype (web, text, button, texture, effect)</td>
<td><input type=text name=subtype maxlength=20 size=10></td>
</tr><tr>
<td>Skill:</td>
<td><select name=skill>
	<option value=beginner>beginner
	<option value=intermediate>intermediate
	<option value=advanced>advanced
	</select>
</td>
</tr><tr>
<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<br><br><br>
Current table description:
<pre><font face="courier new">
+-------------+----------------------------------------------------+------+-----+---------+----------------+
| Field       | Type                                               | Null | Key | Default | Extra          |
+-------------+----------------------------------------------------+------+-----+---------+----------------+
| id          | int(10) unsigned                                   |      | PRI | NULL    | auto_increment |
| title       | text                                               |      |     |         |                |
| path        | text                                               |      |     |         |                |
| thumbnail   | text                                               |      |     |         |                |
| author      | int(11)                                            |      |     | 0       |                |
| description | text                                               |      |     |         |                |
| date        | timestamp(14)                                      | YES  |     | NULL    |                |
| type        | enum('general','paintShopPro','photoshop','flash') |      |     | general |                |
| subtype     | enum('text','drawing','web','misc')                | YES  |     | NULL    |                |
| skill       | enum('beginner','intermediate','advanced')         | YES  |     | NULL    |                |
+-------------+----------------------------------------------------+------+-----+---------+----------------+


</pre>
</html>
