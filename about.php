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
			$operation_result="<div class='ok'>��� ����������� ��������</div>";
			unset ($_POST['file_id']);
			unset ($_POST['text']);
			unset ($_POST['added_by']);
			unset ($_POST['ip_address']);
			unset ($_POST['code']);
			unset ($_POST['correct_code']);
		}
		else
		{
			$operation_result="<div class='error'>������ ��� ���������� �����������: ".mysql_error()."</div>";
		}
	  }
	  else
	  {
		$operation_result="<div class='error'>������� ����� �������� ���</div>";
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
<td bgcolor='#BCD9EA'><label><div class='file_desc_date'>� �������</div></label></td>
</tr>
<tr>
<td>
<div class='file_desc_text'>�� ���� �������������� ��� �� ����� ������� mySoft, �������, ��� �� ����������, �������� ������������ ����������� � ����� ��� � ��� �������!<br>
<br>
� ��� ������� ��������� ����� ���������� � ������������ �������� �� ������ ����. ��� ����������� ����������� ��������� �� ������� �������, ����� ��� ������������, �����������, �������� � ���� � �.�., ������� � ���� ������� �������������� �� ����������� �������� ������������ � ��� ����������, ��� ����������� �������� ���������.<br>
<br>
��������� �������������� ���������� � �����������. ����������� ��� ������ ���������. ��� ���� ��������� � �����������, ������������ ������ �������, ���������� �� ����� ������, � ����� ���������� �� ����� <a href='mailto:soft@stream.uz'>soft@stream.uz</a>.
<br><br>
����� ����������!</div>
<br>
</td>
</tr>
<tr>
<td bgcolor='#BCD9EA'><label><div class='file_desc_date'>������</div></label></td>
</tr>
<tr>
<td>
<div class='file_desc_text'><strong>��������!</strong><br> 
<br>
��� ����������� �����������, ���������� �� �����, �� �������� �������� �������������� � ������������ ������ � ��������������� �����, ��� ������������ ��� ����������� ��������� � ������ ����������.<br>
<br>
����������� �����������, ���������� ���������� �������, ������������� ������������ ������������� ��������.<br>
<br>
������������� � ��������������� ��������������� ������������ ����������� �������� ���������������.<br>
<br>
�� ���������� ��������������� �������������� ����� ������ �� ������������� ��� "Sharq Telekom", �� ��������� ����� ��������������� �� �����.<br>
<br></div>
</td>
</tr>
</table>
<?

	///
	/// ����� ��� ������� 478x60
	///
	
	echo "</td>"; 	 // ----
	echo "</tr>"; 	 // ----
	echo "</table>"; // ----

?>
<? require_once ('footer.php'); ?>
</body>
</html>
