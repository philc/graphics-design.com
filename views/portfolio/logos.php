<? $pageTitle = "Portfolio - Logos";
require("../templates/header.inc");
?>

<b>Logos</b><br>
<img src="/layout/divider.png"><br>
These are standalone logos that were designed separately from the website. To see logos that I've made that were integrated into website layouts, visit the <a href="websits.php">websites</a> section of my portfolio.

<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/portfolio.inc");

//Which type of creation we're viewing
$type='logo';

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
