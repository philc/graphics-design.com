<?
//--------------------------------------------------------------------------------------------------
//ScriptName: downloadsAdd.php
//Author: Phil Crosby
//Description: 	Processes a download submission to input a new download into
//				the download database. Does light input checking, etc.
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
if (!$title || !$path || !$type){
	echo "Forgot either title, path, or type while submitting.<br>";
	exit;
}

//Format the input for the database
$title=addslashes($title);
$path=addslashes($path);
$thumbnail=addslashes($thumbnail);
$author=addslashes($author);
$description=addslashes($description);
$type=addslashes($type);
$subtype=addslashes($subtype);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

$query = "insert into downloads values ";
$query=$query. "(NULL, '$title', '$path', '$thumbnail', '$author', '$description', $rating, '$size', now(), '$type', '$subtype')";

$result = mysql_query($query);
if (!$result)
	echo "There was some submission error!";
else
	echo mysql_affected_rows() . " creations inserted into database.";
?>
