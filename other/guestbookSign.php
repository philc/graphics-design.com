<? $pageTitle = "Sign the Guestbook";
require("../templates/header.inc");
?>

<b>Sign the GDS Guestbook</b><br>
<img src="/layout/divider.png"><br>
This is where you can sign the guestbook - just fill in the form below. Please don't include 
too many personal details, such as your exact address or phone number or anything. Just possibly 
your state or country, and whatever message you want to leave. No foul language, and messages are limited 
to 500 characters.

<br><br>


<form action="../scripts/guestbook/guestbookAdd.php" method=post>
<font size=2 face=arial>

<table border=0><TR>

<td>Name: </td>
<td><input type=text name=author maxlength=30 size=30><br></td>
</tr><tr>
<td>Email: </td>
<td><input type=text name=email maxlength=30 size=30><br></td>
</tr><tr>
<td>Location: </td>
<td><input type=text name=location maxlength=35 size=35></td>
</tr><tr>
<td>Message: </td>
<td><textarea name=message rows=8 cols=40 wrap="virtual" maxlength=500></textarea><br></td>
</tr><tr>
<td colspan=2><center><input type=submit value="Submit"><br></td>

</tr></table>
</form>


<? require("../templates/footer.inc"); ?>
