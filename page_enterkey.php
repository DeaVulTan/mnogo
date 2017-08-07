<table class="table_content" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id='header'><label>Регистрация нового пользователя</label></td>
	</tr>
	<tr>
		<td id="item">
<?php 
if (!$act_success)
{		
	?>
	<br />
	<div style="text-align:center;">Введите ключ активации, отправленный на указанный Вами E-Mail адрес:</div>
	<br />
	<?php
		if  ($_GET['login']) { $login = $_GET['login']; }
		if ($_POST['login']) { $login = $_POST['login']; }
		
		if (isset($error))
		{
			echo "<div id='error'>".$error."</div>";
			unset($error);
		}
	?>
	<form action="index.php?p=enterkey" method="post" name="enterkey">
	<table align="center" class="table_enterkey" cellspacing="5">
		<tr>
			<td id="cell1">Имя пользователя: </td>
			<td id="cell2"><input name="login" type="text" size="32" maxlength="15" value="<? echo $login; ?>" /></td>
		</tr>
		<tr>
			<td id="cell1">Ключ активации: </td>
			<td id="cell2"><input name="key" type="text" size="32" maxlength="64" /></td>
		</tr>
		<tr>
			<td colspan="2"><div style="text-align:center;"><input name="enterkey" type="submit" value="Проверить ключ" /></div></td>
		</tr>
	</table>
	</form>
	<?php
}
else
{
	$result = mysql_query("SELECT login, password FROM users WHERE login = '".$login."'", $db);
	$user = mysql_fetch_array($result);
	?>
	<form action='index.php' method='post' name='auth'>
		<input name='login' type='hidden' value='<?php echo $user['login']; ?>' />
		<input name='password_crypted' type='hidden' value='<?php echo $user['password']; ?>' />
		<div id="ok">Ключ подтверждён. Активация прошла успешно!</div>
		<br />
		<div style="text-align:center;"><input name='auth' type='submit' value=' Войти в систему ' /></div>
	</form>
	<?php
	}
	unset($result);
	unset($act_success, $user, $login);
?>
		</td>
	</tr>
</table>