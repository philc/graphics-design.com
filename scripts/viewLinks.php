<? 
//--------------------------------------------------------------------------------------------------
//ScriptName: viewLinks.php
//Author: Phil Crosby
//Description: 	View all link listings of a particular type
//Parameters:		$type (type of links to display, such as "fonts")
//--------------------------------------------------------------------------------------------------

//Header
$pageTitle = "Links";
require("../templates/header.inc");

?>

<b>Links</b><br>
<img src="../layout/divider.png"><br>
These are sites that I personally reccomend. I don't have links that just give me traffic; 
I've personally visited every site and either like the design or use it often myself.
<br>
<center><a href="../webLinks/index.php">Back to the main Links page</a></center>

<br>

<?

//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/links.inc");

//Check to see that this script was visited from the site, and has the correct variables set.
if (!$type){
	echo "This page has been called incorrectly, most likely because you bookmarked just this page, ";
	echo "or visited it from off-site. Please navigate from the main page, <a href='http://www.graphics-design.com'>";
	echo "http://www.graphics-design.com</a> to find what you're looking for.";
}else{
	
	//Check script arguments, or define them for the first time
	if (!isset($offset) || $offset<0)
		$offset=0;
	if (!isset($resultPerPage) || $resultsPerPage <1)
		$resultsPerPage=3;
	
	$result = displayLinks($offset,$resultsPerPage, $type);

	
}//end "valid variable check"

require("../templates/footer.inc");

?>
