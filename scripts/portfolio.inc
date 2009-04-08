<?
//--------------------------------------------------------------------------------------------------
//ScriptName: portfolio.php
//Author: Phil Crosby
//Description: 	Outputs arbitrary number of portfolio entries in a formatted layout.
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------
define("PORTFOLIOPATH", "files/");

//--------------------------------------------------------------------------------------------------
//Class: Portfolio
//Description:	Holds all pertinent information regarding a Portfolio record, and
//				has display methods
//--------------------------------------------------------------------------------------------------
class Portfolio{
	var	$title, $description, $date, $url, $cacheUrl, $thumbnail;
	function Portfolio($array, $type){
		$this->title=stripslashes($array["title"]);
		$this->description=stripslashes($array["description"]);
		$this->date=$array["creationDate"];
		$this->url=$array["url"];
		$this->cacheUrl=$array["cacheUrl"];
		$this->thumbnail=$array["thumbnail"];
		$this->type=$type;
	}
	function display(){
		$itemPath = PORTFOLIOPATH . "$this->type";
		
		echo "<table border=0 cellpadding=0 cellspacing=4><tr><td>";
		if ($this->cacheUrl)
			echo "<a href='$itemPath/$this->cacheUrl'><img src='$itemPath/$this->thumbnail' border=2 style='border-color:#004866'></a>";
		else
			echo"<img src='$itemPath/$this->thumbnail'>";
		echo "</td><td valign=top width=100%><b>\"$this->title\"</b> ($this->date)<br>";
		echo "$this->description";
		echo "<br><center>[ View: ";
		echo ($this->url) ? "<a href='$this->url'>Actual site</a>" : "Actual site</a>";
		echo " | ";
		echo ($this->cacheUrl) ? "<a href='$itemPath/$this->cacheUrl'>Cached version</a>" : "Cached version";
		echo " ]</td></tr></table>";
		
	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayPortfolio()			Displays table of Portfolio entries with offset
//									and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayPortfolio($offset, $resultsPerPage, $type){
        require("/var/www/gds/private/dbvars.php");

	//Connect to databse
	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the table
	$query = "select title, description, DATE_FORMAT(date, '%b %Y') as creationDate, url, cacheUrl, thumbnail "; 
	$query = $query. "from graphics_portfolio where type='$type' ";
	$query = $query. "order by date desc ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	for ($i=0; $i<$numRows; $i++){
		$row = mysql_fetch_array($result);
		$portfolio = new Portfolio($row, $type);
		$portfolio->display();
		//Display a separator line
		echo "<img src='../layout/divider.png' width=100%><br>";
	}
	
	//REturn total table size
	$result=mysql_query("select count(id) as size from graphics_portfolio where type='$type'");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];

	return $tableSize;
}

