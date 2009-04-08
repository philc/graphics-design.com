<?php	

/*

 	Author:			Will Chapman	(webmail@dreamscripts.net)
 	Description:	Gather and parse information based on agent string.

	Updates:		v0.5 -	Added FreeBSD detection
					v0.4 - 	Moved W3C Validation to robots section
							Fixed syntax error in robots detection
					v0.3 -  Fixed bug in detecting Windows 98 with MSIE 5.0
					v0.2 - 	Added support for Web Crawlers
							Added support for Konqueror
							Detailed Windows Detection (still buggy)

	License File:	License.txt

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

class client_info 
{ 
    var $platform;
    var $browser; 
	var $robots;

    function client_info() 
    { 
		$this->robots = array(
							"zyborg", 
							"W3C_Validator", 
							"W3C_CSS_Validator", 
							"WebStripper", 
							"Googlebot",
							"FAST-WebCrawler",
							"ia_archiver",
							"WebCopier",
							"TurnitinBot",
							"WebWasher");

      	$this->platform = "Unknown"; 
      	// Determine the platform they are on 
        if (strstr($this->get_user_agent(),'Win'))  
		{
        	$this->platform="Windows";
			if ( preg_match("/NT 5\.1/i", $this->get_user_agent()) )
				$this->platform = "Windows XP";
			else if ( preg_match("/NT 5\.0/i", $this->get_user_agent()) )
				$this->platform = "Windows 2000";
			else if ( preg_match("/Windows 2000/i", $this->get_user_agent()) )
				$this->platform = "Windows 2000";
			else if ( preg_match("/98/i", $this->get_user_agent()) )
				$this->platform = "Windows 98";
			else if ( preg_match("/95/i", $this->get_user_agent()) )
				$this->platform = "Windows 95";
			else if (preg_match("/ME/i", $this->get_user_agent()))
				$this->platform = "Windows ME";
		} 
        else if (strstr($this->get_user_agent(),'Mac')) 
            $this->platform='Macintosh'; 
        else if (strstr($this->get_user_agent(),'Linux')) 
            $this->platform='Linux'; 
        else if (strstr($this->get_user_agent(),'Unix')) 
            $this->platform='Unix'; 
        else if (strstr($this->get_user_agent(),'FreeBSD')) 
            $this->platform='FreeBSD'; 
        else 
            $this->platform='Other'; 
         
		// Mozilla
        if ( preg_match("/(^Mozilla)(.)*\;\srv:([0-9]\.[0-9])/i", $this->get_user_agent(), $found) )
			$this->browser = $found[1] . " " . $found[3];
			
		// Opera (Disguised as MSIE)
        else if ( preg_match("/Opera ([0-9]\.[0-9]{0,2})/i", $this->get_user_agent(), $found) && 
               strstr($this->get_user_agent(), "MSIE") ) 
             $this->browser = "Opera " . $found[1]; 
             
		// Opera (Disguised as Netscape/Mozilla)
        else if ( preg_match("/Opera ([0-9]\.[0-9]{0,2})/i", $this->get_user_agent(), $found) && 
                 strstr($this->get_user_agent(), "Mozilla") ) 
             $this->browser = "Opera " . $found[1]; 
		
		// Opera (Itself)
        else if ( preg_match("/Opera\/([0-9]\.[0-9]{0,2})/i", $this->get_user_agent(), $found) ) 
			$this->browser = "Opera " . $found[1]; 
		
		// Netscape 6.x
        else if ( preg_match("/Netscape[0-9]\/([0-9]{1,2}\.[0-9]{1,2})/i", $this->get_user_agent(), $found) ) 
            $this->browser = "Netscape " . $found[1]; 
		
		// Netscape 4.x
        else if ( preg_match("/Mozilla\/([0-9]{1}\.[0-9]{1,2}) \[en\]/i", $this->get_user_agent(),$found) ) 
			$this->browser = "Netscape " . $found[1]; 
		
		// MSIE
		else if ( preg_match("/MSIE ([0-9]{1,2})/i", $this->get_user_agent(), $found) ) 
            $this->browser = $found[0]; 

		// Konqueror
		else if ( preg_match("/Konqueror/i", $this->get_user_agent()) ) 
			$this->browser = "Konqueror";
		
		// Galeon
		else if ( preg_match("/Galeon/i", $this->get_user_agent()) ) 
			$this->browser = "Galeon"; 

		// Web Crawler
		else if ( $this->chk_crawler() )
			$this->browser = "Web Crawler";

		// Other (Dont know what is it)
        else 
          $this->browser = "Other - " . $this->get_user_agent(); 
    }
	
    // Return the platform detected 
	function get_os() 
	{ 
		return ($this->platform); 
	} 

	// Compare agent string with a list of known web crawlers/robots
	function chk_crawler()	
	{
		foreach($this->robots as $value)
			if ( preg_match("/" . $value . "/i", $this->get_user_agent()) )
				return true; 
		return false;
	}
	
	// Return the browser that we detected 
	function get_browser() 
	{ 
		return ($this->browser); 
	} 

	// Return the user agent string 
	function get_user_agent() 
	{ 
		return $_SERVER['HTTP_USER_AGENT']; 
	}

} 
?> 