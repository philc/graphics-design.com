<? $pageTitle = "Portfolio - Interfaces";
require("../templates/header.inc");
?>

<b>Interfaces</b><br>
<img src="/layout/divider.png"><br>
These are fully featured interfaces designed for clients. I have made many more interfaces that are integrated into the complete website layouts, located in the <a href="websites.php">websites</a> section of my portfolio.

<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/portfolio.inc");

//Which type of creation we're viewing
$type='interface';

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
