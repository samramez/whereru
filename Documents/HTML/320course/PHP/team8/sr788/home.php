<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Home Page</title>
<style type="text/css">
</style>
<link href="homecss.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarVertical.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryMenuBarVertical_costum.css" rel="stylesheet" type="text/css">
<style type="text/css">
#description {
	position: absolute;
	width: 330px;
	height: 117px;
	z-index: 4;
	left: 8px;
	top: 475px;
	font-size: 12px;
}
#apDiv1 {
	position: absolute;
	width: 353px;
	height: 116px;
	z-index: 5;
	left: 365px;
	top: 473px;
}
</style>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
</head>

<body>
<nav>
  <ul id="MenuBar1" class="MenuBarVertical">
    <li><a class="here" href="home.php">Home</a>    </li>
    <li><a href="browse.php">Browse</a></li>
</ul>
<P></p>
<P></p>
<P></p>
<form method="get" action="$actionString">
				Search
				<input name="text" type="text" />
                <input type="submit" name="Submit" value="Go!" />
	
</form>


</nav>
<header>WhereRU</header>
<section>

<style type="text/css">
/* reset styles */
html, body, h1, h2, h3, h4, h5, h6, p, ol, ul, li, pre, code, address, variable, form, fieldset, blockquote {
	/* [disabled]padding: 0; */
	margin: 0;
	font-size: 100%;
	font-weight: normal;
}
/* end reset styles */
/* define class for displaying a gigapan ... just a simple beginning to give you idea how to get started */
.gigapan {
	border: thick;
	border-top-color: #FFF;
	border-top-width: thick;
	border-top-style: double;
	
}


</style>


<?php




	
	// use require_once to make sure that login credentials are not loaded more than once (which otherwise would produce an error)
	// IMPORTANT: you need to modify the file for the login php file so that YOUR login file is loaded
	require_once 'login_ramezanli.php'; 
	// connect to server and test if successful
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) {
		die("Unable to connect to MySQL: " . mysql_error() . "<br /");
	} 
	/*else {
		echo "Connected to MySQL <br />";
	}
	*/
	
	
	// connect to specific database on server and test if successful
	if (mysql_select_db($db_database, $db_server)) {
		//echo "Connected to database = $db_database <br />";
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
	
	
	
	
	// specify MySQL query
	//$query = "SELECT * FROM $db_table"; // * means everything
	//$query1 = "SELECT * FROM $db_table WHERE campus='Newark' ORDER BY date_created DESC"; // campus='Camden'"; campus='Newark'";
	
	$query = "SELECT * FROM $db_table WHERE campus='New Brunswick' "; // campus='Camden'"; campus='Newark'";
	
	//$query3 = "SELECT * FROM $db_table WHERE campus='Camden' ORDER BY date_created DESC"; // campus='Camden'"; campus='Newark'";
	
	//$query = "SELECT * FROM $db_table ORDER BY campus, date_created DESC"; // 
	
	
	//$query = $query1 ; 
	
	
	
	
	
	//$query = "SELECT * FROM $db_table ORDER BY campus, date_created DESC"; 
	//
	// send query to server and test if result returned
	$result = mysql_query($query, $db_server) or die("Unable to retrieve query: " . mysql_error());
	// if the result is non-empty, then display which username used to access database
	// editedif ($result) echo "user =\"$db_username\" was <b>successful</b> in retrieving result.<hr />";
	//
	
	
	
		
		
		
	// specify width and height of Gigapan that will be embedded
	$width = 800;
	$height = 450;
	// determine number of rows in the result returned
	$rows = mysql_num_rows($result);
	//echo("<p>Number of Gigapans = $rows.</p>");
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
	for ($j = 0 ; $j < 1 ; ++$j) { // $rows >> 11
		// fetch specific row which is an indexed array and thus we need to use specific numbers to access the desired database field 
		$row = mysql_fetch_row($result);
		
		 
		//
		
		// embed first five Gigapans
		if ($j < 1) {
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
		else {
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
				// set width to 84 = 100 - 10 - 5 - 1 ... could define variables
				// IMPORTANT t needs to be set to 1 for Gigapan
				echo("<img src=\"http://whereru.rutgers.edu/thumb.php?id=$row[$id]&t=1&w=84&h=42\" border=\"0\" />");
				echo("</td>");
			} else {
				//
				echo("<td>");
				// show thumbnail image and you need to pass the thumb.php file these variables: id, w and h (which are indicated by &)
				// notice the use \ to escape the needed quotation marks
				// set width to 84 = 100 - 10 - 5 - 1 ... could define variables
				// IMPORTANT t needs to be set to 1 for Gigapan
				echo("<img src=\"http://whereru.rutgers.edu/thumb.php?id=$row[$id]&t=1&w=84&h=42\" border=\"0\" />");
				echo("</td>");
			}
		}
	} 
	// need to place closing table row and then table tag if $rows > 5 and thus a table was created
	if ($rows > 5 && $table_started) {
		echo("</tr>");
		echo("</table>");
	}
	



?>

<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>



<div id="description">whereRU is a digital media portal that lets you explore Rutgers and its three campuses in a virtual way. Created by faculty and students at the School of Communication &amp; Information, whereRU uses zoomable panoramas (Gigapans), image kaleidoscopes (Photosynths) and digital videos – all geo-coded and viewable in an interactive map – to tell Rutgers' story in a new and visual way.</div>
<div id="apDiv1"></div>
</section>
<script type="text/javascript">
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
</script>
</body>
</html>
