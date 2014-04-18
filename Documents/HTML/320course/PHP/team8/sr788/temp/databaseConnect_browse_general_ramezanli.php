<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script id="f5_cspm">(function(){var f5_cspm={f5_p:'NNABBCCAEAJABAAEOGAAAABAAGCAAAAAEABACFAADFNBAAAADAAAAPAAJONFAAAA',setCharAt:function(str,index,chr){if(index>str.length-1)return str;return str.substr(0,index)+chr+str.substr(index+1);},get_byte:function(str,i){var s=(i/16)|0;i=(i&15);s=s*32;return((str.charCodeAt(i+16+s)-65)<<4)|(str.charCodeAt(i+s)-65);},set_byte:function(str,i,b){var s=(i/16)|0;i=(i&15);s=s*32;str=f5_cspm.setCharAt(str,(i+16+s),String.fromCharCode((b>>4)+65));str=f5_cspm.setCharAt(str,(i+s),String.fromCharCode((b&15)+65));return str;},set_latency:function(str,latency){latency=latency&0xffff;str=f5_cspm.set_byte(str,20,(latency>>8));str=f5_cspm.set_byte(str,21,(latency&0xff));str=f5_cspm.set_byte(str,18,2);return str;},wait_perf_data:function(){try{var wp=window.performance.timing;if(wp.loadEventEnd>0){var res=wp.loadEventEnd-wp.navigationStart;if(res<60001){var cookie_val=f5_cspm.set_latency(f5_cspm.f5_p,res);window.document.cookie='aaaaaaaaaaaaaaa='+encodeURIComponent(cookie_val)+';path=/';}
return;}}
catch(err){return;}
setTimeout(f5_cspm.wait_perf_data,100);return;},go:function(){var chunk=window.document.cookie.split(/\s*;\s*/);for(var i=0;i<chunk.length;++i){var pair=chunk[i].split(/\s*=\s*/);if(pair[0]=='f5_cspm'){if(pair[1]=='1234'){var d=new Date();d.setTime(d.getTime()-1);window.document.cookie='f5_cspm=;expires='+d.toUTCString()+';path=/;';setTimeout(f5_cspm.wait_perf_data,100);}}}}}
f5_cspm.go();}());</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Database Connect - ALL</title>
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
	// select _all !
	$db_table = 'whereru_all';
	//
	/*
	$fromget_type = 'gigapan';
	$fromget_campus = 'New Brunswick';
	$fromget_category = 'Architecture & History';
	$fromget_page = 1;
	*/
	// Once this page works, want to extract variables from URL
	// So that extracted variables don't conflict with ones that you have already defined
	// use parameter in extract function, like this:
	//*
	extract($_GET, EXTR_PREFIX_ALL, 'fromget');
	if (!$fromget_type) { $fromget_type = 'gigapan'; }
	if (!$fromget_campus) { $fromget_campus = 'New Brunswick'; }
	if (!$fromget_category) { $fromget_category = 'Architecture & History'; }
	if (!$fromget_page) { $fromget_page = 1; }
	//*/
	$resultsPerPage = 20;
	echo("media type = " . "<b>" . $fromget_type . "</b>" . " campus = " . "<b>" . $fromget_campus . "</b>" . " category = " . "<b>" . $fromget_category . "</b>" . " page = " . "<b>" . $fromget_page . "</b>" . "<br />");
	// specify MySQL query
	//$query = "SELECT * FROM $db_table"; // * means everything
	//$query = "SELECT * FROM $db_table WHERE type='gigapan' AND campus='New Brunswick' AND category='Architecture & History' ORDER BY date_created DESC"; 
	$query = "SELECT * FROM $db_table WHERE type=\"$fromget_type\" AND campus=\"$fromget_campus\" AND category=\"$fromget_category\" ORDER BY date_created DESC";
	//
	// send query to server and test if result returned
	$result = mysql_query($query, $db_server) or die("Unable to retrieve query: " . mysql_error());
	// if the result is non-empty, then display which username used to access database
	if ($result) echo "user =\"$db_username\" was <b>successful</b> in retrieving result.<hr />";
	//
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
		// echo("media type = $mediaType");
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
				// set width to 84 = 100 - 10 - 5 - 1 ... could define variables
				// IMPORTANT t needs to be set to $t
				echo("<img src=\"http://whereru.rutgers.edu/thumb.php?id=$row[$id]&t=$t&w=84&h=42\" border=\"0\" />");
				echo("</td>");
			} else {
				//
				echo("<td>");
				// show thumbnail image and you need to pass the thumb.php file these variables: id, w and h (which are indicated by &)
				// notice the use \ to escape the needed quotation marks
				// set width to 84 = 100 - 10 - 5 - 1 ... could define variables
				// IMPORTANT t needs to be set to $t
				echo("<img src=\"http://whereru.rutgers.edu/thumb.php?id=$row[$id]&t=$t&w=84&h=42\" border=\"0\" />");
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
  
</body>
</html>