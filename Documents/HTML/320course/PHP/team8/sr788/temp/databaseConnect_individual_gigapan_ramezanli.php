<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Database Connect - Individual Gigapan</title>
<style type="text/css">
/* reset styles */
html, body, h1, h2, h3, h4, h5, h6, p, ol, ul, li, pre, code, address, variable, form, fieldset, blockquote {
 padding: 0;
 margin: 0;
 font-size: 100%;
 font-weight: normal;
}
/* end reset styles */
/* define class for displaying a gigapan ... just a simple beginning to give you idea how to get started */
.gigapan {
	border:thick;
	border-top-color:#00F;
	border-top-width:thick;
	border-top-style:double;
}
</style>

</head>

<body>

<?php 
	// use require_once to make sure that login credentials are not loaded more than once (which otherwise would produce an error)
	// IMPORTANT: you need to modify the file for the login php file so that YOUR login file is loaded
	require_once 'login_lastname.php'; 
	// connect to server and test if successful
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) {
		die("Unable to connect to MySQL: " . mysql_error() . "<br /");
	} else {
		echo "Connected to MySQL <br />";
	}
	// connect to specific database on server and test if successful
	if (mysql_select_db($db_database, $db_server)) {
		echo "Connected to database = $db_database <br />";
	} else {
		die("Unable to select database: " . mysql_error() . "<br />");
	}
	// to show another way to test if you were able to connect
	/*
	mysql_select_db($db_database, $db_server)
		or die("Unable to select database: " . mysql_error() . "<br />");
	*/
	// specify table to access in whereru database ... SAKAI > Resources conatains document describing wherrru tables and fields
	$db_table = 'whereru_gigapan';
	// specify MySQL query to retrieve gigapan with specific id 
	$fromget_id = 100;
	// Once this page works, want to extract id from URL via ?id
	// So that extracted variables don't conflict with ones that you have already defined
	// use parameter in extract function, like this:
	/*
	extract($_GET, EXTR_PREFIX_ALL, 'fromget');
	if (!$fromget_id) { $fromget_id = 100; }
	*/
	$query = "SELECT * FROM $db_table WHERE id=$fromget_id"; 
	// send query to server and test if result returned
	$result = mysql_query($query, $db_server) or die("Unable to retrieve query: " . mysql_error());
	// if the result is non-empty, then display which username used to access database
	if ($result) echo "user =\"$db_username\" was <b>successful</b> in retrieving result.<hr />";
	//
	// specify width and height of Gigapan that will be embedded
	$width = 700;
	$height = 400;
	// determine number of rows in the result returned
	$rows = mysql_num_rows($result);
	echo("<p>Number of Gigapans = $rows.</p>");
	// to reduce number of times that the database needs to be consulted 
	// use mysql_fetch_row which returns an array and we need to use indexes to access specific fields
	// you need to consult SAKAI > Resources to see the available fields and their order in the table
	$id = 0;
	$title = 2;
	$campus = 3;
	$embed = 16;
	//
	$column_counter = 0;
	$table_started = false;
	// only retrieving a single row
	$row = mysql_fetch_row($result);
	if ($rows > 0) {
		// embed Gigapan
		// opening tag for <p> with "gigapan" class applied
		echo("<p class=\"gigapan\">");
		echo("$row[$id] | $row[$title] | $row[$campus]");
		echo("<br />");
		// show embedded Gigapan SWF file
		// notice the use \ to escape the needed quotation marks and how units for width and height are provided
		// the <object> is structured so that so that embed code will be included so that we get the working html code
		echo(" 
		<object type=\"application/x-shockwave-flash\" style=\"width:$width"."px; height:$height"."px;\" data=\"$row[$embed]\" >
			<param name=\"movie\" value=\"$row[$embed]\" />
		</object>
		");
		// closing tag for <p> with class "gigapan" assigned
		echo("</p>");
	}
?>
  
</body>
</html>