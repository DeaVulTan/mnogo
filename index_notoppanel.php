<?php require_once ("include.php"); ?>
<?php require_once ("actions.php"); ?>
<?php
	if (isset($_GET['id']))
	{
		$result = mysql_query("SELECT * FROM files WHERE id = '".$_GET['id']."' AND parent_item = '0'", $db);
                if (!mysql_num_rows($result)) {
                    $notFound = true;
                }
		$file = mysql_fetch_array($result);
		$result = mysql_query("SELECT parent FROM categories WHERE id = '".$file['category']."'", $db);
		$file_cat_id = mysql_fetch_array($result);
		$file_cat_id = $file_cat_id['parent'];
                $keywords = 'скачать ' . stripslashes($file['title']);
                $title = ' :: Скачать ' . stripslashes($file['title']);
	}
        else {
            $keywords = 'скачать программы софт software soft application приложение мультимедиа система безопасность антивирус файрвол security antivirus firewall';
            $title = ' :: Скачать программы на все случаи жизни';
        }
        
        if (isset($_GET['ccat'])) {
            $cat_id = $_GET['ccat'];
        } elseif (isset($_GET['cat'])) {
            $cat_id = $_GET['cat'];
        }
        
        if (is_numeric($cat_id)) {
            $result = mysql_query("SELECT title FROM categories WHERE id = '".$cat_id."'", $db);
            $category = mysql_fetch_array($result);
            if (mysql_num_rows($result)) {
                $title = ' :: ' . stripslashes($category['title']);
            }
            unset($category, $result, $cat_id);
        }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="keywords" content="<?php echo $keywords; unset($keywords); ?>" />
