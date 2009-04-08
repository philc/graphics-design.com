<?
session_start();

//Header HTML
echo "<html><head><title>GDS Admin - Login</title></head>";
echo "<center><font face=arial><B>GDS Admin Section</b><br><br>";

//See if user is already logged in
if (session_is_registered("valid_user")){
	displayActionsMenu();
	
//See if user/pass was submitted from the form
}else if ($username && $password){
	require_once("/home/philisoft/scripts/graphics/dbvars.php");
	@ $db=mysql_connect("$dbAddress",$dbUser, $dbPassword);
	if (!$db){
		echo "Could not connect to mySQL database! Fail";
		exit;
	}
	mysql_select_db("$dbDatabase");
	
	$query="select id from graphics_posters "
				."where username='$username' and password=password('$password')";
	$result = mysql_query($query);
	$numRows = mysql_num_rows($result);
	
	if ($numRows < 1){	//Not a successful user/pass combo
		echo "<center>Your username and / or password is incorrect.";
		displayLoginForm();
	}else{					//Log the user in.
		//Set this user as a valid user in the session
		$array=mysql_fetch_array($result);
		$valid_user=$username;
		$id=$array["id"];
		session_register("valid_user");
		session_register("id");

		//Display actions Menu (for registered users only)
		displayActionsMenu();
	}
	
}else{
	displayLoginForm();
}

function displayLoginForm(){
	echo "<form action='index.php' method=post>";
	echo "<center><table border=0 cellpadding=0 cellspacing=4>";
	echo "<tr><td>Username: </td><td><input type=text name=username maxlength=20 size=20></td></tr>";
	echo "<tr><td>Password: </td><td><input type=password name=password maxlength=20 size=20></td></tr>";
	echo "<tr><td colspan=2><center><input type=submit></td></tr></table>";
}

function displayActionsMenu(){
	echo "<center><table border=0 cellpadding=0 cellspacing=0><tr><td>";
	echo "<a href='adminNews.php'>News Admin</a><br>";
	echo "<a href='adminCreations.php'>Creations Admin</a><br>";
	echo "<a href='adminDownloads.php'>Downloads Admin</a><br>";
	echo "<a href='adminFreeImages.php'>Free Images Admin</a><br>";
	echo "<a href='adminLinks.php'>Links Admin</a><br>";
	echo "<a href='adminPortfolio.php'>Portfolio Admin</a><br>";
	echo "<a href='adminTutorials.php'>Tutorials Admin</a><br>";
}

?>

