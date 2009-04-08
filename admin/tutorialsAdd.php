<?
//--------------------------------------------------------------------------------------------------
//ScriptName: tutorialAdd.php
//Author: Phil Crosby
//Description: 	Adds a tutorial to the database
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------
require("/home/philisoft/scripts/graphics/dbvars.php");
?>

<html>
<title>Results:</title>
<body bgcolor="white">

<h2>Submission Result:</h2><br><br>

<?

//Test for essential fields
if (!$title || !$path || !$author || !$thumbnail || !$skill || !$type || !$subtype){
	echo "Forgot either title, path, author, thumbnail, , skill, type, or subtype while submitting.<br>";
	exit;
}

//Format the input for the database
//title=addslashes($title);
//path=addslashes($url)
//description=addslashes($description);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

$query = "insert into graphics_tutorials values ";
$query=$query. "(NULL, '$title', '$path', '$thumbnail', '$author', '$description', now(), '$type', '$subtype', '$skill')";

$result = mysql_query($query);
if (!$result)
	echo "There was some submission error!";
else
	echo mysql_affected_rows() . " tutorials inserted into database.";
?>
