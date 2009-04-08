<?
//--------------------------------------------------------------------------------------------------
//ScriptName: newsAdd.php
//Author: Phil Crosby
//Description: 	Processes a news submission to input a new free image into
//					the freeImages database. Does light input checking, etc.
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
if (!$title || !$poster || !$message ||!$category){
	echo "Forgot either title, poster, message, or category while submitting.<br>";
	exit;
}

//Format the input for the database
$title=addslashes($title);
$poster=addslashes($poster);
$message=addslashes($message);
$category=addslashes($category);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

$query = "insert into graphics_news values ";
$query=$query. "(NULL, '$title', now(), '$poster', '$message', '$category')";

$result = mysql_query($query);
if (!$result)
	echo "There was some submission error!";
else
	echo mysql_affected_rows() . " news items inserted into database.";
?>
