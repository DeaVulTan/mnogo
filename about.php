<? session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META NAME="Author" CONTENT="NessawolF [NF], nfstrider@gmail.com">
<title>PROSoft</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<? require_once ('include.php'); ?>
<?
	if ($_POST['addcomment'])
	{
//	  if ($_POST['code'] == $_SESSION["ImageCode"])
	  if (md5($_POST['code']) == $_COOKIE["IMAGECODE"])
	  {
	  	if ($_POST['added_by'] == "" or $_POST['added_by'] == " ")
		{
			$_POST['added_by'] = "Anonymous";
		}
		$result = mysql_query("INSERT INTO comments SET"
			." file_id = '".$_POST['file_id']."',"
			." text = '".strip_tags($_POST['text'])."',"
			." added_by = '".strip_tags($_POST['added_by'])."',"
			." ip_address = '".$_POST['ip_address']."',"
			." datetime = '".mktime(date(H), date(i), date(s), date(m), date(d), date(Y))."'", $db);
		if ($result)
		{
			$operation_result="<div class='ok'>Ваш комментарий добавлен</div>";
			unset ($_POST['file_id']);
			unset ($_POST['text']);
			unset ($_POST['added_by']);
			unset ($_POST['ip_address']);
			unset ($_POST['code']);
			unset ($_POST['correct_code']);
		}
		else
		{
			$operation_result="<div class='error'>Ошибка при добавлении комментария: ".mysql_error()."</div>";
		}
	  }
	  else
	  {
		$operation_result="<div class='error'>Неверно введён защитный код</div>";
	  }
	}
?>

<body>
<? require_once ('header.php'); ?>

<?
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr>";

	// ======================
	// ===== LEFT FIELD =====
	// ======================
	
	echo "<td width='250' valign='top'>"; // ----

		include ('left.php');
	
	echo "</td>"; // ----
	
	// ======================
	// == VERTICAL DIVIDER ==
	// ======================
		
	echo "<td width='30'>&nbsp;</td>"; // ----

	// ======================
	// ===== MAIN  PART =====
	// ======================
		
	echo "<td valign='top'>"; // ----
	
	// CATEGORIES LIST

		require_once ('cat_list.php');

?>
<table width='100%' border='0' cellpadding='3' cellspacing='3'>
<tr>
<td bgcolor='#BCD9EA'><label><div class='file_desc_date'>О ПРОЕКТЕ</div></label></td>
</tr>
<tr>
<td>
<div class='file_desc_text'>Мы рады приветствовать Вас на нашем портале mySoft, который, как Вы догадались, посвящен программному обеспечению и всему что с ним связано!<br>
<br>
У нас собрана коллекция самых популярных и используемых программ на каждый день. Все программное обеспечение разделено на удобные разделы, такие как Безопасность, Мультимедиа, Интернет и сети и т.д., которые в свою очередь подразделяются на подкаталоги согласно находящемуся в нем содержанию, что значительно упрощает навигацию.<br>
<br>
Программы сопровождаются аннотацией и скриншотами. Обновляется наш портал ежедневно. Все Ваши пожелания и предложения, относительно нового ресурса, оставляйте на нашем форуме, а также присылайте на почту <a href='mailto:soft@stream.uz'>soft@stream.uz</a>.
<br><br>
Добро пожаловать!</div>
<br>
</td>
</tr>
<tr>
<td bgcolor='#BCD9EA'><label><div class='file_desc_date'>ОФЕРТА</div></label></td>
</tr>
<tr>
<td>
<div class='file_desc_text'><strong>Внимание!</strong><br> 
<br>
Все программное обеспечение, выложенное на сайте, не является объектом лицензирования и представлено строго в ознакомительных целях, что предполагает его последующее удалением с вашего компьютера.<br>
<br>
Программное обеспечение, защищенное авторскими правами, обуславливает приобретение лицензионного продукта.<br>
<br>
Использование и распространения нелицензионного программного обеспечения является правонарушением.<br>
<br>
За дальнейшее распространение представленных здесь файлов ни Администрация ООО "Sharq Telekom", ни владельцы сайта ответственности не несут.<br>
<br></div>
</td>
</tr>
</table>
<?

	///
	/// МЕСТО ДЛЯ БАННЕРА 478x60
	///
	
	echo "</td>"; 	 // ----
	echo "</tr>"; 	 // ----
	echo "</table>"; // ----

?>
<? require_once ('footer.php'); ?>
</body>
</html>
