<? $pageTitle = "Portfolio - Websites";
require("../templates/header.inc");
?>

<b>Websites</b><br>
<img src="../layout/divider.png"><br>
These are completed website layouts designed for customers. The websites may be nonfunctioning, or using a different layout at the time of viewing, so I have provided a <b>cached</b> version (an original version kept on this site) so you may see the original design. <b>I highly recommend the cached versions.</b>

<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/portfolio.inc");

//Which type of creation we're viewing
$type='website';

//Check script arguments, or define them for the first time
if (!isset($offset) || $offset<0)
	$offset=0;
if (!isset($resultPerPage) || $resultsPerPage <1)
	$resultsPerPage=6;

//Display portfolio Items with (offset, resultsPerPage)
$result = displayPortfolio($offset,$resultsPerPage, $type);

displayNavArrows($result, $offset, $resultsPerPage, getenv("SCRIPT_NAME"));

?>	

<? require("../templates/footer.inc"); ?>
