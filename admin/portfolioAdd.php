<?
//--------------------------------------------------------------------------------------------------
//ScriptName: portfolioAdd.php
//Author: Phil Crosby
//Description: 	Processes a portfolio submission to input a new portfolio into
//				the portfolio database. Does light input checking, etc.
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
if (!$title || !$thumbnail || !$type){
	echo "Forgot either title, thumbnail, or type while submitting.<br>";
	exit;
}

//Format the input for the database
$title=addslashes($title);
$url=addslashes($url);
$cacheUrl=addslashes($cacheUrl);
$thumbnail=addslashes($thumbnail);
$description=addslashes($description);
$type=addslashes($type);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

$query = "insert into graphics_portfolio values ";
$query=$query. "(NULL, '$title', '$description', '$date', '$url', '$cacheUrl', '$thumbnail', '$type')";

$result = mysql_query($query);
if (!$result)
	echo "There was some submission error!";
else
	echo mysql_affected_rows() . " creations inserted into database.";
?>
