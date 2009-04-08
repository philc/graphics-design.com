<html>
<title>Links Entry</title>

<body bgcolor="white" text="Black">
<font size=2 face=arial>

<? require_once("../scripts/admin.inc");
	@ session_start();
	checkSessionAuth();	//Make sure viewer of this page is authorized! Will exit if not.
?>

<form action="linksAdd.php" method=post>

<center>Add a link to the Database</center><br><br>

<table border=0><TR>

<td>Title: </td>
<td><input type=text name=title maxlength=30 size=30><br></td>
</tr><tr>
<td>URL: </td>
<td><input type=text name=url maxlength=50 size=50><br></td>
</tr><tr>
<td>Visits: </td>
<td><input type=text name=visits maxlength=40 size=40><br></td>
</tr><tr>
<td>Rating: </td>
<td><input type=text name=rating maxlength=30 size=30><br></td>
</tr><tr>
<td>Description (Optional): </td>
<td><textarea name=description rows=8 cols=40 wrap="virtual"></textarea><br></td>
</tr><tr>
<td>Graphic: </td>
<td><input type=text name=graphic maxlength=5 size=5></td>
</tr><tr>
<!-- <td>Date created "YYYY-MM-DD HH:MM:SS":</td><td><input type=text name=date maxlength=19 size=18></td></tr><tr> NOT NEEDED (now())-->
<td>Type ('web hosting', 'graphics site', 'non-graphics site', <br>'graphic software', 'free images', 'fonts', 'tutorials', 'news'): </td>
<td><input type=text name=type maxlength=20 size=20</td>
</tr><tr>
<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<br><br><br>
Current table description:
<pre><font face="courier new">
+-------------+-----------------------------------------------------------------------------------------------------------------------------+------+-----+-------------+----------------+
| Field       | Type                                                                                                                        | Null | Key | Default     | Extra          |
+-------------+-----------------------------------------------------------------------------------------------------------------------------+------+-----+-------------+----------------+
| id          | int(10) unsigned                                                                                                            |      | PRI | NULL        | auto_increment |
| title       | varchar(30)                                                                                                                 |      |     |             |                |
| url         | varchar(50)                                                                                                                 |      |     |             |                |
| visits      | int(11)                                                                                                                     | YES  |     | 0           |                |
| rating      | int(2)                                                                                                                      | YES  |     | 0           |                |
| description | text                                                                                                                        | YES  |     | NULL        |                |
| graphic     | varchar(30)                                                                                                                 | YES  |     | NULL        |                |
| type        | enum('web hosting','graphics site','non-graphics site','graphic software','free images','fonts','tutorials','news','other') |      |     | web hosting |                |
+-------------+-----------------------------------------------------------------------------------------------------------------------------+------+-----+-------------+----------------+

</pre>
