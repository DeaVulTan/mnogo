<?
$sessionid = $_COOKIE['SESSIONID'];
$sid = mysql_query("SELECT login, password FROM users WHERE id = '$id'", $db);
$sid = mysql_fetch_array($sid);
$login_crypted = encrypt($sid['login'], $salt);
$password_crypted = $sid['password'];
if ($login_crypted=='' or $password_crypted=='')
{
	mysql_close($db);
	header ("Location: index.php");
	die;
}
if (encrypt ($password_crypted.$login_crypted, $salt) != $sessionid)
{
	mysql_close($db);
	header ("Location: index.php");
	die;
}
else
{
	setcookie ('SESSIONID', encrypt ($password_crypted.$login_crypted, $salt), time()+86400);
}
?>