<?
//--------------------------------------------------------------------------------------------------
//ScriptName: freeImages.php
//Author: Phil Crosby
//Description: 	Outputs arbitrary number of freeImages, with descriptions,
//				in a formatted layout.
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Globals
//--------------------------------------------------------------------------------------------------
define("FREEIMAGESPATH", "files/");

//--------------------------------------------------------------------------------------------------
//Class: FreeImage
//Description:	Holds all pertinent information regarding a freeImage record, and
//				has display methods
//--------------------------------------------------------------------------------------------------
class FreeImage{
	var	$title, $path, $description, $date, $type, $itemsInSet, $size;
	function FreeImage($array, $type){
		$this->title=stripslashes($array["title"]);
		$this->path=$array["path"];
		$this->description=stripslashes($array["description"]);
		$this->date=$array["creationDate"];
		$this->itemsInSet=$array["itemsInSet"];
		$this->size=$array["size"];
		$this->type=$type;
	}
	function display(){
		$imagePath = FREEIMAGESPATH . "$this->type/". "$this->path";
		
		//Determine the extension on the filenames
		if ($this->type=="texture")
			$extension="jpg";
		else
			$extension="png";

		//Obtain the calling script's name so we can pass it to "viewImageSet.php"
		$scriptName = getenv("SCRIPT_NAME");
		$filesPath="freeImages/" . $imagePath;				//The "viewImageSet" script needs a path for the files
		echo "<tr><td>";
		echo "<a href='../scripts/viewImageSet.php?path=$filesPath&itemsInSet=$this->itemsInSet&extension=$extension'>";
		echo "<img src='$imagePath/thumbnail.$extension' border=0></a></td>";		
		echo "<td valign=top width=100%><b>\"$this->title\"</b> ($this->itemsInSet $this->type" . "s)<br>";
		echo "Approx Image Size: " . $this->size . "K<br>";
		if (!$this->description)
			echo "No description<br>";
		else
			echo "$this->description<br>";
		echo "</td></tr>";
	} 	
}

//--------------------------------------------------------------------------------------------------
//Function: displayFreeImages()			Displays table of freeImages with offset
//									and resultsPerPage. Returns total size of table
//--------------------------------------------------------------------------------------------------
function displayFreeImages($offset, $resultsPerPage, $type){
        require("/var/www/gds/private/dbvars.php");

	//Connect to databse
	@ $db=mysql_pconnect($dbAddress, $dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");

	//Grab all results in the table
	$query = "select title, path, description, itemsInSet, size, ";
	$query = $query. "DATE_FORMAT(date, '%b %Y') as creationDate "; 
	$query = $query. "from freeImages where type='$type' ";
	$query = $query. "order by date desc ";
	$query = $query. "limit $offset, $resultsPerPage";

	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);

	echo "<table border=0 cellpadding=0 cellspacing=4>";
	
	for ($i=0; $i<$numRows; $i++){
		$row = mysql_fetch_array($result);
		$freeImage = new FreeImage($row, $type);
		$freeImage->display();
		//Display a separator line
		echo "<tr><td colspan=2>";
		echo "<img src='../layout/divider.png' width=100%><br>";
		echo "</td></tr>";
	}
	
	echo "</table>";
	
	//REturn total table size
	$result=mysql_query("select count(id) as size from freeImages where type='$type'");
	$tableSize=mysql_fetch_array($result);
	$tableSize=$tableSize["size"];

	return $tableSize;
}

