<?
	$db = mysql_connect('192.168.140.108', 'softstream', 'aLJtLhhwLrnXFE8V');
//	mysql_select_db('softstream', $db); // local
	mysql_select_db('softstream', $db); // upload

	// VARIABLES
	$files_on_page = 20;
	$license = array("-- не определен --", "Shareware", "Free", "Demo", "Adware", "Trial");
	$type = 0; // Default license type
	$correct_sid = md5("dbf7d6b895b34f5600b16d4156d2ec16"."0a606299b91306e1bbe0af697d5db583");
	
	$correct_login_md5    = "dbf7d6b895b34f5600b16d4156d2ec16";
	$correct_password_md5 = "f95a7fca6e6ace6c053d62c6f2eab789";
	$salt 		      = "12987AhlOQ18829AH9920LNjsjw(@872";
	$correct_sessionid    = md5($correct_password_md5.$correct_login_md5);
	
	// REQUIRED FILES
	require_once('../functions.php');
?>
