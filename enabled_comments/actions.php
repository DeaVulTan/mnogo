<?php
	// -[NF]- BEGIN OF AUTHORIZATION -[NF]- //
	if (isset($_POST['auth']) and empty($_POST['searchstring']))
	{
		$login = mb_convert_case($_POST['login'], MB_CASE_LOWER);
		$login_crypted = md5($login.$salt);
		$password_crypted = md5($_POST['password'].$salt);
		if (isset($_POST['password_crypted'])) { $password_crypted = $_POST['password_crypted']; }
		
		$result = mysql_query("SELECT id, login, visible_name, password, isactive FROM users WHERE login = '".$login."'", $db);
		$user = mysql_fetch_array($result);
		if (!mysql_num_rows($result))
		{
			// log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� �����������, ������������ �� ���������� � �������.</font> ��������: ����� - <strong>".$login."</strong> ; ������ - <strong>".$_POST['password']."</strong>");
			$error="<div id='error'>�������� ��� ������������ ��� ������</div>";
		}
		if ($user['isactive'] != '1' and $error == '')
		{
			// log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� �����������, ������������ �� �����������</font> (<strong>".$user['login']."</strong>, ID: <strong>".$user['id']."</strong>)");
			$error="<div id='error'>������������ � ����� ������ �� ������ ��������� ���������</div>";
		}
		if ($login == $user['login'] and $password_crypted == $user['password'] and $error == '')
		{
			$last_date = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));
			mysql_query("UPDATE users SET last_date = '".$last_date."', last_ip = '".$_SERVER['REMOTE_ADDR']."' WHERE id = '".$user['id']."'", $db);
			setcookie ('SESSIONID', md5($password_crypted.$login_crypted.$last_date.$salt), time()+86400);
			setcookie ('USERID', $user['id'], time()+86400);
			setcookie ('USERNAME', $user['visible_name'], time()+86400);
			// log_write("<font color='#1E990A'>[".$_SERVER['REMOTE_ADDR']."] - �������� ���� � �������</font> (<strong>".$user['login']."</strong>, ID: <strong>".$user['id']."</strong>)");
			mysql_close($db);
			header ("Location: index.php");
			exit(0);
		}
		elseif ($error == '')
		{
			// log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� �����������, �������� ����� ��� ������.</font> ��������: ����� - <strong>".$login."</strong> ; ������ - <strong>".$_POST['password']."</strong>");
			$error="<div id='error'>�������� ��� ������������ ��� ������</div>";
		}
		unset($result);
		unset($user);
	}
	// -[NF]-- END OF AUTHORIZATION --[NF]- //
	
	// -[NF]- BEGIN OF  REGISTRATION -[NF]- //
	if (isset($_POST['register']))
	{
		require_once ('phpmailer/class.phpmailer.php');

		function SendMail($email, $subj, $body, $altbody) 
		{
	   	 	$mail = new PHPMailer();

		    $mail->From = "soft@stream.uz";
			$mail->FromName = "Prosoft.Uz Registration Service";
	 	  	$mail->AddAddress($email);
	   		$mail->CharSet = "cp1251";
			$mail->IsHTML(true);

		    $mail->Subject = $subj;
		    $mail->Body    = $body;
	    	$mail->AltBody = $altbody;

		    if (!$mail->Send()) {}
		}

		$visible_name = $_POST['login'];
		$login = mb_convert_case($visible_name, MB_CASE_LOWER);
		$password = $_POST['password'];
		$password2 = $_POST['password2'];
		$email = $_POST['email'];
		$error = "";
		
//		if ($_POST['agree'] != 1)
//		{
//			$error = "<div id='error'>��� ����������� ����������� �� ������ ������� ������� ����������</div>";
//		}
		
		if ($password != $password2 and $error == "")
		{
			$error = "<div id='error'>�������� ������ �� ���������</div>";
		}
		
		$verify_email = explode("@", $email);
		if ($verify_email[0] == "" or $verify_email[1] == "" and $error=="")
		{
			$error = "<div id='error'>�� ����� ���������������� E-mail �����</div>";
		}
		
		$verify_email = explode(".", $verify_email[1]);
		if ($verify_email[0] == "" or $verify_email[1] == "" and $error=="")
		{
			$error = "<div id='error'>�� ����� ���������������� E-mail �����</div>";
		}
					
		if ($login=="" or $password=="" or $password2=="" or $email=="" or $login==" " or $password==" " or $password2==" " or $email==" ")
		{
			$error = "<div id='error'>���������� ��������� ��� ����</div>";
		}
		
		if (preg_match("/[^a-z0-9\- _]/i", $login)) 
		{
			$error = "<div id='error'>����������� ������� � ������</div>";
		}
		
		if (preg_match("/[^A-Za-z0-9\- _]/i", $password)) 
		{
			$error = "<div id='error'>����������� ������� � ������</div>";
		}

		if (preg_match("/[^a-z0-9\- _ @ .]/i", $email)) 
		{
			$error = "<div id='error'>����������� ������� � e-mail ������</div>";
		}

		else
		{
			if ($error=="")
			{
				$result = mysql_query("SELECT * FROM users WHERE login = '".$login."'", $db);
				if (mysql_num_rows ($result))
				{
					$error = "<div id='error'>������������ � ����� ������ ��� ��������������� � �������</div>";
					// // log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� �����������, ������������ � ����� ������ ��� ���������� � �������.</font> ��������: ����� - <strong>".$login."</strong>");
				}
			}
			if ($error=="")
			{
				$result = mysql_query("SELECT * FROM users WHERE email = '$email'", $db);
				if (mysql_num_rows ($result))
				{
					$error = "<div id='error'>������������ � ����� E-mail ������� ��� ��������������� � �������</div>";
					// // log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� �����������, ������������ � ����� E-mail ��� ���������� � �������.</font> ��������: ����� - <strong>".$login."</strong>, E-mail: <strong>".$email."</strong>");
				}
			}
		}
		
		if ($error=="")
		{
			$login_crypted = md5($login.$salt);
			$password_crypted = md5($password.$salt);
			$reg_date = mktime(date("H"), date("i"), date("s"), date("n"), date("j"), date("Y"));
			$result = mysql_query("INSERT INTO users (login, password, visible_name, email, reg_date, reg_ip, last_date, last_ip, isadmin, isactive, isblocked) VALUES ('$login', '$password_crypted', '$visible_name', '$email', '$reg_date', '".$_SERVER['REMOTE_ADDR']."', '$reg_date', '".$_SERVER['REMOTE_ADDR']."', '0', '0', '0')", $db);
			if ($result)
			{
				$result = mysql_query("SELECT * FROM users WHERE login='".$login."'", $db);
				$user = mysql_fetch_array($result);
				$key = md5("actuser".md5($user['login'].$salt).$user['password'].$salt).md5("regdate".$user['reg_date'].$salt);
				$body = preg_replace("/\(\(LOGIN\)\)/", $login, $BODY_ACT);
				$body = preg_replace("/\(\(KEY\)\)/", $key, $body);
				$altbody = $body;
				SendMail($email, $SUBJ_ACT, $body, $altbody);
				// // log_write("<font color='#1E990A'>[".$_SERVER['REMOTE_ADDR']."] - �������� �����������</font> (<strong>".$user['login']."</strong>, ID: <strong>".$user['id']."</strong>, E-mail: <strong>".$user['email']."</strong>)");
				unset($result);
				unset($login_crypted, $password, $password_crypted, $email, $body, $altbody, $key, $user, $reg_date);
				mysql_close($db);
				header("Location: index.php?p=enterkey&login=".$login);
				unset($login);
				exit(0);
			}
			else
			{
				echo "������ ��� ���������� �������: ".mysql_error();
			}
		}
	}
	// -[NF]-- END OF REGISTRATION --[NF]- //
	
	// -[NF]-- BEGiN OF ACTIVATION --[NF]- //
	if (isset($_POST['enterkey']))
	{
		if (isset($_GET['login'])) { $login = strip_tags($_GET['login']); }
		if (isset($_POST['login'])) { $login = strip_tags($_POST['login']); }

		if (isset($_POST['key']) or isset($_GET['key']))
		{
			if (isset($_GET['key'])) { $key = strip_tags($_GET['key']); }
			if (isset($_POST['key'])) { $key = strip_tags($_POST['key']); }
	
			$result = mysql_query("SELECT * FROM users WHERE login = '".$login."'", $db);
			$result = mysql_fetch_array($result);
			if (!$result)
			{
				// // log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� ���������, ������������ �� ��������������� � �������.</font> ��������: ����� - <strong>".$login."</strong>");
				$error = "<div id='error'>������������ ".$login." �� ��������������� � �������</div>";
			}
			if ($result['isactive'] == '1')
			{
				// // log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� ���������, ������������ ��� ����������� � �������.</font> ��������: �����: <strong>".$login."</strong>");
				$error = "<div id='error'>������������ ".$login." ��� �����������</div>";
			}
			$correctkey = md5("actuser".md5($login.$salt).$result['password'].$salt).md5("regdate".$result['reg_date'].$salt);
			if ($key != $correctkey)
			{
				// // log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� ���������, �������� ����.</font> ��������: ����� - <strong>".$login."</strong>, ���� ��������� - <strong>".$key."</strong>");
				unset ($key, $correctkey);
				$error = "<div id='error'>�������� ���� ���������</div>";
			}
			else
			{
				mysql_query("UPDATE users SET isactive = '1' WHERE login = '".$login."'", $db);
				// // log_write("<font color='#1E990A'>[".$_SERVER['REMOTE_ADDR']."] - �������� ���������</font> (<strong>".$login."</strong>, ID: <strong>".$resuit['id']."</strong>)");
				unset ($key, $correctkey);
				$act_success = 1;
			}
		}
	}
	// -[NF]--- END OF  ACTIVATION ---[NF]- //
	
	// -[NF]-- BEGIN OF KEY REQUEST --[NF]- //
	if (isset($_POST['requestkey']))
	{
		require_once ('phpmailer/class.phpmailer.php');	

		function SendMail($email, $subj, $body, $altbody) 
		{
    		$mail = new PHPMailer();

		     $mail->From = "soft@stream.uz";
			$mail->FromName = "Prosoft.Uz Registration Service";
		    $mail->AddAddress($email);
		    $mail->CharSet = "cp1251";
		    $mail->IsHTML(true);

		    $mail->Subject = $subj;
		    $mail->Body    = $body;
		    $mail->AltBody = $altbody;

		    if (!$mail->Send()) {}
		}

		if (isset($_POST['login']) and isset($_POST['email']))
		{
			if (isset($_POST['login'])) { $login = $_POST['login']; }
			if (isset($_POST['email'])) { $email = $_POST['email']; }
		
			if ($login == '')
			{
				$error = "<div id='error'>���������� ������� ��� ������������</div>";
			}

			if ($email == '')
			{
				$error = "<div id='error'>���������� ������� E-Mail �����</div>";
			}
		
			$verify_email = explode("@", $email);
			if ($verify_email[0] == "" or $verify_email[1] == "" and $reg_error=="")
			{
				$error = "<div id='error'>�� ����� ���������������� E-mail �����</div>";
			}
		
			$verify_email = explode(".", $verify_email[1]);
			if ($verify_email[0] == "" or $verify_email[1] == "" and $reg_error=="")
			{
				$error = "<div id='error'>�� ����� ���������������� E-mail �����</div>";
			}
		
			$result = mysql_query("SELECT login, email FROM users WHERE email = '".$email."'", $db);
			if (mysql_num_rows($result) != 0)
			{
				$result = mysql_fetch_array($result);
				if ($result['login'] != $login)
				{
					// // log_write("<font color='#DD1D06'>[".$_SERVER['REMOTE_ADDR']."] - ��������� ������� ���������� ������� ����� ���������, ������ E-Mail, ��� �������������� ������ �������������.</font> ��������: �����: <strong>".$login."</strong>, E-mail: <strong>".$email."</strong>");
					$error = "<div id='error'>������������ � ����� E-mail ������� ��� ��������������� � �������</div>";
				}
			}
			
			$result = mysql_query("SELECT * FROM users WHERE login = '".$login."'", $db);
			$result = mysql_fetch_array($result);
			if (!$result)
			{
				$error = "<div id='error'>������������ � ����� ������ �� ��������������� � �������</div>";		
			}
			if ($result['isactive'] == '1')
			{
				$error = "<div id='error'>������������ � ����� ������ ��� ������ ��������� ���������</div>";
			}
	
			if (!isset($error)) // ���� ������ ��� ��������, ���������� ����
			{
				$key = md5("actuser".md5($login.$salt).$result['password'].$salt).md5("regdate".$result['reg_date'].$salt);			
				mysql_query("UPDATE users SET email = '".$email."' WHERE login = '".$login."'", $db); // ���������� � �� ����� E-Mail

				// ������ � ���������� ������
			
				$body = preg_replace("/\(\(LOGIN\)\)/", $login, $BODY_ACT);
				$body = preg_replace("/\(\(KEY\)\)/", $key, $body);
				$altbody = $body;
				SendMail($email, $SUBJ_ACT, $body, $altbody);
				// // log_write("<font color='#B27011'>[".$_SERVER['REMOTE_ADDR']."] - ���� ��������� ������������ <strong>".$login."</strong>, ID: <strong>".$resuit['id']."</strong> �������� ��������� �� E-mail <strong>'".$email."'</strong> </font>");
				$act_success = 1;
			}
		}
	}
	// -[NF]--- END OF KEY REQUEST ---[NF]- //
	
	// -[NF]---- BEGIN OF  LOGOUT ----[NF]- //
	if ($_GET['act'] == 'logout')
	{
		setcookie ('SESSIONID', "");
		setcookie ('USERID', "");
		setcookie ('USERNAME', "");
		mysql_close($db);
		header("Location: index.php");
		die();
	}
	// -[NF]----- END OF  LOGOUT -----[NF]- //
	
	// -[NF]-- BEGIN OF NEW COMMENT --[NF]- //
	if ($_POST['addcomment'])
	{
		$error = 0;
		if (md5($_POST['code']) == $_COOKIE["IMAGECODE"])
		{
			if ($_POST['text'] != "����� ������ �����������")
			{
				$result = mysql_query("INSERT INTO comments SET"
					." file_id = '".$_POST['file_id']."',"
					." text = '".substr(strip_tags($_POST['text']), 0, 300)."',"
					." added_by = '".strip_tags($_COOKIE['USERNAME'])."',"
					." ip_address = '".$_POST['ip_address']."',"
					." datetime = '".mktime(date(H), date(i), date(s), date(m), date(d), date(Y))."'", $db) or die("ERROR INSERT: ".mysql_error());
				if ($result)
				{
					$operation_result .= "<div id='ok'>��� ����������� ��������</div>";
					unset ($_POST['file_id']);
					unset ($_POST['text']);
					unset ($_POST['added_by']);
					unset ($_POST['password']);
					unset ($correct_password);
					unset ($_POST['ip_address']);
					unset ($_POST['code']);
					unset ($_POST['correct_code']);
				}
				else
				{
					$operation_result .= "<div id='error'>������ ��� ���������� �����������: ".mysql_error()."</div>";
				}
			}
			else
			{
				$operation_result .= "<div id='error'>���������� ������ ����� �����������</div>";
			}
		}
		else
		{
			$operation_result .= "<div id='error'>������� ����� �������� ���</div>";
		}
	}
	// -[NF]--- END OF NEW COMMENT ---[NF]- //
?>