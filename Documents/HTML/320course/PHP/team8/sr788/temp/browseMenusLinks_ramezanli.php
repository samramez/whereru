<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Browse using Pull-down Menu</title>
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
	//require_once 'login_lastname.php'; 
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
	// select _all !
	$db_table = 'whereru_all';
	//
	// Once this page works, want to extract variables from URL
	// So that extracted variables don't conflict with ones that you have already defined
	// use parameter in extract function, like this:
	//*
	$fromget_campus = "all"; // 0 = all in case variable is not passed along with URL
	$fromget_media = "all"; // in case variable is not passed along with URL
	$fromget_page = "1"; // in case variable is not passed along with URL
	//
	extract($_GET, EXTR_PREFIX_ALL, 'fromget');
	// sanitize $_GET data
	$fromget_campus = sanitizeString($fromget_campus);
	$fromget_media = sanitizeString($fromget_media);
	$fromget_page = sanitizeString($fromget_page);
	// Next we need to provide an URL for action parameter when form gets uploaded
	// IMPORTANT: make sure actionString is equal to the correct file name
	$actionString = "browseMenusLinks_lastname.php"; // "browseMenusLinks_lastname.php";
	
	$resultsPerPage = 20;
	
	$campusName = "New Brunswick";
	// need to convert $fromget_campus numerical code into campus name
	if ($fromget_campus == "all") {
		$campusName = "all";
	} elseif ($fromget_campus == "1") {
		$campusName = "New Brunswick";
	} elseif ($fromget_campus == "2") {
		$campusName = "Newark";
	} elseif ($fromget_campus == "3") {
		$campusName = "Camden";
	}
	
	// need to specify the WHERE string component of SQL query string
	$where = "WHERE campus=\"$campusName\"";
	if ($campusName == "all") {
		$where = "";
	}
	// add media type requirements to $where and can use $fromget_media since
	if ($fromget_media !== "all") {
		if ($where == "") {
			$where = "WHERE type=\"$fromget_media\"";
		} else {
			$where = $where . " AND " . "type=\"$fromget_media\"";
		}
	}
	
	// SQL query
	$query = "SELECT * FROM $db_table $where ORDER BY date_created DESC";

	//
	// send query to server and test if result returned
	$result = mysql_query($query, $db_server) or die("Unable to retrieve query: " . mysql_error());
	// if the result is non-empty, then display which username used to access database
	if ($result) echo "user =\"$db_username\" was <b>successful</b> in retrieving result.<hr />";
	
	/* want to create a selection form that behaves like a pull-down menu
	<form>
	<label>
	// this.form.submit is used that the page gets updated when the form is changed
	Campus <select name="campus" size="1" onchange="this.form.submit()">
	<option value="all">All</option>
	<option value="1">New Brunswick</option>
	<option value="2">Newark</option>
	<option value="3">Camden</option>
	</select>
	</label>
	</form>
	
	Now the catch is that the form is submitted onchange 
	and we need to make sure that the selected option is displayed in the reloaded page
	and this reason we need to check if $fromget_campus is equal to a specific option
	
	Further, to be able to specify campus and media, we have select forms inside of the form tag.
	
	*/
	
	// sandwich two select forms inside of form so that we can access their selected values
	echo("<form method=\"get\" action=$actionString>");
	echo("<p>");
	echo("
		 Selected campus = $fromget_campus<br />
		 <label>Campus
		 <select name=\"campus\" size=\"1\" onchange=\"this.form.submit()\">
		 ");
	if ($fromget_campus == "all") {
			echo("<option selected=\"selected\" value=\"all\">All</option>");
		} else {
			echo("<option value=\"all\">All</option>");
	}
	if ($fromget_campus == "1") {
			echo("<option selected=\"selected\" value=\"1\">New Brunswick</option>");
		} else {
			echo("<option value=\"1\">New Brunswick</option>");
	}
	if ($fromget_campus == "2") {
			echo("<option selected=\"selected\" value=\"2\">Newark</option>");
		} else {
			echo("<option value=\"2\">Newark</option>");
	}
	if ($fromget_campus == "3") {
			echo("<option selected=\"selected\" value=\"3\">Camden</option>");
		} else {
			echo("<option value=\"3\">Camden</option>");
	}
	echo("
		 </select>
		 </label>
		 ");
	echo("</p>");
	
	// also want a form pull down menu to specify media
	echo ("<p>");
	echo("
		 Selected media = $fromget_media<br />
		 <label>Media
		 <select name=\"media\" size=\"1\" onchange=\"this.form.submit()\">
		 ");
	if ($fromget_media == "all") {
			echo("<option selected=\"selected\" value=\"all\">All</option>");
		} else {
			echo("<option value=\"all\">All</option>");
	}
	if ($fromget_media == "gigapan") {
			echo("<option selected=\"selected\" value=\"gigapan\">Gigapan</option>");
		} else {
			echo("<option value=\"gigapan\">Gigapan</option>");
	}
	if ($fromget_media == "photosynth") {
			echo("<option selected=\"selected\" value=\"photosynth\">Photosynth</option>");
		} else {
			echo("<option value=\"photosynth\">Photosynth</option>");
	}
	if ($fromget_media == "video") {
			echo("<option selected=\"selected\" value=\"video\">Video</option>");
		} else {
			echo("<option value=\"video\">Video</option>");
	}
	echo("
		 </select>
		 </label>
		 ");
	echo("</p>");
	// closing tag for form 
	echo("</form>");
	
	// specify width and height of Gigapan that will be embedded
	$width = 500;
	$height = 250;
	// determine number of rows in the result returned
	$rows = mysql_num_rows($result);
	echo("<p>Number of Items = $rows.</p>");
	// to reduce number of times that the database needs to be consulted 
	// use mysql_fetch_row which returns an array and we need to use indexes to access specific fields
	// you need to consult SAKAI > Resources to see the available fields and their order in the table
	$id = 0; 
	// need to know type so that we set $t parameter to correct number is used for thumbnail
	$type = 1;
	$title = 2;
	$campus = 3;
	$category=4;
	$embed = 16;
	//
	$column_counter = 0;
	$table_started = false;
	for ($j = 0 ; $j < $rows ; ++$j) {
		// fetch specific row which is an indexed array and thus we need to use specific numbers to access the desired database field 
		$row = mysql_fetch_row($result);
		$mediaType = $row[$type];
		// set $t so that the correct number is used for thumbnail
		$t = 0;
		if ($mediaType == "gigapan") {
			$t=1;
		} elseif ($mediaType == "photosynth") {
			$t=2;
		} elseif ($mediaType == "video") {
			$t=3;
		}
		//echo("$row[$category]");
		//
		if (($j >= (($fromget_page-1) * $resultsPerPage)) AND ($j < ($fromget_page * $resultsPerPage))) {
			// test if first time that a thumbnail will be displayed in table row
			// need to first create table and notice use of \ escape
			if (!$table_started) {
				$table_started = true;
				echo("<table width=\"500\" border=\"1\" cellspacing=\"10\" cellpadding=\"5\">");
				// create first row
				echo("<tr>");
			}
			// test how many thumbnails have been created side-by-side
			$column_counter += 1;
			if ($column_counter > 5) {
				// reset counter
				$column_counter = 1;
				// first need to close current row if it exists
				echo("</tr>");
				// create new table row
				echo("<tr>");
				// create table cell
				echo("<td>");
				// show thumbnail image and you need to pass the thumb.php file these variables: id, w and h (which are indicated by &)
				// notice the use \ to escape the needed quotation marks
				// attach hyperlink that loads individual Gigapan page and supply id of Gigapan
				echo("<a href=\"databaseConnect_individual.php?id=$row[$id]&type=$mediaType\">");
				// set width to 84 = 100 - 10 - 5 - 1 ... could define variables
				// IMPORTANT t needs to be set to $t
				echo("<img src=\"http://whereru.rutgers.edu/thumb.php?id=$row[$id]&t=$t&w=84&h=42\" border=\"0\" />");
				// close hyperlink tag
				echo("</a>");
				echo("</td>");
			} else {
				//
				echo("<td>");
				// show thumbnail image and you need to pass the thumb.php file these variables: id, w and h (which are indicated by &)
				// notice the use \ to escape the needed quotation marks
				echo("<a href=\"databaseConnect_individual.php?id=$row[$id]&type=$mediaType\">");
				// set width to 84 = 100 - 10 - 5 - 1 ... could define variables
				// IMPORTANT t needs to be set to $t
				echo("<img src=\"http://whereru.rutgers.edu/thumb.php?id=$row[$id]&t=$t&w=84&h=42\" border=\"0\" />");
				echo("</a>");
				echo("</td>");
			}
		}
	} 
	// need to place closing table row and then table tag if $rows > 5 and thus a table was created
	if ($rows > 5 && $table_started) {
		echo("</tr>");
		echo("</table>");
	}
	
	// sanitizing functions
	function sanitizeString($var)
	{
		$var = stripslashes($var);
		$var = htmlentities($var);
		$var = strip_tags($var);
		return $var;
	}
	
	function sanitizeMySQL($var)
	{
		$var = mysql_real_escape_string($var);
		$var = sanitizeString($var);
		return $var;
	}

?>
</body>
</html>
