<? include ('include.php'); ?>
<?
 	if (isset($_POST['auth']))
	{
		if  (md5("aDm1n".$_POST['login']."l0G_iH") == $correct_login_md5
		 and md5("aDMlH".$_POST['password']."pAcSVVopD") == $correct_password_md5)
		{
			setcookie ('SESSIONID', $correct_sessionid, time()+3600);
			mysql_close($db);
			$anotherpage = "main.php";
			header("Location: $anotherpage");
			die;
		}
		else
		{
			mysql_close($db);
			$anotherpage = "index.php";
			header("Location: $anotherpage");
			die;
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META NAME="Author" CONTENT="NessawolF [NF], nfstrider@gmail.com">
<title>mySoft - Режим администратора</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="bbeditor.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/ed.js"></script>
</head>

<body>

<? include ('header.php'); ?>

<?
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr>";

	// ======================
	// ===== MAIN  PART =====
	// ======================
		
	echo "<td valign='top'>"; // ----
		
	// ---- START HERE ----
	
	echo "<center>
		<font size='3'>Для доступа в панель администратора необходима авторизация в системе:</font><br><br>
    	 <form action='index.php' method='post' name='auth'>
			<strong>Имя пользователя:</strong> <br>
			<input name='login' type='text' size='20' maxlength='20'><br>
			<strong>Пароль:</strong> <br>
			<input name='password' type='password' size='20' maxlength='20'>
			<br><br>
			<input name='auth' type='submit' value='Войти'>
    	  </form><br>";
		echo "<div class='error'>".$error."</div></center>";
		$error = "";
		
	echo "</td>"; 	 // ----
	echo "</tr>"; 	 // ----
	echo "</table>"; // ----

?>

<? include ('footer.php'); ?>
</body>
</html>
