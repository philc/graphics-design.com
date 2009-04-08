<? $pageTitle = "Creations - Logos";
require("../templates/header.inc");
?>

<b>Interfaces</b><br>
<img src="../layout/divider.png"><br>
I create a lot of personal logos (usually that of "GDS") when I feel creative, 
or to practice. The demand for good logos is always growing, so it is good to maintain
fresh styles and new ideas for logo design. As always, for newer, or the latest images, 
visit the <a href="../portfolio">Portfolio</a> section.
<br><br>


<?
//------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/creations.inc");

//Which type of creation we're viewing
$type='logo';

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
