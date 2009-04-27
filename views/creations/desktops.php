<? $pageTitle = "Creations - Desktops";
require("../templates/header.inc");
?>

<b>Desktops</b><br>
<img src="/layout/divider.png"><br>
These are actual screenshots of my past and current desktops! Be wary, the images are full captures of my screen, 
so they are as large as my resolution at the time (meaning: <b>they are very large images</b>). I often use shell enhancement programs, 
such as <a href="http://www.stardock.com/products/desktopx/">DesktopX</a> and 
<a href="http://www.shellfront.org/">Litestep</a> (my favorite, for windows). If you're using MS windows, 
these programs allow you to completely alter or do away with the windows shell. You can then customize the look, 
feel, and operation of just about everything on the desktop. On linux, I usually use <a href="http://www.gnome.org">Gnome</a> 
and a Gnome-compatible window manager, such as sawfish, to arrange/draw my desktop.
<br><br>
<b><i>Note: On all of these screen shots, I either had very little or no part in designing the wallpaper; credit for the wallpapers 
goes to their respective authors.</b></i>
<br><br>


<?
//--------------------------------------------------------------------------------------------------
//Main Script		Handles resultsPerPage variables, calls the display functions
//--------------------------------------------------------------------------------------------------
//Require the creation display functions
require("../scripts/layout.inc");
require("../scripts/creations.inc");

//Which type of creation we're viewing
$type='desktop';

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
