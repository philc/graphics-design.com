<?php

/*

	Author:				Will Chapman	(webmail@dreamscripts.net)
	Version:			v0.4.2
	Description:		Wrapper class for MySQL interface.
	Updates:			Improved error support
							 - Now displays information in a javascript alert box

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



class mysql
{

	var $db_user;	// User name to login
	var $db_pass;	// Password
	var $db_server;	// Server to connect to
	var $db_db;		// Database name to use

	var $db_conn;	// Connection resource
	var $db_query;	// Query resource of most-recently executed sql query
	
	var $kill;		// Stop script if error occurs ?
	var $ok;		// Good database connection ?

	var $persistent;// Persistent connection

	// Object constructor
	function mysql($err_reporting=false)
	{
		$this->kill = $err_reporting;
		$this->db_query = "";
		$this->db_conn = "";
		$this->db_user = "";
		$this->db_pass = "";
		$this->db_server = "";
		$this->db_db = "";
		$this->ok = false;
	}
	
	// Update the "kill" option
	function update($new_bool)
	{
		$this->kill = $new_bool;
	}
	
	// Connect to the server and select the database	
	function connect($server, $login, $password, $database, $per=false)
	{
		$this->persistent = $per;
		$this->db_conn = ($per) ? @mysql_connect($server, $login, $password) : @mysql_pconnect($server, $login, $password);

		if ( ! $this->db_conn )
		{
			// We got probs !
			$this->db_conn = null;
			$this->error("mysql::connect", "Could not connect. \\nMysql Said: " . mysql_error(), __LINE__);
			return false;
		}
		else
		{
			// Its all good, so we can save the info
			$this->db_server = $server;
			$this->db_user = $login;
			$this->db_pass = $password;
			if ( ! mysql_select_db($database, $this->db_conn) )
			{
				// More probs
				$this->error("mysql::connect", "Database selection ($database).\\nMysql Said: " . mysql_error(),  __LINE__);
				return false;
			}
			else
			{
				$this->db_db = $database;
				$this->ok = true;
				return true;
			}			
		}
		return false;	// Just incase
	}
	
	// Handles errors produced by mysql
	function error($function, $desc, $line)
	{
		echo "<a href=\"#\" onclick=\"alert('Function:\\n-----------\\n" . $function . "\\n\\nDescription:\\n-----------\\n" . str_replace("'", "\'", $desc) . "\\n\\nLine:\\n-----------\\n" . $line . "');\">MySQL Error</a>";
		if ( $this->kill )
			die("<br />Script killed...");
	}

	// Closes connection to server
	function close()
	{
		if ( ! $this->persistent )
			@mysql_close($this->db_conn);
	}

	// How many records returned
	function recordcount()
	{
		return ( ($this->db_query != null) ? mysql_num_rows($this->db_query) : -1 );
	}

	// See if connection is still alive
	function alive()
	{
		return $this->ok;
	}

	// Executes query
	function query($sql, $type=MYSQL_ASSOC)
	{
		if ( $this->ok )
		{
			$this->db_query = mysql_query($sql);
			if ( ! $this->db_query )
			{
				// We got probs
				$this->db_query = null;
				$this->ok = false;
				$this->error("mysql->query", "Error in query (" . str_replace("'", "\'", $sql) . ").\\nMySQL Said:" . mysql_error(), __LINE__);
				return false;
			}	
			else
			{
				return true;
			}// end - if ( ! $this->db_query )
		} // end - if ( $this->ok )
		return false;
	}

	// Rturns a copy of the query object
	function get_query()
	{
		return $this->db_query;
	}

	// Returns a copy of the connection object
	function get_connection()
	{
		return $this->db_conn;
	}

	// Function to return a single value of a record set
	function result($field_name, $loc=0)
	{
		if ( $this->ok )
		{
			if ( mysql_num_rows($this->db_query) > 0 )
				return mysql_result($this->db_query, $loc, $field_name);
			else
				return 0;
		}
		else
			return false;
	}	

	// Constructs an "INSERT" statement
	// $field and $values must be parallel arrays
	function ez_insert($table_name, $field, $values)
	{

		$sql = "insert into `$table_name` (";
		$i = 0;
		while ( $i < count($field) )
		{
			$sql = $sql . "'" . $field[$i] . "'";
			$val_part = $val_part . "'" . $values[$i] . "'";
			if ( ($i + 1) != count($field) )
			{
				$val_part = $val_part . ", ";
				$sql = $sql . ", ";
			}
			$i++;
		}
		$sql = $sql . ") values (" . $val_part . ")";
		if ( ! $this->query($sql) )
			$this->error("mysql->ez_insert", "Could not execute the ez_insert statement.\\nGenerated SQL:" . $sql . "\\nMySQL Said:" . mysql_error(), __LINE__);
		else
			return true;
	}
}

?>
