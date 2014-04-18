<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Database Connect - Step 2</title>
</head>

<body>

<?php 
	require_once 'login.php';
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db($db_database, $db_server)
		or die("Unable to select database: " . mysql_error());
	$db_table = 'whereru_gigapan';  // description in Sakai Resources
	$query = "SELECT * FROM $db_table";
	$result = mysql_query($query);
	if (!$result) die ("Database access failed: " . mysql_error());
?>
																		
</body>
</html>