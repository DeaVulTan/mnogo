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
                                "Arch Linux",
				"Debian GNU/Linux",
                                "GNU/Linux Ubuntu",
			);

			$img_list = array (
                                "img/dist_arch.jpg",
				"img/dist_debian.jpg",
                                "img/dist_ubuntu.jpg",
			);

			$link_list = array (
                                "http://mirrors.st.uz/archlinux/",
				"http://debian.uz/",
                                "http://ubuntu.uz/",
			);
			$num = 0;
			while ($distrib_list[$num])
			{
				?>
					<a href='<?php echo $link_list[$num]; ?>' title='Зеркало <?php echo $distrib_list[$num]; ?>' target="_blank"><img src='<?php echo $img_list[$num]; ?>' hspace="5" vspace="3"></a>
				<?php
				$num++;
			}
			unset ($num);
		?>
        <div align="center">
        <a href='http://ubuntu.uz/ubuntu-releases/raring/' title='Ubuntu 13.04 уже здесь!' target="_blank"><img src='/img/ubuntu1304.png' vspace="3"></a>
        </div>
        </td>
        </tr>
        <tr>
            <td id="header">
                    <label>Реклама</label>
            </td>
	</tr>
            <td id="item">
                <div align="center">
					<a href="http://mysoft.uz/index.php?id=1280" target="_blank"><img src="/img/mg.jpg" alt="Бизнес-карта справочник 'Мой город. Ташкент'" title="Бизнес-карта справочник 'Мой город. Ташкент'" /></a>
					<br />
					<?php
					$result = mysql_query("SELECT `downloads_total` FROM `files` WHERE `id` = 1280", $db);
					$mgDCount = mysql_result($result, 0, 'downloads_total');
					echo "<strong>Скачали: " . $mgDCount . "</strong>";
					unset ($result, $mgDCount);
					?>
					<br /><br />
                    <a href="http://bem.uz" target="_blank"><img src="/img/bem.jpg" alt="БЭМ - Информационно-правовая база Узбекистана" title="Информационно-правовая база Узбекистана" /></a>                    
                </div>
                
		<br /><br /><br />
		<p align="center"><img src="http://mysoft.uz/mycounter/mycounter.php"></p><br /><br />
<div align="center"><select onchange="top.location.href=this.options[this.selectedIndex].value">
		<option value="#" selected="selected">- Ресурсы портала -</option>
		<option value="http://www.st.uz">Sharq Telekom</option>
                       <option value="http://www.stream.uz">SharqSTREAM</option>
		       <option value="http://portal.stream.uz">Портал</option>
                       <option value="http://mail.stream.uz/">Почта</option>
                       <option value="http://forum.stream.uz">Форум</option>
                       <option value="http://video.stream.uz">Видео</option>
                       <option value="http://music.stream.uz">Музыка</option>
                       <option value="http://games.stream.uz">Игры</option>
                       <option value="http://book.stream.uz">Книги</option>
                       <option value="http://soft.stream.uz">Софт</option>
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