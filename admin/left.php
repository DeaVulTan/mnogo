<?

	// ACTIONS
	
	$act_list = array (
		"Главная страница",
		"Добавить новую запись", 
		"Изменить запись",
		"Удалить запись",
		"Добавить категорию",
		"Изменить категорию",
		"Удалить категорию",
		"Управление комментариями",
		"Завершить сеанс"
	);
	$act_code = array (
		"",
		"addfile",
		"modifyfile",
		"delfile",
		"addcat",
		"modifycat",
		"delcat",
		"comments",
		"logout.php",
	);
	$link_list = array (
		"main.php",
		"main.php?act=addfile",
		"main.php?act=modifyfile",
		"main.php?act=delfile",
		"main.php?act=addcat",
		"main.php?act=modifycat",
		"main.php?act=delcat",
		"main.php?act=comments",
		"index.php",
	);
	echo "	<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "	<tr>";
	echo "	 <td height='30' background='img/leftheader.jpg'><div class='header_text'>Действия</div></td>";
	echo "	</tr>";	
	echo "  <tr><td><hr color='#99a9b3'></td></tr>";
	$num = 0;
	while ($act_list[$num])
	{
		echo "  <tr><td align='center'><font class='top_downloads_text'><a href='".$link_list[$num]."'>".$act_list[$num]."</font></a></td></tr>";
		echo "  <tr><td><hr color='#99a9b3'></td></tr>";
		$num++;
	}
	unset ($num);
	echo "  </table>";
	echo "	<br><br>";
	
?>