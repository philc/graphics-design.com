<?
//--------------------------------------------------------------------------------------------------
//ScriptName: links.php
//Author: Phil Crosby
//Description: 	Outputs arbitrary number of links, with descriptions,
//				in a formatted layout from a specific category of links.
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------
//define("LINKSPATH", "files/");

//--------------------------------------------------------------------------------------------------
//Class: Link
//Description:	Holds all pertinent information regarding a link record, and
//				has display methods
//--------------------------------------------------------------------------------------------------
class Link{
	var	$title, $url, $visits, $rating, $description, $graphic, $type;
	function Link($array, $type){
		$this->title=stripslashes($array["title"]);
		$this->url=stripslashes($array["url"]);
		$this->visits=$array["visits"];
		$this->rating=$array["rating"];
		$this->description=stripslashes($array["description"]);
		$this->graphic=stripslashes($array["graphic"]);
		$this->type=$type;
	}
	function display(){
		//$imagePath = LINKSPATH . "$this->type/". "$this->graphic";
		echo "<table border=0 cellpadding=0 cellspacing=2><tr><td>";
		echo "<b><a href='$this->url'>$this->title</td>";
		echo "<td align=right>(<a href='$this->url'>$this->url</a>)</b></td>";
		echo "</tr><tr><td colspan=2>";
		echo (!$this->description) ? "No Description" : "$this->description";
		echo "</td></tr></table>";

	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayLinks()			Displays list of links with offset,
//								and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayLinks($offset, $resultsPerPage, $type){
        require("/var/www/gds/private/dbvars.php");

	//Connect to databse
	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the table
	$query = "select title, url, visits, rating, description, graphic ";
	$query = $query. "from links where type='$type' ";
	$query = $query. "order by title ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	if ($numRows<=0)
		echo "There are no links in this category at the moment!";
	else{
		for ($i=0; $i<$numRows; $i++){
			$row = mysql_fetch_array($result);
			$link = new Link($row, $type);
			$link->display();
			//Display a separator line
			echo "<img src='../layout/divider.png' width=100%><br>";
		}
	}
	//Return total table size
	$result=mysql_query("select count(id) as size from freeImages where type='$type'");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];

	return $tableSize;
}

