<?
	setcookie ('SESSIONID', '');
	$anotherpage = "index.php";
	header("Location: $anotherpage");
	die;

?>