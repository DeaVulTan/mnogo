	<?
		echo "<table cellpadding='3' cellspacing='3' border='0' align='center'>";
		echo "<tr>";
		echo "<td valign='top' align='right'>���������� � ���������:</td>";
		echo "<td valign='top' align='left'>";
?>
		<form name='modeSel' action='main.php'>
        <input type='hidden' name='act' value='<? echo $_GET['act']; ?>'>
<?
		echo "<input type='hidden' name='fileid' value='".$_GET['fileid']."'>"
?>
		<input type='checkbox' name='addition' value=<? if ($_GET['addition']) { echo "'0' checked"; } else { echo "'1'"; } ?> onchange="javascript: document.forms['modeSel'].submit();" >
        </form>
<?
		echo "</td>";
		echo "</tr>";
	  if ($_GET['addition'])
	  {
		echo "<tr>";
		echo "<td valign='top' align='right'>������������:</td>";
		echo "<td valign='top' align='left'>";
?>
		<form name='isrussSel' action='main.php'>
        <input type='hidden' name='act' value='<? echo $_GET['act']; ?>'>
        <input type='hidden' name='addition' value='<? echo $_GET['addition']; ?>'>
<?
		echo "<input type='hidden' name='fileid' value='".$_GET['fileid']."'>"
?>
		<input type='checkbox' name='isruss' value=<? if ($_GET['isruss']) { echo "'0' checked"; } else { echo "'1'"; } ?> onchange="javascript: document.forms['isrussSel'].submit();" >
        </form>
<?
		echo "</td>";
		echo "</tr>";
	  }	
		echo "<tr><td><hr></td><td><hr></td></tr>";
		if ($_GET['act'] == 'addfile')
		{
			echo "<form name='addfile' action='main.php' method='post' enctype='multipart/form-data'>";
		}
		if ($_GET['act'] == 'modifyfile')
		{
			echo "<form name='modifyfile' action='main.php' method='post' enctype='multipart/form-data'>";	
			echo "<input name='file_id' type='hidden' value='".$current['id']."'>";
		}
		echo "<tr>";
		echo "<td align='right'>��������:</td>";
		echo "<td><input name='title' maxlength='250' size='75' value='".$current['title']."'></td>";
		echo "</tr>";
	  if (!$_GET['addition'])
	  {
		echo "<tr>";
		echo "<td align='right'>�������� � ������:</td>";
		echo "<td><input name='title_download' maxlength='250' size='75' value='".$current['title_download']."'></td>";
		echo "</tr>";
	  }
		if ($_GET['act'] == 'modifyfile')
		{
			echo "<tr>";
			echo "<td align='right'>�������� ��������:</td>";
			echo "<td><input name='counter_reset' type='checkbox' size='75' value='1' /></td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td align='right'>��������� <strong>(�-�-�,�:�:�)</strong>:</td>";
			echo "<td>";
			  echo "<input name='d' size='2' mazlength='2' value='".date("d", $current['create_date'])."'> - ";
			  echo "<input name='m' size='2' mazlength='2' value='".date("m", $current['create_date'])."'> - ";
			  echo "<input name='Y' size='4' mazlength='4' value='".date("Y", $current['create_date'])."'> , &nbsp;&nbsp;&nbsp;";
			  echo "<input name='H' size='2' mazlength='2' value='".date("H", $current['create_date'])."'> : ";
			  echo "<input name='i' size='2' mazlength='2' value='".date("i", $current['create_date'])."'> : ";
			  echo "<input name='s' size='2' mazlength='2' value='".date("s", $current['create_date'])."'>";
			echo "</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td></td>";
			echo "<td>";
			echo "<input name='date_mode' type='radio' value='keep_original' checked>���������/���������� ������������� ���� ����������</input><br>";
			echo "<input name='date_mode' type='radio' value='put_current'>���������� ������� ���� � ����� ������ ������������</input>";
			echo "</td>";
			echo "</tr>";
		}
	  if (!$_GET['addition'])
	  {
		echo "<input name='parent_item' type='hidden' value='0'>";
	  }
	  else
	  {
	  	echo "<tr>";
		echo "<td align='right'>������������ � <strong>(ID)</strong>:</td>";
		echo "<td>";
		echo "<input name='parent_item' type='text' maxlength='10' size='75' value='".$current['parent_item']."'>";
		echo "</td>";
		echo "</tr>";
	  }
	  if (!$_GET['isruss'])
	  {
		echo "<tr>";
		echo "<td align='right'>���������:</td>";
		echo "<td>";
		echo "
			<select name='os'>";
		if ($current['os'])
		{
			echo "<option>".$current['os']."</option>";
		}	
		echo "
				<option>not available</option>
				<option>*NIX</option>
                                <option>98/2K/XP/Vista</option>
				<option>98/2K/XP</option>
                                <option>XP/2K3/Vista</option>
				<option>XP/Vista</option>
				<option>XP/Vista/7</option>
				<option>XP/Vista/7 32-bit</option>
				<option>XP/Vista/7 64-bit</option>
				<option>XP</option>
				<option>XP 32-bit</option>
				<option>XP 64-bit</option>
				<option>Vista/7</option>
				<option>Vista/7 32-bit</option>
				<option>Vista/7 64-bit</option>
				<option>Vista/7/8</option>
				<option>Vista/7/8 32-bit</option>
				<option>Vista/7/8 64-bit</option>
				<option>XP/Vista/7/8</option>
                                <option>XP/Vista/7/8 32-bit</option>
                                <option>XP/Vista/7/8 64-bit</option>
			</select>";
			
		echo "&nbsp;&nbsp;&nbsp;&nbsp;��� ��������:";	
		echo "&nbsp;&nbsp;
			<select name='license'>";
		if ($current['license'])
		{
			echo "<option value='".$current['license']."'>".$license[$current['license']]."</option>";
		}
		echo "	
				<option value='0'>-- �� ��������� --</option>
				<option value='1'>Shareware</option>
				<option value='2'>Free</option>
				<option value='3'>Demo</option>
				<option value='4'>Adware</option>
				<option value='5'>Trial</option>
			</select>";
		echo "</td>";
		echo "</tr>";
	  }
	  if (!$_GET['addition'])
	  {		
		echo "<tr>";
		echo "<td align='right'>���������:</td>";
		echo "<td>";
		echo "
			<select name='parent_list'>";
		if ($current['parent_list'])
		{
			$result = mysql_query("SELECT * FROM categories WHERE id = '".$current['category']."'", $db);
			$child = mysql_fetch_array($result);
			$result = mysql_query("SELECT * FROM categories WHERE id = '".$child['parent']."'", $db);
			$parent = mysql_fetch_array($result);
			echo "<option value='(0)(".$parent['id'].")";
			if ($current['category'] != $parent['id'])
			{
				echo "(".$current['category'].")";
			}
			echo "'>".$parent['title'];
			if ($current['category'] != $parent['id'])
			{
				echo "--".$child['title'];
			}
			echo "</option>";
		}
		$result = mysql_query("SELECT * FROM categories WHERE parent='0'", $db);
		while ($parent = mysql_fetch_array($result))
		{
			echo "<option value='(0)(".$parent['id'].")'>".$parent['title']."</option>";
			$child_result = mysql_query("SELECT * FROM categories WHERE parent='".$parent['id']."'", $db);
			while ($child = mysql_fetch_array($child_result))
			{
				echo "<option value='(0)(".$parent['id'].")(".$child['id'].")'>".$parent['title']."--".$child['title']."</option>";
			}
		}
		echo "</select>";
		echo "</td>";
		echo "</tr>";
	  }
		echo "<tr valign='top'>";
		echo "<td align='right'>���������� ������:</td>";
		echo "<td>";
		echo "<textarea name='links_inner' cols='58' rows='5'>";
		if ($current['links_inner'])
		{
			echo $current['links_inner'];
		}
		else
		{
			echo "http://content3.mystream.uz/Software";
		}
		echo "</textarea>";
		echo "</td>";
		echo "</tr>";

                //
                // !! ������ ���� ����� ����� ������� ������
                // 
                echo "<input name='links_outer' type='hidden' value='";
                if ($current['links_outer'])
		{
			echo $current['links_outer'];
		}
		else
		{
			echo "http://";
		}
                echo "' />";

                /*
                //
                // !! ������� ���� ����� ����� ������� ������
                // 
		echo "<tr valign='top'>";
		echo "<td align='right'>������� ������:</td>";
		echo "<td>";
		echo "<textarea name='links_outer' cols='58' rows='5'>";
		if ($current['links_outer'])
		{
			echo $current['links_outer'];
		}
		else
		{
			echo "http://";
		}
		echo "</textarea>";
		echo "</td>";
		echo "</tr>";
                 */
	  if (!$_GET['addition'])
	  {
		echo "<tr>";
		echo "<td align='right'>�����������/��������:</td>";
		echo "<td>";
		if ($current['image'])
		{
			echo "������� ����: <strong>".$current['image']."</strong> ��������� ����� ��������: ";
			echo "<input name='image_current' type='hidden' value='".$current['image']."'>";
		}
		else
		{
			echo "� ������ ���������� �� ������� �� ���� ��������. ���������: ";
		}
		echo "<input name='image' type='file'></td>";
		echo "</tr>";
		echo "<tr valign='top'>";
		echo "<td align='right'>�������� (��������):</td>";
		echo "<td>";
                echo '<script type="text/javascript">edToolbar("desc_short"); </script>';
		echo "<textarea id='desc_short' name='desc_short' cols='58' rows='5'>";
		if ($current['desc_short'])
		{
			echo stripslashes($current['desc_short']);
		}
		echo "</textarea>";
		echo "</td>";
		echo "</tr>";
		echo "<tr valign='top'>";
		echo "<td align='right'>�������� (������):</td>";
		echo "<td>";
                echo '<script type="text/javascript">edToolbar("desc_long"); </script>';
		echo "<textarea id='desc_long' name='desc_long' cols='58' rows='14'>";
		if ($current['desc_long'])
		{
			echo stripslashes($current['desc_long']);
		}
		echo "</textarea>";
		echo "</td>";
		echo "</tr>";
	  }
		echo "<tr><td></td>";
		echo "<td align='center'>";
		if ($_GET['act'] == 'addfile')
		{
			echo "<input name='addfile' type='submit' value='  ��������  '>";
		}
		if ($_GET['act'] == 'modifyfile' and $_GET['fileid'])
		{
			echo "<input name='modifyfile' type='submit' value='  ��������  '>";
		}
		echo "</td>";
		echo "</table>";
		echo "</form>";
		
		echo "<br><br>";
?>
