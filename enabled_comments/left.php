<td id='mcell2'>
	<table class="table_side" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id="header">
			<label>Навигация</label>			
		</td>
	</tr>
	<tr>
		<td id="item">
		<?php
			$menu = array ('Главная' => 'index.php',
						  'Регистрация' => 'index.php?p=register',
						  'Подписка на RSS' => 'rss.php',
						  'О сервисе' => 'index.php?p=about',
						  'Выйти из системы' => 'index.php?act=logout');
			while (list($title, $link) = each ($menu))
			{
				if (!empty($_COOKIE['USERID']) and !empty($_COOKIE['SESSIONID']) and !empty($_COOKIE['USERNAME']) and $title == 'Регистрация')	{}
				elseif (empty($_COOKIE['USERID']) and empty($_COOKIE['SESSIONID']) and empty($_COOKIE['USERNAME']) and $title == 'Выйти из системы')	{}
				else
				{
				?>
				<div id='parent_category'><a href='<?php echo $link; ?>'><?php echo $title; ?></a></div>
				<?php
				}
			}
		?>
		</td>
	</tr>
	<tr>
		<td id="header">
			<label>Категории</label>
		</td>
	</tr>
	<tr>
		<td id="item">
		<?php
			$result = mysql_query("SELECT id, title FROM categories WHERE parent = '0'", $db);
			while ($parent_category = mysql_fetch_array($result))
			{
			?>
				<div id='parent_category'>
				<a href='index.php?cat=<?php echo $parent_category['id']; ?>'
				<?php
					if ($parent_category['id'] == $file_cat_id or $parent_category['id'] == $_GET['cat'])
					{
						echo " id='current'";
						$title = $parent_category['title'];
					}
				?>
				><?php echo $parent_category['title']; ?>
				</a>
				</div>
				<?php
				if ($_GET['cat'] == $parent_category['id'])
				{
					$cat = $_GET['cat'];
					$child_result = mysql_query("SELECT id, title FROM categories WHERE parent = '".$cat."'", $db);
					while ($child_category = mysql_fetch_array($child_result))
					{
						?>
						<div id='child_category'>
						<a href='index.php?cat=<?php echo $_GET['cat']; ?>&ccat=<?php echo $child_category['id']; ?>'
						<?php
							if ($_GET['ccat'] == $child_category['id'])
							{
								echo " id='current'";
								$title = $parent_category['title'] . " > " .$child_category['title'];
							}
						?>
						><?php echo $child_category['title']; ?>
						</a>
						</div>
						<?php
					}
					mysql_free_result($child_result);
				}
				
				if (isset($_GET['id']) and $parent_category['id'] == $file_cat_id)
				{	
					$child_result = mysql_query("SELECT id, title FROM categories WHERE parent = '".$file_cat_id."'", $db);
					while ($child_category = mysql_fetch_array($child_result))
					{		
						$num = 0;
						$letter = 0;

						$plist = preg_split("//", $file['parent_list'], -1, PREG_SPLIT_NO_EMPTY);
						while ($plist[$letter] != "")
						{
							switch ($plist[$letter])
							{
								case "(":
								$part = "";
								break;
				
								case ")":
								$file_child_cat[$num] = $part;
								unset ($part);
								$num++;
								break;
				
								default:
								$part = $part.$plist[$letter];
								break;
							}
							$letter++;
						}
						unset ($letter);
						$num = 0;
						echo "<div id='child_category'><a href='index.php?cat=".$file_cat_id."&ccat=".$child_category['id']."'";
						while ($file_child_cat[$num] != "")
						{
							if ($child_category['id'] == $file_child_cat[$num])
							{
								 echo "id='current'";
							}
							$num++;
						}
						echo ">".$child_category['title']."</a></div>";
					}
				}
			}
			mysql_free_result($result);
		?>
		</td>
	</tr>
	</table>
    <table class="table_side" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id="header">
			<label>Антивирусные базы</label>
		</td>
	</tr>
	<tr>
		<td id="item">
        <div align="center">
        	<a href='http://soft.stream.uz/Antivirus/' title='Обновления антивирусных баз' target="_blank"><img src='img/antivir.jpg' vspace="3"></a>
        </div>
        </td>
	</tr>
	</table>
	<table class="table_side" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id="header">
			<label>Зеркала дистрибутивов</label>
		</td>
	</tr>
	<tr>
		<td id="item"><div align="center">
		<?php
			$distrib_list = array (
				"GNU/Linux Ubuntu", 
				"Debian GNU/Linux"
			);

			$img_list = array (
				"img/dist_ubuntu.jpg",
				"img/dist_debian.jpg"
			);

			$link_list = array (
				"http://ubuntu.uz/",
				"http://debian.uz/"
			);
			$num = 0;
			while ($distrib_list[$num])
			{
				?>
					<a href='<?php echo $link_list[$num]; ?>' title='Зеркало <?php echo $distrib_list[$num]; ?>' target="_blank"><img src='<?php echo $img_list[$num]; ?>' hspace="7" vspace="3"></a>
				<?php
				$num++;
			}
			unset ($num);
		?>
        <div align="center">
        	<a href='http://ubuntu.uz/ubuntu-releases/karmic/' title='Ubuntu 9.10 уже здесь!' target="_blank"><img src='img/ubuntu910.jpg' vspace="3"></a>
        </div>
		<br /><br /><br />
		<p align="center"><img src="http://soft.stream.uz/new_counter/counter.php"></p><br /><br />
<div align="center"><select onchange="top.location.href=this.options[this.selectedIndex].value">
		<option value="#" selected="selected">- Ресурсы портала -</option>
		<option value="http://www.st.uz">Sharq Telekom</option>
                       <option value="http://www.stream.uz">SharqSTREAM</option>
		       <option value="http://portal.stream.uz">Портал</option>
                       <option value="http://mail.stream.uz/">Почта</option>
                       <option value="http://forum.stream.uz">Форум</option>
                       <option value="http://video.stream.uz">Видео</option>
                       <option value="http://games.stream.uz">Игры</option>
                       <option value="http://book.stream.uz">Книги</option>
                       <option value="http://soft.stream.uz">Софт</option>
                       <option value="http://cards.stream.uz">Открытки</option>
                       <option value="http://share.stream.uz">Обмен файлами</option>		       
                       <option value="http://radio.stream.uz">Радио</option>
                       <option value="http://chatland.uz">Чат</option>
	</select>
		<br /><br />
		</div>
		<br />
		<br />
		</td>
	</tr>
	</table>
</td>