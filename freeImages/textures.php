<? $pageTitle = "Free Images - Textures";
require("../templates/header.inc");
?>

<b>Textures</b><br>
<img src="../layout/divider.png"><br>
You can use these textures for practically any purpose, but they are most often used as 
the background of a site (using HTML) or used as the backgrounds of images. They can also be 
manipulated and used for interfaces, or the face of text. To see how to do a few of these applications, 
visit the <a href="../tipsTricks">Tips and Tricks</a> section.
<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/freeImages.inc");

//Which type of creation we're viewing
$type='texture';

//Check script arguments, or define them for the first time
if (!isset($offset) || $offset<0)
	$offset=0;
if (!isset($resultPerPage) || $resultsPerPage <1)
	$resultsPerPage=5;

//Display creations with (offset, resultsPerPage)
$result = displayFreeImages($offset,$resultsPerPage, $type);

displayNavArrows($result, $offset, $resultsPerPage, getenv("SCRIPT_NAME"));



?>	

<? require("../templates/footer.inc"); ?>
