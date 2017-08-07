<?php require_once ("include.php"); ?>
<?php require_once ("actions.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META NAME="Author" CONTENT="NessawolF [NF], nfstrider@gmail.com">
<title>Prosoft.Uz</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php require_once ("header.php"); ?>
<?php
	if (isset($_GET['id']))
	{
		$result = mysql_query("SELECT * FROM files WHERE id = '".$_GET['id']."'", $db);
		$file = mysql_fetch_array($result);
		$result = mysql_query("SELECT parent FROM categories WHERE id = '".$file['category']."'", $db);
		$file_cat_id = mysql_fetch_array($result);
		$file_cat_id = $file_cat_id['parent'];
	}
?>
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
					<tr>
						<td id='date'><div><label><?php echo $create_date; ?></label></div></td>
					</tr>
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
							<td id='cell_filelist_description'><label><?php echo $file['desc_short']; ?></label></td>
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
							<!-- <a href='<?php // echo $file['image']; ?>' target='blank'><img align='left' vspace='3' hspace='10' src='<?php // echo $file['image']."_thumb.jpg"; ?>'></a> -->
                            <a href="javascript:window.open('<?php echo $file['image']; ?>', '<?php echo $file['title']; ?>', 'toolbar=0,location=0,menubar=0,width=<?php echo imagesx($im); ?>,height=<?php echo imagesy($im); ?>,left=200,top=300,resizable=0'); void(0)"><img align='left' vspace='3' hspace='10' src='<?php echo $file['image']."_thumb.jpg"; ?>'></a> 
						<?php
						imagedestroy($im);
					}
				?>
				<div id='fileinfo_description'><?php echo $file['desc_long']; ?></div>
				<hr color="#CCCCDD" height="1px" />
				<ul>
				<?php FileInfo($file, $license, 0); ?>
				</ul>
				<?php
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
				?>
				</td>
			</tr>
			<tr>
				<td class="cell_comments">
				<?php
					// COMMENTS
					$result = mysql_query("SELECT * FROM comments WHERE file_id='".$_GET['id']."' ORDER BY datetime DESC", $db);
					if (mysql_num_rows($result))
					{
						?>
						<hr color="#CCCCDD" height="1px" />
						<div><label id='comment_header_text'>Комментарии пользователей</label></div>
						<?
					}
					if ($operation_result)
					{
						echo $operation_result;
						unset ($operation_result);
					}
					while ($comment = mysql_fetch_array($result))
					{
						?>
						<div><label id="comment_date"><?php echo date("d/m/Y, H:i", $comment['datetime']); ?></label>, <label id="comment_author"><?php echo $comment['added_by']; ?> :</label></div>
						<div><label id="comment_text"><?php echo wordwrap($comment['text'], 65, "<br />\n", true); ?></label></div>
						<?php
					}
					unset($result);
					?>
					<br /><br />
					<?php
					if (!empty($_COOKIE['USERID']) and !empty($_COOKIE['SESSIONID']) and !empty($_COOKIE['USERNAME']))
					{
						?>
					<form name="addcomment" method="post" action="index.php?id=<?php echo $_GET['id']; ?>">
						<input name="file_id" type="hidden" value="<?php echo $_GET['id']; ?>">
						<input name='ip_address' type='hidden' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<div><label id='comment_header_text'>Оставить комментарий :</label></div>
						<table class="table_add_comment" cellpadding='3' cellspacing='2' align='left'>
							<tr>
								<td colspan='3' align='center'>
									<script language="javascript">
										function isNotMax(e){
									       e = e || window.event;
									       var target = e.target || e.srcElement;
									       var code=e.keyCode?e.keyCode:(e.which?e.which:e.charCode)
									       switch (code){
									               case 13:
									               case 8:
									               case 9:
									               case 46:
					            				   case 37:
									               case 38:
									               case 39:
					            				   case 40:
									           return true;
									       }
										return target.value.length <= target.getAttribute('maxlength');
										}
									</script>
									<textarea name='text' maxlength='299' rows='9' cols='48' onfocus="if(this.value=='Текст Вашего комментария'){this.value='';}" onblur="if(this.value==''){this.value='Текст Вашего комментария';}" onkeypress="return isNotMax(event)"><?php
														if ($_POST['text'])
														{
															echo $_POST['text'];
														}
														else
														{
															echo "Текст Вашего комментария";
														}
													?></textarea>
								</td>
							</tr>
							<tr>
								<td align='center'><label>Защитный код:</label></td>
								<td align='center'>
									<img src='imagecode.php' hspace='4' align='absmiddle'>&nbsp;<input name='code' type='text' size='5' maxlength='5'>
								</td>
								<td align='right'><input name='addcomment' type='submit' value='Добавить'></td>
							</tr>
						</table>
					</form>
					<?php
					}
					else
					{
						echo "<div id='comment_header_text'>Авторизуйтесь в системе, чтобы иметь возможность оставлять комментарии</div><br />";
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
    	    	<!--/* OpenX Javascript Tag v2.8.1 */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://adv.stream.uz/www/delivery/ajs.php':'http://adv.stream.uz/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?campaignid=3");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://adv.stream.uz/www/delivery/ck.php?n=a20c30e2&amp;cb=7' target='_blank'><img src='http://adv.stream.uz/www/delivery/avw.php?campaignid=3&amp;cb=7&amp;n=a20c30e2' border='0' alt='' /></a></noscript>
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
