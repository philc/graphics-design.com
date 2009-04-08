<? $pageTitle = "Downloads - Fonts";
require("../templates/header.inc");
?>

<b>Downloads</b><br>
<img src="../layout/divider.png"><br>
Here are some fonts for your computer, for use with graphic designing, computer themes, or on your webpage (not reccomended). 
If you need help with installation, 
here is an <a href="http://desktoppub.miningco.com/library/essentials/bl-e-fontinstall.htm">excellent guide for font installation</a> 
for PC and Macs. Font installation on linux can be tricky, but Gnome and KDE managers can usually walk you through the installation.

<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/downloads.inc");

//Which type of creation we're viewing
$type='font';

//Check script arguments, or define them for the first time
if (!isset($offset) || $offset<0)
	$offset=0;
if (!isset($resultPerPage) || $resultsPerPage <1)
	$resultsPerPage=6;

//Display creations with (offset, resultsPerPage)
$result = displayDownloads($offset,$resultsPerPage, $type);

displayNavArrows($result, $offset, $resultsPerPage, getenv("SCRIPT_NAME"));

?>	

<? require("../templates/footer.inc"); ?>