<meta name="description" content="Портал программного обеспечения mySoft от Sharq Telekom" /> 
<title>mySoft<?php echo $title; unset($title); ?></title>
<link href="style.css" rel="stylesheet" type="text/css">
<link href="/lytebox/lytebox.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/lytebox/lytebox.js"></script>
</head>
<body>
<?php require_once ("header.php"); ?>
<table class="table_main" align="center" cellpadding="0" cellspacing="0">
<tr>
<td id='mcell1'>&nbsp;</td>
<?php require_once("left.php"); ?>
<td id='mcell3'>&nbsp;</td>
<td id='mcell4'>
<?php
if ($_GET['p'])
{
	require_once("page_".$_GET['p'].".php");
}
else
{
	?>
	<table class="table_content" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td id="header">
			<?php 
				if (!empty($_POST['searchstring']))
				{
					$title = "Результаты поиска";
				}
				if ($_GET['id'])
				{
					$title = "Скачать программу";	
				}
				if (empty($title))
				{
					$title = "Последние добавленные";	
				}
				echo "<label>".$title."</label>";
			?>
			</td>
		</tr>
		<?php
		if (!isset($_GET['id']))
		{	
			// LAST ADDED FILES LIST
			$query = "SELECT * FROM files WHERE parent_item = '0'";

			if (isset($_GET['cat']))
			{
				if (isset($_GET['ccat']))
				{
					$query = $query." AND parent_list LIKE '%(".$_GET['ccat'].")%'";
				}
				else
				{
					$query = $query." AND parent_list LIKE '%(".$_GET['cat'].")%'";
				}
			}
		
			if (!empty($_POST['searchstring']))
			{
				$searchstring = $_POST['searchstring'];
				$searchstring = preg_replace("/'/", "_", $searchstring);
				$searchstring = preg_replace('/"/', '_', $searchstring);
				$query = $query." AND title LIKE '%".$searchstring."%'";
			}
			
			if (!empty($_GET['searchstring']))
			{
				$searchstring = $_GET['searchstring'];
				$searchstring = preg_replace("/'/", "_", $searchstring);
				$searchstring = preg_replace('/"/', '_', $searchstring);
				$query = $query." AND title LIKE '%".$searchstring."%'";
			}

			if (isset($_GET['offset']))
			{
				$offset = $_GET['offset'];
			}
			else
			{
				$offset = 0;
			}

			$query = $query." ORDER BY create_date DESC LIMIT ".$offset.", ".$files_on_page;

			$result = mysql_query($query, $db);
			if (!mysql_num_rows($result))
			{
				?>
				<tr>
					<td id='item'><div id='notfound'>Файлы с таким именем не найдены</div></td>
				</tr>
				<?
			}
			while ($file = mysql_fetch_array($result))
			{
				$create_date = date("d-m-Y", $file['create_date']);
				if ($previous != $create_date)
				{
					$previous = $create_date;
					?>
					<!--<tr>
						<td id='date'><div><label><?php echo $create_date; ?></label></div></td>
					</tr>-->
					<?php
				}
				?>
				<tr>
					<td id='item'>
					<table width='100%' cellpadding='0' cellspacing='0'>
						<tr>
							<td id='cell_filelist_header'><a href='index.php?id=<?php echo $file['id']; ?>'><?php echo $file['title']; ?></a></td>
						</tr>
						<tr>
							<td id='cell_filelist_description'><label><?php echo stripslashes($file['desc_short']); ?></label></td>
						</tr>
					</table>
					</td>
				</tr>
				<?php
			}
			?>
			<tr>
				<td id='item'>
				<div id='pages'>
				<?php
					// PAGES ROW
				
					$query = "SELECT COUNT(*) FROM files";

					if (isset($_GET['cat']))
					{
						if (isset($_GET['ccat']))
						{
							$query = $query." WHERE parent_list LIKE '%(".$_GET['ccat'].")%'";
						}
						else
						{
							$query = $query." WHERE parent_list LIKE '%(".$_GET['cat'].")%'";
						}
					}
		
					if (isset($_POST['searchstring']) != "")
					{
						$query = $query." WHERE title LIKE '%".$searchstring."%'";
					}
					
					if (isset($_GET['searchstring']) != "")
					{
						$query = $query." WHERE title LIKE '%".$searchstring."%'";
					}
					
					$result = mysql_query ($query, $db);
					$total_files = mysql_fetch_array($result);
					$total_files = $total_files[0];
					$total_pages = ($total_files / $files_on_page);

					// 'BACK' BUTTON
	
					if (isset($_GET['n']) and $_GET['n'] != 0)
					{
						echo "<a href='index.php?"
						."n=".($_GET['n']-1)
						."&offset=".((($_GET['n']."0")-1) * $files_on_page)
						."'><<<</a>";
					}
					$num = $_GET['n']."0";
				
					// 1...10 BUTTONS
		
					for ($num = $_GET['n']."0"; $num <= ($_GET['n']."0"+9) and $num <= $total_pages and $total_pages > 1; $num++)
					{
						echo "<a href='index.php?";
						if (isset($_GET['n']))
						{
							echo "n=".$_GET['n'];
						}
						if (isset($_GET['cat']))
						{
							echo "&cat=".$_GET['cat'];
						}
						if (isset($_GET['ccat']))
						{
							echo "&ccat=".$_GET['ccat'];
						}
						if (isset($searchstring))
						{
							echo "searchstring=".$searchstring;
						}	
						echo "&offset=".($num * $files_on_page)."'";
						if ($offset == ($num * $files_on_page))
						{
							echo " id='current'";
						}
						echo ">".($num+1)."</a>";
					}
					// 'NEXT' BUTTON		
	
					if ($num > 1 and $num < $total_pages)
					{
						echo "<a href='index.php?"
						."n=".($_GET['n']+1)
						."&offset=".($num * $files_on_page)
						."'>>>></a>";
					}
				?>
				</div>
				</td>
 			</tr>
			<?php
		}
		else
		{			
			?>
			<tr>
				<td id='item'>
				<div id='fileinfo_header'><a href='index.php?id=<?php echo $_GET['id']; ?>'><?php echo $file['title']; ?></a></div>
				<?php
					if ($file['image'])
					{
						switch (returnMIMEType($file['image']))
						{
							case "image/jpg":
							$im = imagecreatefromjpeg($file['image']);
							break;
							
							case "image/png":
							$im = imagecreatefrompng($file['image']);
							break;
							
							case "image/gif":
							$im = imagecreatefromgif($file['image']);
							break;
						}
						?>
                                                <a href="<?php echo $file['image']; ?>" rel="lytebox"><img align='left' vspace='3' hspace='10' src='<?php echo $file['image']."_thumb.jpg"; ?>'></a> 
						<?php
						imagedestroy($im);
					}
				?>
				<div id='fileinfo_description'>
                                    <?php
                                        $Content = explode("\n", $file['desc_long']);
                                        foreach($Content as $ContentPart) {
                                            $ContentPart = trim($ContentPart);
                                            $ContentPart = stripslashes($ContentPart);
                                            $ContentPart = ProcessBBCodes($ContentPart);
                                            echo stripslashes($ContentPart);
                                            unset($NoParagraph, $ContentPart);
                                        }
                                        unset($ContentPart, $Content);
                                    ?>
                                </div>
				<hr color="#CCCCDD" height="1px" />
				<ul>
				<?php
                                if ($notFound) {
                                    echo "<br /><br /><br /><div style=\"text-align: center\">Программа не найдена</div><br /><br />";
                                } else {
                                     FileInfo($file, $license, 0);
                                }
                                ?>
				</ul>
				<?php
                                if (!$notFound) {
					$result = mysql_query("SELECT * FROM files WHERE parent_item='".$file['id']."' ORDER BY create_date", $db);
					if (mysql_num_rows($result))
					{
						?>
						<ul>
						<?php
							while ($file = mysql_fetch_array($result))
							{
								Fileinfo($file, $license, 1);
							}
						?>
						</ul>
						<?php
					}
                                }
				?>
				</td>
			</tr>
			<?php
		}
		?>
        <tr>
        	<td>
    	         <!-- BANNER 468 x 60 START -->
		    	<div align="center" style="margin-top:10px;">
<!--/* OpenX Javascript Tag v2.8.7 */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://adv.stream.uz/www/delivery/ajs.php':'http://adv.stream.uz/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?campaignid=24");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://adv.stream.uz/www/delivery/ck.php?n=ab6fd21e&amp;cb=38572' target='_blank'><img src='http://adv.stream.uz/www/delivery/avw.php?campaignid=24&amp;cb=38572&amp;n=ab6fd21e' border='0' alt='' /></a></noscript>
                        </div>
		        <!-- BANNER 468 x 60 END -->
            </td>
        </tr>
	</table>
	<?php
}
?>
</td>
<td id='mcell5'>&nbsp;</td>
<?php require_once("right.php"); ?>
<td id='mcell7'>&nbsp;</td>
</tr>
</table>

<?php require_once ("footer.php"); ?>
</body>
</html>
