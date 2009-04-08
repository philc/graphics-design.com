<?
//--------------------------------------------------------------------------------------------------
//ScriptName: creations.php
//Author: Phil Crosby
//Description: 	Outputs arbitrary number of creations, with descriptions,
//				in a formatted layout.
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------
define("CREATIONSPATH", "files/");

//--------------------------------------------------------------------------------------------------
//Class: Creation
//Description:	Holds all pertinent information regarding a creation record, and
//					has display methods
//--------------------------------------------------------------------------------------------------
class Creation{
	var	$title, $path, $description, $date, $type;
	function Creation($array, $type){
		$this->title=stripslashes($array["title"]);
		$this->path=$array["path"];
		$this->description=stripslashes($array["description"]);
		$this->date=$array["creationDate"];
		$this->type=$type;
	}
	function display(){
		$imagePath = CREATIONSPATH . "$this->type/". "$this->path";
	
		//If it's an interface, display a thumbnail and link to the actual interface's page
		if ($this->type=="interface"){
			echo "<center><a href='$imagePath/'><img src='$imagePath/thumbnail.jpg'></a></center><br>";
			echo "<b>\"$this->title\"</b> ($this->date)<br>";
			echo (empty($this->description)) ? "No description." : "$this->description";
		}else if ($this->type=="desktop"){
			echo "<table border=0 cellspacing=4 cellpadding=0><tr><td><a href='$imagePath/$this->path" . ".jpg'>";
			echo "<img src='$imagePath/thumbnail.jpg' border=0></a></td><td valign=top>";
			echo "<b>$this->date</b><br>";
			echo (empty($this->description)) ? "No description." : "$this->description";
			echo "</td></tr></table>";
		}else{
			echo "<center><img src='$imagePath'></center><br>";		
			echo "<b>\"$this->title\"</b> ($this->date)<br>";
			echo (empty($this->description)) ? "No description." : "$this->description";
			
		}

	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayCreations()		Displays table of creations with offset
//											and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayCreations($offset, $resultsPerPage, $type){
	require("/var/www/gds/private/dbvars.php");
	//Connect to databse

	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the creations table
	$query = "select title, path, description, DATE_FORMAT(date, '%b %Y') as creationDate "; 
	$query = $query. "from creations where type='$type' ";
	$query = $query. "order by date desc ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	for ($i=0; $i<$numRows; $i++){
		$row = mysql_fetch_array($result);
		$creation = new Creation($row, $type);
		$creation->display();
		//Display a separator line
		echo "<br><img src='../layout/divider.png' width=100%><br>";
	}
	
	//Return total table size
	$result=mysql_query("select count(id) as size from creations where type='$type'");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];

	return $tableSize;
}

