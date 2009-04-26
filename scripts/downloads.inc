<?
//--------------------------------------------------------------------------------------------------
//ScriptName: downloads.php
//Author: Phil Crosby
//Description: 	Outputs arbitrary number of downloads, with descriptions,
//				in a formatted layout.
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------
define("DOWNLOADSPATH", "files/");

//--------------------------------------------------------------------------------------------------
//Class: Download
//Description:	Holds all pertinent information regarding a download record, and
//				has display methods
//--------------------------------------------------------------------------------------------------
class Download{
	var	$title, $path, $thumbnail, $author, $description, $rating, $date, $size, $type, $subtype;
	function Download($array, $type){
		$this->title=stripslashes($array["title"]);
		$this->path=$array["path"];
		$this->thumbnail=$array["thumbnail"];

		$this->author=$array["author"];
		$this->description=stripslashes($array["description"]);
		$this->rating=$array["rating"];
		$this->date=$array["date"];
		$this->itemsInSet=$array["itemsInSet"];
		$this->size=$array["size"];
		$this->type=$type;
		$this->subtype=$subtype;
	}
	function display(){
		$downloadPath = DOWNLOADSPATH . "$this->type/";

		echo "<table border=0 cellpadding=0 cellspacing=4><tr><td valign=top>";
		echo "<b><a href='$downloadPath$this->path'>$this->title</a></b><br>";
		echo "Approx filesize: " . $this->size . "K<br>";
		if (!$this->description)
			echo "No description<br>";
		else
			echo "$this->description<br>";
		echo "</td><td><a href='$downloadPath$this->path'><img src='$downloadPath$this->thumbnail' border=2 style='border-color:#004866'></a>";
		echo "</td></tr></table><br>";
	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayDownloads()			Displays table of downloads with offset
//									and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayDownloads($offset, $resultsPerPage, $type){
        require("/var/www/gds/private/dbvars.php");

	//Connect to databse
	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the table
	$query = "select title, path, thumbnail, author, description, rating,size, DATE_FORMAT(date, '%b %Y') as date, subtype "; 
	$query = $query. "from downloads where type='$type' ";
	$query = $query. "order by date desc ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	for ($i=0; $i<$numRows; $i++){
		$row = mysql_fetch_array($result);
		$download = new Download($row, $type);
		$download->display();
		//Display a separator line
		echo "<img src='/layout/divider.png' width=100%><br>";
	}
	
	//REturn total table size
	$result=mysql_query("select count(id) as size from downloads where type='$type'");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];
	
	return $tableSize;
}

