<? $pageTitle = "Creations - Interfaces";
require("../templates/header.inc");
?>

<b>Interfaces</b><br>
<img src="/layout/divider.png"><br>
Here are some older interfaces - each item on this page is a preview. Most of the interfaces are animated, 
and to see the full interface, click on its image. Once again, to see the most recent interfaces that 
accompany webpages, vists my <a href="../portfolio">Portfolio</a> section.
<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/creations.inc");

//Which type of creation we're viewing
$type='interface';

//Check script arguments, or define them for the first time
if (!isset($offset) || $offset<0)
	$offset=0;
if (!isset($resultPerPage) || $resultsPerPage <1)
	$resultsPerPage=3;

//Display creations with (offset, resultsPerPage)
$result = displayCreations($offset,$resultsPerPage, $type);

displayNavArrows($result, $offset, $resultsPerPage, getenv("SCRIPT_NAME"));

?>	

<? require("../templates/footer.inc"); ?>
