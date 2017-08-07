<?
	$db = mysql_connect('192.168.140.108', 'softstream', 'aLJtLhhwLrnXFE8V');
//	mysql_select_db('softstream', $db); // local
	mysql_select_db('softstream', $db); // upload

	// VARIABLES
	$salt = "J92x038KpqpOEn381Lxm7Yk229dzN28R";			 
	$files_on_page = 20;
	$license = array("-- не определен --", "Shareware", "Free", "Demo", "Adware", "Trial");
	$type = 0; // Default license type
	
	//MAIL
	$SUBJ_ACT = "Ключ активации Prosoft.Uz";
	$BODY_ACT = "
			Уважаемый ((LOGIN)),<br />
			Это письмо отправлено с сервиса Prosoft.Uz<br />
			Вы получили это письмо, так как этот e-mail адрес был использован при регистрации на сайте. 
			Если Вы не регистрировались на этом сайте, просто проигнорируйте это письмо и удалите его. 
			Вы больше не получите такого письма.<br />
			<br />
			------------------------------------------------<br />
			Инструкция по активации<br />
			------------------------------------------------<br />
			<br />
			Благодарим Вас за регистрацию.<br />
			Мы требуем от Вас подтверждения Вашей регистрации, для проверки того, что введённый Вами 
			E-Mail адрес - реальный. Это требуется для защиты от нежелательных злоупотреблений и спама.<br />
			<br />
			Для активации Вашего аккаунта, пройдите по следующей ссылке:<br />
			<a href='http://www.prosoft.uz/index.php?p=enterkey&login=((LOGIN))&key=((KEY))'>http://www.prosoft.uz/index.php?p=enterkey&login=((LOGIN))&key=((KEY))</a><br />
			<br />
			или введите следующие данные в форму активации на странице <a href='http://www.prosoft.uz/index.php?p=enterkey'>http://www.prosoft.uz/index.php?p=enterkey</a> вручную:<br />
			Имя пользователя: ((LOGIN))<br />
			Ключ активации: ((KEY))<br />
			<br />
			Если активация не удалась, возможно Ваш аккаунт удалён. В этом случае обратитесь к 
			Администратору для разрешения проблемы.<br />
			<br />
			С уважением,<br />
			<br />
			Администрация Prosoft.Uz<br />
			<br />
		";
	
	// REQUIRED FILES
	require_once('functions.php');
?>
