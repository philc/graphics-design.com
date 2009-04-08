<?php

	/*

 	Author:				Will Chapman	(webmail@battlepages.com)
 	Version:			v0.4.2
 	Description:		Handles custom options that can be set by the user

	License File:		License.txt

	Please email any improvements, recommendations, bugs or feature ideas to
	me so everyone can benefit from them.  Thank you.

	This is distributed as a part of Quality-Stats
    This programn is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/
	$includePath="/home/philisoft/scripts/graphics/tracker";
	$scriptPath="/home/philisoft/www/graphics/scripts/tracker";
// Database Settings
// Information needed to connect to database server
$qs_cfg["qstats_db_server"] = "localhost";
$qs_cfg["qstats_db_login"] = "philisoft";
$qs_cfg["qstats_db_password"] = "pass3";
$qs_cfg["qstats_db_database"] = "philisoft";

$qs_cfg["qstats_db_prefix"] = "graphics_tracker";
$qs_cfg["script_password"] = md5("");


// Script Names
// These are the actual file names that will be referenced when calling certain parts of the script.
// qs_option =	Options Panel
// qs_display =	Display panel for stats
// qs_login =	Login script
// qs_confirm = Confirmation script (verifies that all is in working order)
$qs_cfg["qs_option"] = "qs_options.php";
$qs_cfg["qs_display"] = "qs_display.php";
$qs_cfg["qs_login"] = "qs_login.php";
$qs_cfg["qs_confirm"] = "qs_confirm.php";

// Change as seen fit.  Format will be a combination of these settings and the template
$qs_cfg["link_color"] = "#c0c0c0";		// Color of each link
$qs_cfg["calendar_link_color"] = "#ffffff";	// Colors of the links in the calendar
$qs_cfg["active_day_foreground"] = "#000000";	// Color of the link if a particular day is selected in the calendar
$qs_cfg["active_day_background"] = "#ffffcc";	// Same as previous, just the background color
$qs_cfg["text_color"] = "#ffffff";		// Color of the normal text
$qs_cfg["border_color"] = "#000000";		// Color of outlining borders
$qs_cfg["main_background_color"] = "#023a67";


include("$scriptPath/auto.cfg.php");	// Retrieves information from database
?>
