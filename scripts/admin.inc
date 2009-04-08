<?
//--------------------------------------------------------------------------------------------------
//ScriptName: admin.inc
//Author: Phil Crosby
//Description: 	Includes admin functions, including authorization code
//--------------------------------------------------------------------------------------------------

//--------------------------------------------------------------------------------------------------
//Includes
//--------------------------------------------------------------------------------------------------

function checkSessionAuth(){
	if (!session_is_registered("valid_user")){
		echo "You are not logged in, and not authorized to view this page.";
		exit;
	}
}
?>