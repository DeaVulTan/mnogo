<?php
	echo "Converting...<br />";
	$db = mysql_connect("localhost", "softstream", "cjanbyf") or die("Error: connect");
	mysql_select_db("softstream", $db);
	
	$result = mysql_query("SELECT `id`, `links` FROM `files`", $db);
	while ($item = mysql_fetch_array($result))
	{
		echo $item['links']." | ".preg_replace("/http:\/\/soft.stream.uz/", "http://files.stream.uz", $item['links'])."<br />";	
		mysql_query("UPDATE `files` SET `links` = '".preg_replace("/http:\/\/soft.stream.uz/", "http://files.stream.uz", $item['links'])."' WHERE `id` = '".$item['id']."'", $db) or die("Error: UPDATE - ".mysql_error());
	}
	mysql_free_result($result);
	unset($item);
	mysql_close($db);
	echo "<br /><br />All done.";
?>