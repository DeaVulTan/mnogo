<table class="table_content" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id='header'><label>����������� ������ ������������</label></td>
	</tr>
	<tr>
		<td id="item">
		<?php
			if (isset($error))
			{
				echo "<div id='error'>".$error."</div>";
				unset($error);
			}
		?>
			<form action="index.php?p=register" method="post" name="register">
			<table align="center" class="table_registration_data" cellspacing="5">
				<tr>
					<td id="cell1">��� ������������: </td>
					<td id="cell2"><input name="login" type="text" size="25" maxlength="15" value="<? echo $login; ?>" /></td>
				</tr>
				<tr>
					<td id="cell1">E-mail: </td>
					<td id="cell2"><input name="email" type="text" size="25" maxlength="64" value="<? echo $email; ?>" /></td>
				</tr>
				<tr>
					<td id="cell1">������: </td>
					<td id="cell2"><input name="password" type="password" size="25" maxlength="20" /></td>
				</tr>
				<tr>
					<td id="cell1">������������� ������: </td>
					<td id="cell2"><input name="password2" type="password" size="25" maxlength="20" /></td>
				</tr>
<!--				<tr>
					<td colspan="2"><div style="text-align:center;"><input name="agree" type="checkbox" value="1"> � �������� ������� ����������</input></div></td>
				</tr> -->
				<tr>
				<td colspan="2"><div style="text-align:center;"><input name="register" type="submit" value="������������������" /></div></td>
				</tr>
				<tr>
					<td colspan="2">
						<div align="center"><a href="index.php?p=enterkey">������ ���� ���������</a></div><br />
					    <div align="center"><a href="index.php?p=requestkey">��������� ������ ����� ���������</a></div>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>
