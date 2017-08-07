#!/usr/bin/php
<?php
	$db = mysql_connect('localhost', 'softstream', 'GffNRNyYA2VAfbeK');
	mysql_select_db('softstream', $db);
	
	mysql_query ("UPDATE files SET"
		." today = '".mktime(0, 0, 0)."',"
		." downloads_today = '0'", $db)
	or die ("Error UPDATE");
	
	$logfile = fopen ("/var/www/soft.stream.uz/htdocs/resetlog.html", 'a');
	$logstr = "Скрипт запущен. Счётчики обнулены.";
	$logdate = date("[".d."/".m."/".Y." ".H.":".i.":".s."] ");
	$return = "<br>"; // перевод строки для HTML
	fwrite ($logfile, $logdate.$logstr.$return);
	fclose ($logfile);
?>
