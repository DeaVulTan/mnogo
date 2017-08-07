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
	<div style="text-align:center;">Введите логин и E-Mail адрес, на который будет отправлен ключ активации:</div>
	<br />
	<?php
		if (isset($error))
		{
			echo "<div id='error'>".$error."</div>";
			unset($error);
		}
		if  ($_GET['login']) { $login = $_GET['login']; }
		if ($_POST['login']) { $login = $_POST['login']; }
	?>
	<form action="index.php?p=requestkey" method="post" name="requestkey">
	<table class="table_requestkey" cellspacing="0" cellpadding="3" align="center">
		<tr>
			<td id="cell1">Имя пользователя: </td>
			<td id="cell2"><input name="login" type="text" size="32" maxlength="15" value="<? echo $login; ?>"></td>
		</tr>
		<tr>
			<td id="cell1"><font id="footnote">*</font > E-Mail:</td>
			<td id="cell2"><input name="email" type="text" size="32" maxlength="64" value="<? echo $_POST['email']; ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><div id="footnote" style="text-align:center;">* Введённый адрес заменит указанный ранее при регистрации!</div></td>
		</tr>
		<tr>
			<td colspan="2"><div style="text-align:center;"><input name="requestkey" type="submit" value="Отправить запрос"></div></td>
		</tr>
	</table>
	</form>
	<?php
}
else
{
	?>
	<div id="ok">Ключ активации отправлен на указанный E-mail адрес.</div>
	<br />
	<form action='index.php?p=enterkey&login=<?php echo $login; ?>' method='post' name='auth'>
		<input name='login' type='hidden' value='<?php echo $login; ?>' />
		<div style="text-align:center;"><input name='requestkey_submit' type='submit' value=' Ввести ключ ' /></div>
	</form>
	<?php	
}
	unset($result);
	unset ($_POST['login'], $_POST['email'], $login, $email, $act_success);
?>
		</td>
	</tr>
</table>
