<?
	$db = mysql_connect('192.168.140.108', 'softstream', 'aLJtLhhwLrnXFE8V');
//	mysql_select_db('softstream', $db); // local
	mysql_select_db('softstream', $db); // upload

	// VARIABLES
	$salt = "J92x038KpqpOEn381Lxm7Yk229dzN28R";			 
	$files_on_page = 20;
	$license = array("-- �� ��������� --", "Shareware", "Free", "Demo", "Adware", "Trial");
	$type = 0; // Default license type
	
	//MAIL
	$SUBJ_ACT = "���� ��������� Prosoft.Uz";
	$BODY_ACT = "
			��������� ((LOGIN)),<br />
			��� ������ ���������� � ������� Prosoft.Uz<br />
			�� �������� ��� ������, ��� ��� ���� e-mail ����� ��� ����������� ��� ����������� �� �����. 
			���� �� �� ���������������� �� ���� �����, ������ �������������� ��� ������ � ������� ���. 
			�� ������ �� �������� ������ ������.<br />
			<br />
			------------------------------------------------<br />
			���������� �� ���������<br />
			------------------------------------------------<br />
			<br />
			���������� ��� �� �����������.<br />
			�� ������� �� ��� ������������� ����� �����������, ��� �������� ����, ��� �������� ���� 
			E-Mail ����� - ��������. ��� ��������� ��� ������ �� ������������� ��������������� � �����.<br />
			<br />
			��� ��������� ������ ��������, �������� �� ��������� ������:<br />
			<a href='http://www.prosoft.uz/index.php?p=enterkey&login=((LOGIN))&key=((KEY))'>http://www.prosoft.uz/index.php?p=enterkey&login=((LOGIN))&key=((KEY))</a><br />
			<br />
			��� ������� ��������� ������ � ����� ��������� �� �������� <a href='http://www.prosoft.uz/index.php?p=enterkey'>http://www.prosoft.uz/index.php?p=enterkey</a> �������:<br />
			��� ������������: ((LOGIN))<br />
			���� ���������: ((KEY))<br />
			<br />
			���� ��������� �� �������, �������� ��� ������� �����. � ���� ������ ���������� � 
			�������������� ��� ���������� ��������.<br />
			<br />
			� ���������,<br />
			<br />
			������������� Prosoft.Uz<br />
			<br />
		";
	
	// REQUIRED FILES
	require_once('functions.php');
?>
