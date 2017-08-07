<td id='mcell6'>
<?php
	$result = mysql_query("SELECT id, title, category, downloads_today FROM files WHERE today = '".mktime('0', '0', '0')."' AND parent_item = '0' AND downloads_today != '0' ORDER BY downloads_today DESC LIMIT 10", $db);
	if (mysql_num_rows($result))
	{
		?>
		<table class="table_side" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td id="header">
				<label>Сегодня скачали</label>
			</td>
		</tr>
		<tr>
			<td id="item">
			<?php
			while ($item = mysql_fetch_array($result))
			{
				?>
				<div id='list'><a href='index.php?id=<?php echo $item['id']; ?>'><?php echo $item['title']; ?>&nbsp;(<?php echo $item['downloads_today']; ?>)</a></div>
				<?php
			}
			unset ($item);
			?>
			</td>
		</tr>
		</table>
	<?php
	}
	unset ($result);
?>
	<table class="table_side" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id="header">
			<label>Самые популярные</label>
		</td>
	</tr>
	<tr>
		<td id="item">
		<?php
		$result = mysql_query("SELECT id, title, category, downloads_total FROM files WHERE parent_item = '0' ORDER BY downloads_total DESC LIMIT 10", $db);
		while ($item = mysql_fetch_array($result))
		{
			?>
			<div id='list'><a href='index.php?id=<?php echo $item['id']; ?>'><?php echo $item['title']; ?></a></div>
			<?php
		}
		unset ($item, $result);
		?>
		</td>
	</tr>
	</table>
	
	<table class="table_side" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td id="header">
			<label>Мы рекомендуем</label>
		</td>
	</tr>
	<tr>
		<td id="item">
		<?php
			$rec = array ('Chrome Internet Browser' => '51',
						  'Firefox Internet Browser' => '430',
						  'Opera Internet Browser' => '838',
						  'QIP Infium' => '690',
						  'Kaspersky Internet Security' => '229',
						  'NVIDIA Display Driver' => '153',
						  'VisualWget Download Manager' => '772',
						  'K-Lite Mega Codec Pack' => '401',
						  'AMD Catalyst' => '358',
						  'D-Link DSL-200 Driver' => '587',
						  'Realtek Sound Driver' => '585',
						  'KMPlayer' => '296',
						  'Avira AntiVir' => '609');
			ksort($rec);
			while (list($title, $id) = each ($rec))
			{
				?>
				<div id='list'><a href='index.php?id=<?php echo $id; ?>'><?php echo $title; ?></a></div>
				<?php
			}
		?>
		</td>
	</tr>
	</table>
</td>