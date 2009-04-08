<?
//--------------------------------------------------------------------------------------------------
//ScriptName: creationsAdd.php
//Author: Phil Crosby
//Description: 	Processes a creation submission to input a new creation into
//				the creations database. Does light input checking, etc.
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
$description=addslashes($description);
$type=addslashes($type);

//Connecting to the database
@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
if (!$db){
	echo "Could not connect to mySQL database! Fail";
	exit;
}
mysql_select_db("$dbDatabase");

$query = "insert into creations values ";
$query=$query. "(NULL, '$title', '$path', '$description', '$date', '$type')";

$result = mysql_query($query);
echo mysql_affected_rows() . " creations inserted into database.";
?>
