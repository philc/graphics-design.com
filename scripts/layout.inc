<?
//--------------------------------------------------------------------------------------------------
//Function: displayNavArrows()		Checks browsing parameters, displays reg/gray arrows
//								$result is a bool, if there are more results to display 
//								(obtained from a display() function)
//--------------------------------------------------------------------------------------------------
function displayNavArrows($tableSize, $offset, $resultsPerPage, $scriptName){
	echo "<table border=0 cellpadding=0 cellspacinng=0><tr><td>";

	if ($offset<=0)
		echo "<img src='../layout/arrowPrevGray.jpg'>";
	else{
		$newOffset=$offset-$resultsPerPage;
		echo "<a href='$scriptName?offset=$newOffset&resultsPerPage=$resultsPerPage'>";
		echo "<img src='../layout/arrowPrev.jpg' border=0></a>";
	}

	if ($offset+$resultsPerPage>$tableSize)
		if ($offset==0)		//Check to see if we're on the first page.
			$newOffset=$tableSize;
		else
			$newOffset=($offset+$resultsPerPage)-$tableSize + $offset +1;
	else
		$newOffset=$offset+$resultsPerPage;
		
	//Output Current browsing information
	echo "</td><td width=100%><center><font size=2 face=arial>";
	echo "Viewing items " . ($offset+1) . " - " . ($newOffset) . " of $tableSize<br>";
	echo "Showing $resultsPerPage items per page</td><td>";
	
	//Test to see if right arrow is grayed out (can we go right)
	if ($offset+$resultsPerPage>=$tableSize)	//We can't go further
		echo "<img src='../layout/arrowNextGray.jpg'>";
	else{
		$newOffset=$offset+$resultsPerPage;
		echo "<a href='$scriptName?offset=$newOffset&resultsPerPage=$resultsPerPage'>";
		echo "<img src='../layout/arrowNext.jpg' border=0></a>";
	}
	echo "</td></tr></table>";
}
?>
