<?
//--------------------------------------------------------------------------------------------------
//ScriptName: news.php
//Author: Phil Crosby
//Description: 	Outputs arbitrary number of news items
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Class: NewsItem
//Description:	Holds all pertinent information regarding a news record, and
//					has display methods
//--------------------------------------------------------------------------------------------------
class NewsItem{
	var	$title, $date, $poster, $message, $category;
	var $posterName, $posterEmail;
	function NewsItem($array, $type){
		$this->title=stripslashes($array["title"]);
		$this->date=$array["postDate"];
		$this->poster=$array["poster"];
		$this->message=stripslashes($array["message"]);
		$this->category=stripslashes($array["category"]);
		$this->posterName=stripslashes($array["posterName"]);
		$this->posterEmail=stripslashes($array["posterEmail"]);
	}
	function display(){
		echo "<b>$this->title</b><br>";
		echo "<font size=1>Posted by $this->posterName on $this->date<br>";
		echo "<img src='layout/divider.png' width=300 height=5><br>";
		echo "<font size=3>$this->message";
	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayNews()		Displays table of news with offset
//									and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayNews($offset, $resultsPerPage, $type){
        require("/var/www/gds/private/dbvars.php");

	//Connect to databse
	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the table
	$query = "select title, DATE_FORMAT(date, '%M %e at %k:%i') as postDate, poster, message, category, ";
	$query = $query. "name as posterName, email as posterEmail "; 
	$query = $query. "from graphics_news, graphics_posters where graphics_news.poster=graphics_posters.id ";
	$query = $query. "order by date desc ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	for ($i=0; $i<$numRows; $i++){
		$row = mysql_fetch_array($result);
		$newsItem = new NewsItem($row, $type);
		$newsItem->display();
		//Display a separator line
		//echo "<img src='layout/divider.png' width='100%'><br>";
		echo "<br><br>";
	}

	//REturn total table size
	$result=mysql_query("select count(id) as size from graphics_news");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];
	
	return $tableSize;
}

?>
