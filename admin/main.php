<? include ('include.php'); ?>
<? 
	if ($_COOKIE['SESSIONID'] != $correct_sessionid)
	{
		setcookie ('SESSIONID', '');
		$anotherpage = "index.php";
		header("Location: $anotherpage");
		die;
	}
	else
	{
		setcookie ('SESSIONID', $correct_sessionid, time()+3600);
	}
	
	if (isset($_POST['removegroup']))
	{
		$select = array_values($_POST['select']);
		foreach ($select as $comment_id)
		{		
			mysql_query("DELETE FROM comments WHERE id='$comment_id'", $db);
		}
	}
	
	if ($_GET['act'] == 'modifyfile' 
		and isset($_GET['fileid']) 
		and !isset($_GET['addition']) 
		and !isset($_GET['isross']))
	{
		$result = mysql_query("SELECT * FROM files WHERE id = '".$_GET['fileid']."'", $db);
		$current = mysql_fetch_array($result);
		if ($current['parent_item'] != "0")
		{
			$addition = "1";
		}
		else
		{
			$addition = "0";
		}
		if ($current['parent_item'] != "0" and $current['os'] == "")
		{
			$isruss = "1";
		}
		else
		{
			$isruss = "0";
		}
		mysql_close($db);
		header ("Location: main.php?act=".$_GET['act']."&fileid=".$_GET['fileid']."&addition=".$addition."&isruss=".$isruss);
		die;
	}
	
	function GetFilesSize ($var)
	{
		$links = explode ("http://", $var);
		foreach ($links as $link)
		{
			if ($link)
			{
				$url = explode(",", $link);
				$url = $url[0];
				$url = "http://".$url;
				$sch = parse_url($url);$sch = $sch['scheme'];
				if (($sch == "http") || ($sch == "https")) 
				{
					$ch = curl_init($url);
					curl_setopt($ch, CURLOPT_HEADER, 1);
					curl_setopt($ch, CURLOPT_NOBODY, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					$head = curl_exec($ch);
					curl_close($ch);
					preg_match('/Content-Length: ([0-9]+)/',$head,$matches);
					$size = ($matches[1] != '') ? $matches[1]:-1;
					if ( $size == -1 ) die("Error: size");
				}
				else die("Error: size");
				$sizeAll += $size;
			}
		}
		return $sizeAll;
	}
	
	if (isset($_POST['addfile']) or isset($_POST['modifyfile']))
	{
	  if ($_FILES['image']['name'])
	  {	
		// --------- IMAGE UPLOADING	
		$softimg_filename = mb_convert_case($_FILES['image']['name'], MB_CASE_LOWER);
		$softimg_tmpname  = $_FILES['image']['tmp_name'];
		$softimg_filetype = returnMIMEType($softimg_filename);
	
		$softimg_upload_dir = "../appsimg/";
	
		if ($softimg_filename)
		{
			switch ($softimg_filetype)
			{
				case "image/gif":
				$src_im = imagecreatefromgif($softimg_tmpname);
				$ref = ".gif";
				break;
			
				case "image/jpg":
				case "image/jpeg":
				case "image/pjpeg":
				$src_im = imagecreatefromjpeg($softimg_tmpname);
				if (substr($softimg_filename, (strlen($softimg_filename) - 4), 4) == "jpeg") {
					$softimg_filename = substr($softimg_filename, 0, (strlen($softimg_filename) - 4));
					$softimg_filename .= "jpg";
				}
				$ref = ".jpg";
				break;

				case "image/png":
				$src_im = imagecreatefrompng($softimg_tmpname);
				$ref = ".png";
				break;
			
				default:
				echo "Error uploading image. Wrong file type: '".$softimg_filetype."' (only .gif, .jpg, .png allowed).";
				mysql_close($db);
				die;
			}
			
		  	if (isset($_POST['modifyfile']))
			{
				$result = mysql_query("SELECT image FROM files WHERE id = '".$_POST['file_id']."'", $db);
				$file = mysql_fetch_array($result);
				if ($file['image'])
				{
					unlink("../".$file['image']);
					unlink("../".$file['image']."_thumb.jpg");
				}
			}
	
			$result = mysql_query("SELECT id FROM files WHERE image='appsimg/".$softimg_filename."'", $db);
			if (mysql_num_rows($result) != 0)
			{
				$num = 2;
				while (!$renamed):
				$fileNameRenamed = "(".$num.")".$softimg_filename;
				if (!file_exists($softimg_upload_dir.$fileNameRenamed))
				{
					$softimg_filename = $fileNameRenamed;
					$renamed = 1;
				}
				else
				{
					$num++;
				}
				endwhile;
			}
	
		    $softimg_filepath = $softimg_upload_dir . $softimg_filename;
	
		    $result    = move_uploaded_file($softimg_tmpname, $softimg_filepath);
			if (!$result) 
			{
				mysql_close($db);
				echo "Error uploading file";
				die;
			}
	
	    	if(!get_magic_quotes_gpc())
		    {
				$softimg_filename  = addslashes($softimg_filename);
				$softimg_filepath  = addslashes($softimg_filepath);
				$softimg_filename = preg_replace("/'/", "_", $softimg_filename);
				$softimg_filename = preg_replace('/"/', '_', $softimg_filename);
				$softimg_filename = preg_replace("/ /", "_", $softimg_filename);
			}

			$softimg_filepath = explode('../', $softimg_filepath);
			$link = $softimg_filepath[1];
		
			$softimg_filename = explode($ref, $softimg_filename);
			
		    $cover_filepath = $softimg_upload_dir . $softimg_filename[0] . $ref;
		    $thumbpath = $softimg_upload_dir . $softimg_filename[0] . $ref . "_thumb";
	
//			$thumbpath = explode($ref, $thumb_filepath);
//			$thumbpath = $thumbpath[0];
	
			list($width, $height) = getimagesize($cover_filepath);
			$new_width = 180;
			$new_height = $height * $new_width / $width;
			$dst_im = imagecreatetruecolor($new_width, $new_height);
			imagecopyresampled($dst_im, $src_im, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($dst_im, $thumbpath.".jpg", 100);
	
//			$cover_filepath = $thumbpath.$ref;
			$cover_filepath = explode("../", $cover_filepath);
			$cover_filepath = $cover_filepath[1];
		  }
		// --------- /IMAGE UPLOADING
		}
	
		$parent_list = $_POST['parent_list'];
		$num = 0;
		explode("(", $parent_list);
		while ($parent_list[$num] != "")
		{
			switch ($parent_list[$num])
			{
				case "(":
				$part = "";
				break;
				
				case ")":
				$part = ",";
				break;
				
				default:
				$part = $parent_list[$num];
				break;
			}
			$post = $post.$part;
			$num++;
		}
//		echo $post; // -- debug --
//		echo "<br>"; // -- debug --
		$post = explode(",", $post);
		$num = 0;
		while ($post[$num] != "")
		{
			$category = $post[$num];
			$num++;
		}
//		echo "POSTED CAT: ".$category; // -- debug --

	  if (isset($_POST['addfile']))
	  {
	  	$querystart = "INSERT INTO files SET";
		$create_date = mktime(date(H), date(i), date(s), date(m), date(d), date(Y));
		$queryend = "";
		$message = "��������";;
	  }
	  if (isset($_POST['modifyfile']))
	  {
	  	$querystart = "UPDATE files SET";
		switch ($_POST['date_mode'])
		{
			case keep_original:
			$create_date = mktime($_POST['H'], $_POST['i'], $_POST['s'], $_POST['m'], $_POST['d'], $_POST['Y']);
			break;
			
			case put_current:
			$create_date = mktime(date(H), date(i), date(s), date(m), date(d), date(Y));
			break;
		}
		if ($_POST['counter_reset'])
		{
			$querystart .= " downloads_today = '0', downloads_total = '0',";
		}
		$queryend = "WHERE id = '".$_POST['file_id']."'";
		$message = "�������";
		if (!$cover_filepath)
		{
			$cover_filepath = $_POST['image_current'];
		}
	  }
                // ." desc_long = '".preg_replace("/\r\n/", "<br>", $_POST['desc_long'])."',"
		$result = mysql_query($querystart
			." category = '".$category."',"
			." parent_list = '".$_POST['parent_list']."',"
			." parent_item = '".$_POST['parent_item']."',"
			." title = '".$_POST['title']."',"
			." title_download = '".$_POST['title_download']."',"
			." desc_short = '".addslashes($_POST['desc_short'])."',"
			." desc_long = '".addslashes($_POST['desc_long'])."',"
			." image = '".$cover_filepath."',"
			." os = '".$_POST['os']."',"
			." size = '".GetFilesSize($_POST['links_inner'])."',"
			." links_inner = '".$_POST['links_inner']."',"
			." links_outer = '".$_POST['links_outer']."',"
			." create_date = '".$create_date."',"
			." license = '".$_POST['license']."' ".$queryend, $db);
		if ($result)
		{
			$operation_result="<div class='ok'>���� ������� ".$message."</div>";
		}
		else
		{
			$operation_result="<div class='error'>������ ��� ".$message."�� ����� ".mysql_error()."</div>";
		}
		unset ($querystart);
		unset ($queryend);
		unset ($create_date);
		unset ($cover_filepath);
	}
	
	if (isset($_POST['delfile']))
	{
		$result = mysql_query("SELECT image FROM files WHERE id = '".$_POST['file_id']."'", $db);
		$file = mysql_fetch_array($result);
		if ($file['image'])
		{
//			$ref = returnfileSuffix($file['image']);
			unlink("../".$file['image']);
			unlink("../".$file['image']."_thumb.jpg");
			unset ($ref);
		}
		$result = mysql_query("DELETE FROM comments WHERE file_id = '".$_POST['file_id']."'", $db);
		$result = mysql_query("DELETE FROM files WHERE id = '".$_POST['file_id']."'", $db);
		if ($result)
		{
			$operation_result="<div class='ok'>���� ������� ������</div>";
		}
		else
		{
			$operation_result="<div class='error'>������ ��� �������� �����</div>";
		}
	}
	
	if (isset($_POST['addcat']))
	{
		$parent_list = "0, ";
	
		if ($_POST['parent'])
		{
			$parent_list = $parent_list . $_POST['parent'] . ", ";
		}
		
		$result = mysql_query("INSERT INTO categories SET"
			." title = '".$_POST['title']."',"
			." parent = '".$_POST['parent']."',"
			." parent_list = '".$parent_list."'", $db);
		if ($result)
		{
			$operation_result="<div class='ok'>��������� &quot;".$_POST['title']."&quot; ���������</div>";
		}
		else
		{
			$operation_result="<div class='error'>������ ��� ���������� ��������� &quot;".$_POST['title']."&quot;</div>";
		}
	}
	
	if (isset($_POST['modifycat']))
	{
		$result = mysql_query("UPDATE categories SET"
			." title = '".$_POST['title']."'"
			." WHERE id = '".$_POST['cat_id']."'", $db);
		if ($result)
		{
			$operation_result="<div class='ok'>��������� ���������</div>";
		}
		else
		{
			$operation_result="<div class='error'>������ ��� ��������� ���������</div>";
		}
	}
	
	if (isset($_POST['delcat']))
	{
		$result = mysql_query("SELECT title FROM categories WHERE id = '".$_POST['cat_id']."'", $db);
		$cat = mysql_fetch_array($result);
		$result = mysql_query("DELETE FROM categories WHERE id = '".$_POST['cat_id']."'", $db);
		if ($result)
		{
			$operation_result="<div class='ok'>��������� &quot;".$cat['title']."&quot; �������</div>";
		}
		else
		{
			$operation_result="<div class='error'>������ ��� �������� ��������� &quot;".$_POST['title']."&quot;</div>";
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META NAME="Author" CONTENT="NessawolF [NF], nfstrider@gmail.com">
<title>mySoft</title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="bbeditor.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/ed.js"></script>
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>

<body>
<? include ('header.php'); ?>

<?
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr>";

	// ======================
	// ===== LEFT FIELD =====
	// ======================
	
	echo "<td width='200' valign='top'>"; // ----

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

	for ($num = 0; $num < count($act_list); $num++)
	{
		if ($_GET['act'] == $act_code[$num])
		{
			$title = $act_list[$num];
			$act_code = "stat";
			break;
		}
		else
		{
			$title = "���������� �������";
		}
	}
	echo "	<table width='100%' bgcolor='#D2E0EA' cellpadding='0' cellspacing='0' border='0'>";
	echo "	<tr>";
	echo "	 <td height='30' bgcolor='#A2B1BA'><div class='header_text'>".$title."</div></td>";
	echo "  </tr>";
	if (isset($operation_result))
	{
	  echo "<tr>";
	  echo "<td>".$operation_result."</td>";
	  echo "</tr>";
	}
	echo "</table>";
	
	// ---- START HERE ----
  if (!$_GET['act'])
  {
	$result = mysql_query("SELECT downloads_today, downloads_total, size FROM files", $db);
	while ($stat = mysql_fetch_array($result))
	{
		$downloads_today = $downloads_today + $stat['downloads_today'];
		$downloads_total = $downloads_total + $stat['downloads_total'];
		$size = $size + $stat['size'];
	}
	echo "<div class='stat_text'><br><br>";
	echo "������� ���������� : <strong>".$downloads_today."</strong><br><br>";
	echo "����� ���������� : <strong>".$downloads_total."</strong><br><br>";
	switch ($size)
	{
		case $size > 1 and $size <= 1000:
		$size  = round (($size / 1.048576), 2);
		$units = "����";
		break;

		case $size > 1000 and $size <= 1000000:
		$size  = round (($size / 1048.576), 2);
		$units = "��";
		break;
			
		case $size > 1000000 and $size <= 1000000000:
		$size  = round (($size / 1048576), 2);
		$units = "��";
		break;

		case $size > 1000000000:
		$size  = round (($size / 1048576000), 2);
		$units = "��";
		break;
	}
	echo "����� ������ ����������� ������ : <strong>".$size." ".$units."</strong>";
	echo "</div>";
  }
  else
  {
	switch ($_GET['act'])
	{	
		case addfile:
		// ====================================
		// ===== ADD NEW FILE RECORD FORM =====
		// ====================================
		
		require_once('dataform.php');
		
		break;
		
		case modifyfile:
		// ===================================
		// ===== MODIFY FILE RECORD FORM =====
		// ===================================
		
		// DROPDOWN LIST
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td>";
		echo "<form name='fileSel' action='main.php'>";
		echo "<input type='hidden' name='act' value='modifyfile'>";
?>
		<select name='fileid' class="contentFormSelect" onchange="javascript: document.forms['fileSel'].submit();"> 
<?
		if ($_GET['fileid'])
		{
			$result = mysql_query ("SELECT * FROM files WHERE id = '".$_GET['fileid']."'", $db);
			$current = mysql_fetch_array($result);
			echo " <option value='".$current['id']."'>".$current['title']." - [".$current['id']."]</option>";
		}
		else
		{
			echo " <option value=''>-- �������� ��������� �� ������ --</option>";
		}
		
		$result = mysql_query ("SELECT id, title FROM files WHERE id != '".$_GET['fileid']."' ORDER BY ord, title", $db);
		while ($item = mysql_fetch_array($result))
		{
			echo " <option value='".$item['id']."'>".$item['title']." - [".$item['id']."]</option>";
		}
		echo "</select>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		
		// MANUAL ID INPUT
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "��� ������� � ID";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<form name='fileSelect' action='main.php' method='get'>";
		echo "<input type='hidden' name='act' value='modifyfile'>";
		echo "<input name='fileid' type='text' size='15'>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='modifyfile' type='submit' value='  ������� ��� ���������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		echo "<hr>";		
		if ($_GET['fileid'])
		{
			require_once('dataform.php');
		}
		
		break;
		
		case delfile:
		// ===================================
		// ===== DELETE FILE RECORD FORM =====
		// ===================================
		
		// DROPDOWN LIST
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "�������� ��������� �� ������";
		echo "</td></tr>";
		echo "<tr><td>";
		echo "<form name='delfile' action='main.php' method='post'>";
		echo "
			  <select name='file_id'>";
		$result = mysql_query ("SELECT id, title FROM files ORDER BY ord, title", $db);
		while ($item = mysql_fetch_array($result))
		{
			echo " <option value='".$item['id']."'>".$item['title']." - [".$item['id']."]</option>";
		}
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='delfile' type='submit' value='  �������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		
		// MANUAL ID INPUT
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "��� ������� � ID";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<form name='delfile' action='main.php' method='post'>";
		echo "<input name='file_id' type='text' size='15'>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='delfile' type='submit' value='  �������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		break;
		
		case addcat:
		// ====================================
		// ===== ADD CATEGORY RECORD FORM =====
		// ====================================
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "�������� ������������ ���������";
		echo "</td></tr>";
		echo "<tr><td>";
		echo "<form name='addcat' action='main.php' method='post'>";
		echo "<input name='parent' type='hidden' value='0'>";
		echo "<input name='parent_list' type='hidden' value='0, '>";
		echo "<input name='title' type='text' size='40' maxlength='250'>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='addcat' type='submit' value='  ��������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "�������� ������������";
		echo "</td></tr>";
		echo "<tr><td>";
		echo "<form name='addcat' action='main.php' method='post'>";
		echo "������������: 
			<select name='parent'>";
		$result = mysql_query("SELECT * FROM categories WHERE parent='0'", $db);
		while ($parent = mysql_fetch_array($result))
		{
			echo "<option value='".$parent['id']."'>".$parent['title']."</option>";
		}
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td>";
		echo "<form name='addcat' action='main.php' method='post'>";
		echo "<input name='title' type='text' size='40' maxlength='250'>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='addcat' type='submit' value='  ��������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		break;
		
		case modifycat:
		// =======================================
		// ===== MODIFY CATEGORY RECORD FORM =====
		// =======================================
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "<form name='modifycat' action='main.php' method='post'>";
		echo "
			<select name='cat_id'>";
		$result = mysql_query("SELECT * FROM categories WHERE parent='0'", $db);
		while ($parent = mysql_fetch_array($result))
		{
			echo "<option value='".$parent['id']."'>".$parent['title']."</option>";
			$child_result = mysql_query("SELECT * FROM categories WHERE parent='".$parent['id']."'", $db);
			while ($child = mysql_fetch_array($child_result))
			{
				echo "<option value='".$child['id']."'>".$child['title']."&nbsp;&nbsp;&nbsp;&nbsp;(".$parent['title'].")</option>";
			}
		}
		echo "</select>";
		echo "<tr><td align='center'>";
		echo "����� �������� ���������: <input name='title' type='text' size='45' maxlength='250'>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='modifycat' type='submit' value='  ��������  '>";
		echo "</td></tr>";
		echo "</form>";
		echo "</table>";
		break;
		
		case delcat:
		// ================================
		// ===== DELETE CATEGORY FORM =====
		// ================================
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td>";
		echo "<form name='delcat' action='main.php' method='post'>";
		echo "
			<select name='cat_id'>";
		$result = mysql_query("SELECT * FROM categories WHERE parent='0'", $db);
		while ($parent = mysql_fetch_array($result))
		{
			echo "<option value='".$parent['id']."'>".$parent['title']."</option>";
			$child_result = mysql_query("SELECT * FROM categories WHERE parent='".$parent['id']."'", $db);
			while ($child = mysql_fetch_array($child_result))
			{
				echo "<option value='".$child['id']."'>".$parent['title']."--".$child['title']."</option>";
			}
		}
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='delcat' type='submit' value='  �������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		break;
		
		case comments:
		// ================================
		// ===== MANAGE COMMENTS FORM =====
		// ================================
		if (isset($_POST['file_id']))
		{
			$file_id = $_POST['file_id'];
		}
		if (isset($_GET['file_id']))
		{
			$file_id = $_GET['file_id'];
		}
		
		if ($_GET['rmcomm_id'])
		{
			$result = mysql_query("DELETE FROM comments WHERE id = '".$_GET['rmcomm_id']."'", $db);
			if ($result)
			{
				$operation_result="<div class='ok'>����������� ������� �����</div>";
			}
			else
			{
				$operation_result="<div class='error'>������ ��� �������� �����������</div>";
			}
		}
		
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "�������� ��������� �� ������";
		echo "</td></tr>";
		echo "<tr><td>";
		echo "<form name='list_comments' action='main.php?act=".$_GET['act']."' method='post'>";
		echo "
			  <select name='file_id'>";
		$result = mysql_query ("SELECT id, title FROM files ORDER BY id = '".$file_id."' DESC, ord, title", $db);
		while ($item = mysql_fetch_array($result))
		{
			echo " <option value='".$item['id']."'>".$item['title']." - [".$item['id']."]</option>";
		}
		echo "</select>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='list_comments' type='submit' value='  ���������� �����������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		
		// MANUAL ID INPUT
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr><td align='center'>";
		echo "��� ������� � ID";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<form name='list_comments' action='main.php?act=".$_GET['act']."' method='post'>";
		echo "<input name='file_id' type='text' size='15'>";
		echo "</td></tr>";
		echo "<tr><td align='center'>";
		echo "<input name='list_comments' type='submit' value='  ���������� �����������  '>";
		echo "</form>";
		echo "</td></tr>";
		echo "</table>";
		
		echo "<br>";
		echo "<div align='center'><a href='main.php?act=".$_GET['act']."&mode=listall'>�������� ��� �����������</a></div><br>";
		if ($operation_result)
		{
			echo $operation_result."<br>";
			unset ($operation_result);
		}
		
		if (!$_GET['mode'] == 'listall')
		{
			$query = "WHERE file_id='".$file_id."'";
		}
		
		$result = mysql_query("SELECT * FROM comments ".$query." ORDER BY datetime DESC", $db);
		if (mysql_num_rows($result))
		{
			echo "<table width='100%' cellpadding='3' cellspacing='2' align='center'>";
			echo "<tr valign='center' height='25'>";
			echo "<td bgcolor='#BCC7CF'><div class='comment_header_text'>����������� �������������</div></td>";
			echo "</tr>";
			echo "</table>";			
		}
		echo "<form action='main.php?act=".$_GET['act']."&mode=".$_GET['mode']."' method='post' name='group'>"; 
		echo "<table width='80%' cellpadding='0' cellspacing='0' align='center'>";
		while ($comment = mysql_fetch_array($result))
		{
			echo "<tr height='3'><td></td></tr>";
			echo "<tr><td align='left'><input name='select[".$row."]' type='checkbox' value='".$comment['id']."'>&nbsp;&nbsp;<font class='comment_date'>".date("d/m/Y, H:i", $comment['datetime']).",</font> <font class='comment_added_by'>".$comment['added_by']."</font> <strong>(".$comment['ip_address'].")</strong>, ID ��������� - <a href='../index.php?id=".$comment['file_id']."'><strong>".$comment['file_id']."</strong></a> :<a href='main.php?act=".$_GET['act'];
			$row++;
			if ($_GET['mode'])
			{
				echo "&mode=".$_GET['mode'];
			}
			echo "&file_id=".$file_id."&rmcomm_id=".$comment['id']."'<strong><font class='error'>[�������]</font></strong></td></tr>";
			echo "<tr><td align='left'><div class='comment_text'>".wordwrap($comment['text'], 80, "<br />\n", true)."</div></td></tr>";
			echo "<tr height='3'><td></td></tr>";
		}
		echo "</table>";
		echo "<input name='removegroup' type='submit' value='�������' title='������� ���������� �����������'>";
		echo "</form>";
		break;
	}
  }
	echo "</td>"; 	 // ----
	echo "</tr>"; 	 // ----
	echo "</table>"; // ----

?>

<? include ('footer.php'); ?>
</body>
</html>
