<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><script id="f5_cspm">(function(){var f5_cspm={f5_p:'FIBBBCCAEALABAAELFAAAABAAOCAAAAAEABABGAAIMNBAAAADAAAAMAAONNFAAAA',setCharAt:function(str,index,chr){if(index>str.length-1)return str;return str.substr(0,index)+chr+str.substr(index+1);},get_byte:function(str,i){var s=(i/16)|0;i=(i&15);s=s*32;return((str.charCodeAt(i+16+s)-65)<<4)|(str.charCodeAt(i+s)-65);},set_byte:function(str,i,b){var s=(i/16)|0;i=(i&15);s=s*32;str=f5_cspm.setCharAt(str,(i+16+s),String.fromCharCode((b>>4)+65));str=f5_cspm.setCharAt(str,(i+s),String.fromCharCode((b&15)+65));return str;},set_latency:function(str,latency){latency=latency&0xffff;str=f5_cspm.set_byte(str,20,(latency>>8));str=f5_cspm.set_byte(str,21,(latency&0xff));str=f5_cspm.set_byte(str,18,2);return str;},wait_perf_data:function(){try{var wp=window.performance.timing;if(wp.loadEventEnd>0){var res=wp.loadEventEnd-wp.navigationStart;if(res<60001){var cookie_val=f5_cspm.set_latency(f5_cspm.f5_p,res);window.document.cookie='aaaaaaaaaaaaaaa='+encodeURIComponent(cookie_val)+';path=/';}
return;}}
catch(err){return;}
setTimeout(f5_cspm.wait_perf_data,100);return;},go:function(){var chunk=window.document.cookie.split(/\s*;\s*/);for(var i=0;i<chunk.length;++i){var pair=chunk[i].split(/\s*=\s*/);if(pair[0]=='f5_cspm'){if(pair[1]=='1234'){var d=new Date();d.setTime(d.getTime()-1);window.document.cookie='f5_cspm=;expires='+d.toUTCString()+';path=/;';setTimeout(f5_cspm.wait_perf_data,100);}}}}}
f5_cspm.go();}());</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>First PHP program</title>
</head>

<body>

<?php // firstPHPlastname.php 
	// date(...) ... NOTICE: use of . operator to concatenate strings
	echo "Hello World. Today is ".date("l").". ";
	echo "<br />";
	// check user agent string $_SERVER the browser sends as part of the HTTP request
	echo $_SERVER['HTTP_USER_AGENT'];
	echo "<br /><hr />";
	//
	$username = "Anselm Spoerri";
	echo $username . "<br />";
	$current_user = $username;
	echo "<h2>$current_user</h2><hr />";
	//
	$names = array('John Adams', 'Mary Douglass', 'Franz Sinatra');
	$selected = $names[2];
	// NOTICE: string that echo will make visible extends over several lines
	// this is useful when you have many lines of text to display
	echo 
	"
	<p>The name selected is <b>$selected</b></p>
	<hr />
	";
	echo "<p>(Using \".\" concatenation) <br />Names not selected are: " . $names[0] . ", " . $names[1] . ".</p><hr />";
	echo "<p>(Using opening \" and closing \" quotation marks) <br />Names not selected are: $names[0], $names[1].</p><hr />";
	// ==== EQUALITY vs. IDENTITY OPERATOR
	// Comparing the == equality and === identity operators
	$a = "1000";
	$b = "+1000";
	echo "<p>\"$a\" and \"$b\" are ";
	if ($a == $b) {echo "equal";} else { echo "not equal";}
	echo "</p";
	echo "<p>\"$a\" and \"$b\" are ";
	if ($a === $b) {echo "identical";} else { echo "not identical";}
	echo "</p";
	echo "<hr />";
	// ==== STRPOS function
	// strpos() is a function built into PHP which searches a string for another string
	if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {
    	echo "You are using <b>Internet Explorer</b>.<br />";
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== FALSE) {
		echo "You are using a <b>Mozilla</b> browser.<br />";
	} else {
		echo "You are not using an Internet Explorer or Mozilla browser.<br />";
	}
	echo "<hr />";
	// ==== WHILE LOOP 
	// multiplication table for x using a while loop
	echo "<p>Using <b>WHILE</b> loop :</p>";
	$count = 1;
	$x = 7;
	while ($count <= $x)
	{
    	echo "$count times $x is " . $count * $x . "<br />";
    	$count += 1; // could also use ++$count;
	}
	echo "<hr />";
	// ==== FOR LOOP
	// multiplication table for x using a for loop
	echo "<p>Using <b>FOR</b> loop :</p>";
	$x = 11;
	for ($counter = 1 ; $counter <= $x ; ++$counter) {
		echo "$counter times $x is " . $counter * $x . "<br />";
	}
	echo "<hr />";
	// ==== INDEX ARRAY and FOREACH LOOP
	// creating an index array and using a foreach loop so show the elements of an array
	echo "<p>Using <b>FOREACH</b> loop :</p>";
	$paper1 = array("Copier", "Inkjet", "Laser", "Photo");
	$j = 0;
	foreach ($paper1 as $item){
		echo "$j: $item<br />";
		++$j;
	}
	echo "<hr />";
	// ==== ASSOCIATIVE ARRAY and FOREACH LOOP
	// creating an associative array and using foreach loop
	echo "<p>Using <b>FOREACH</b> loop for Associative Array:</p>";
	$paper2 = array('copier' => "Copier & Multipurpose",
					'inkjet' => "Inkjet Printer",
					'laser'  => "Laser Printer",
					'photo'  => "Photographic Paper");
	foreach ($paper2 as $item => $description) 
	{
		echo "$item: $description<br />"; 
	}

?>

</body>
</html>