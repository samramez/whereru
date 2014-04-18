<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script id="f5_cspm">(function(){var f5_cspm={f5_p:'FLABBCCAEALABAAEPOAAAABAAOCAAAAAEABABGAAIMNBAAAADAAAAMAAMNNFAAAA',setCharAt:function(str,index,chr){if(index>str.length-1)return str;return str.substr(0,index)+chr+str.substr(index+1);},get_byte:function(str,i){var s=(i/16)|0;i=(i&15);s=s*32;return((str.charCodeAt(i+16+s)-65)<<4)|(str.charCodeAt(i+s)-65);},set_byte:function(str,i,b){var s=(i/16)|0;i=(i&15);s=s*32;str=f5_cspm.setCharAt(str,(i+16+s),String.fromCharCode((b>>4)+65));str=f5_cspm.setCharAt(str,(i+s),String.fromCharCode((b&15)+65));return str;},set_latency:function(str,latency){latency=latency&0xffff;str=f5_cspm.set_byte(str,20,(latency>>8));str=f5_cspm.set_byte(str,21,(latency&0xff));str=f5_cspm.set_byte(str,18,2);return str;},wait_perf_data:function(){try{var wp=window.performance.timing;if(wp.loadEventEnd>0){var res=wp.loadEventEnd-wp.navigationStart;if(res<60001){var cookie_val=f5_cspm.set_latency(f5_cspm.f5_p,res);window.document.cookie='aaaaaaaaaaaaaaa='+encodeURIComponent(cookie_val)+';path=/';}
return;}}
catch(err){return;}
setTimeout(f5_cspm.wait_perf_data,100);return;},go:function(){var chunk=window.document.cookie.split(/\s*;\s*/);for(var i=0;i<chunk.length;++i){var pair=chunk[i].split(/\s*=\s*/);if(pair[0]=='f5_cspm'){if(pair[1]=='1234'){var d=new Date();d.setTime(d.getTime()-1);window.document.cookie='f5_cspm=;expires='+d.toUTCString()+';path=/;';setTimeout(f5_cspm.wait_perf_data,100);}}}}}
f5_cspm.go();}());</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Database Connect - Step 4</title>
</head>

<body>

<?php 
	require_once 'login_ramezanli.php';
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
	mysql_select_db($db_database, $db_server)
		or die("Unable to select database: " . mysql_error());
	$db_table = 'whereru_gigapan';  // description in Sakai Resources
	$query = "SELECT * FROM $db_table";
	$result = mysql_query($query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$rows = mysql_num_rows($result);
	$id = 0; // assign index needed to access field in $row array … see data info in Sakai
	$title = 2;
	$campus = 3;
	for ($j = 0 ; $j < $rows ; ++$j) { 
		$row = mysql_fetch_row($result);  // returns array
		echo 'ID: ' . $row[$id] . '<br />';    
		echo 'Title: ' . $row[$title] . '<br />';
		echo 'Campus: ' . $row[$campus] . '<br />' . '<br />';
	}
?>
																		
</body>
</html>