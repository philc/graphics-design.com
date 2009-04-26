<?
//--------------------------------------------------------------------------------------------------
//ScriptName: guestbookView.php
//Author: Phil Crosby
//Description: 	
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------
//define("CREATIONSPATH", "files/");

//--------------------------------------------------------------------------------------------------
//Class: Entry
//Description:	Holds all pertinent information regarding a creation record, and
//				has display methods
//--------------------------------------------------------------------------------------------------
class Entry{
	var	$author, $email, $location, $date, $message;
	function Entry($array){
		$this->author=stripslashes($array["author"]);
		$this->email=stripslashes($array["email"]);
		$this->location=stripslashes($array["location"]);
		$this->date=$array["signDate"];
		$this->message=stripslashes($array["message"]);
	}
	function display(){
		echo "<table border=0 cellpadding=0 cellspacing=4 width='100%'><tr>";
		echo "<td valign=top width=20%>";
		echo (!$this->email) ? "$this->author" : "<a href=mailto:$this->email>$this->author</a>";
		echo "<br>$this->location<br>$this->date</td>";
		echo "<td valign=top>$this->message</td></tr></table>";

	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayEntries()		Displays table of creations with offset
//								and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayEntries($offset, $resultsPerPage){
	require("/home/philisoft/scripts/graphics/dbvars.php");

	//Connect to databse
	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the creations table
	$query = "select author, email, location, DATE_FORMAT(date, '%b %e %Y') as signDate, message "; 
	$query = $query. "from guestbook ";
	$query = $query. "order by date desc ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	//Open up a table; each entry is part of the tableSize

	for ($i=0; $i<$numRows; $i++){
		$row = mysql_fetch_array($result);
		$entry = new Entry($row);
		$entry->display();
		//Display a separator line
		echo "<img src='/layout/divider.png' width=100%><br>";
	}
	//Return total table size
	$result=mysql_query("select count(id) as size from guestbook");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];

	return $tableSize;
}

