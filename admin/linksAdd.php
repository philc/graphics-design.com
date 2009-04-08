<?
//--------------------------------------------------------------------------------------------------
//ScriptName: linksAdd.php
//Author: Phil Crosby
//Description: 	Processes a link submission to input a new download into
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
if (!$title || !$url || !$type){
	echo "Forgot either title, url, or type while submitting.<br>";
	exit;
}

//Format the input for the database
$title=addslashes($title);
$url=addslashes($url);
$description=addslashes($description);
$graphic=addslashes($graphic);
$type=addslashes($type);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

$query = "insert into links values ";
$query=$query. "(NULL, '$title', '$url', '$visits', '$rating', '$description', '$graphic', '$type')";

$result = mysql_query($query);
if (!$result)
	echo "There was some submission error!";
else
	echo mysql_affected_rows() . " creations inserted into database.";
?>
