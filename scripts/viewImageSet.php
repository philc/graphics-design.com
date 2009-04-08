<?
//--------------------------------------------------------------------------------------------------
//ScriptName: viewImageSet.php
//Author: Phil Crosby
//Description: 	View images in some directory, with image names 1..2...n (to argument n)
//Parameters:		$path (of image files), $itemsInSet, and $extension (jpg, png..)
//--------------------------------------------------------------------------------------------------

//Header
$pageTitle = "Viewing An Image Set";
require("../templates/header.inc");

//Check to see that this script was visited from the site, and has the correct variables set.
if (!$path || !$itemsInSet ||!$extension){
	echo "This page has been called incorrectly, most likely because you bookmarked just this page, ";
	echo "or visited it from off-site. Please navigate from the main page, <a href='http://www.graphics-design.com'>";
	echo "http://www.graphics-design.com</a> to find what you're looking for.";
}else{
	echo "<center><a href=javascript:history.back(1)><img src='../layout/arrowPrev.jpg' border=0></a><br>";
	echo "<img src='../layout/divider.png'>";

	//Print every item located in $filename/$i.jpg or .png (up to $itemsInSet)
	for ($i=1; $i<=$itemsInSet;$i++)
		echo "<img src='../$path/$i.$extension'> ";

}//end "valid variable check"
	

//Footer
require("../templates/footer.inc"); 

?>
