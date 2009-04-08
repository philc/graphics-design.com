<?
//--------------------------------------------------------------------------------------------------
//ScriptName: guestbookAdd.php
//Author: Phil Crosby
//Description: 	Adds a guestbook entry into the database.
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------
require("/home/philisoft/scripts/graphics/dbvars.php");
require("../badwords/badwords.php");			//Function badWords() removes foul language from posts
?>

<? $pageTitle = "Submission Results";
require("../../templates/header.inc");
?>

<?

//Test for essential fields
if (!$author || !$email || !$message){
	echo "You forgot to enter either your name, email, or a message while submitting.<br>";
	echo "Please <a href=javascript:history.back(1)>go back</a> and try again.";
	require("../../templates/footer.inc");
	exit;
}

//Format the input for the database
$author=badwords($author);
$author=addslashes($author);
$email=badwords($email);
$email=addslashes($email);
$location=badwords($location);
$location=addslashes($location);
$message=badwords($message);
$message=addslashes($message);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

//Duplication check queries
//Checking for duplicate authors
$result=mysql_query("select count(id) as size from guestbook where author='$author'");
$authors=mysql_fetch_array($result);
$authors=$authors["size"];
//Check for duplicate message
$result=mysql_query("select count(id) as size from guestbook where message='$message'");
$messages=mysql_fetch_array($result);
$messages=$messages["size"];
if ($authors>0 or $messages>0){
	echo "It seems you've already posted, or have posted the same message twice.";
	echo "In case you've posted twice by accident, check the <a href='/graphics/other/guestbook.php'>guestbook</a> ";
	echo "and see if your message is already posted";
	require("../../templates/footer.inc");
	exit;
}

//Actual Insertion query
$query = "insert into guestbook values ";
$query=$query. "(NULL, '$author', '$email', '$location', now(), '$message')";

$result = mysql_query($query);

echo "<br><br>";

if (!$result){
	echo "There was some error while trying to add your guestbook addition! Please advise your ";
	echo "form submission fields and make sure you didn't include any special characters or code. ";
	echo "Sorry for the inconvenience.";
}else{
	echo "Submission was ok! Thanks for signing the guestbook. To view the guestbook (and your entry), ";
	echo "<a href='/graphics/other/guestbook.php'>visit here</a>.";
}

require("../../templates/footer.inc");

?>
