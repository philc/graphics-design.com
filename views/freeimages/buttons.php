<? $pageTitle = "Free Images - Buttons";
require("../templates/header.inc");
?>

<b>Buttons</b><br>
<img src="/layout/divider.png"><br>
These buttons can be used as a template, where you can put your own text on them and use them on your website or graphics project. To find out how to make buttons of your own, or to create some text effects, visit the <a href="../tipsTricks">Tips and Tricks</a> section.
<br><br>
<font size=2><b><i>Note</i>: These images are in .png format, and they have transparent backgrounds. That means they can display well on <i>any</i> color background. If you modify these images and place text on them, be sure to save them in .png format again.</b>
<font size=3>
<br><br>

<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/freeImages.inc");

//Which type of creation we're viewing
$type='button';

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
