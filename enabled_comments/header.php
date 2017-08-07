<table class='table_base' align="center" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<table class="table_header" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td id='cell1'>
				<!-- BANNER 468 x 60 START -->
				<div id="banner">
                <!--/* OpenX Javascript Tag v2.8.1 */-->

<script type='text/javascript'><!--//<![CDATA[
   var m3_u = (location.protocol=='https:'?'https://adv.stream.uz/www/delivery/ajs.php':'http://adv.stream.uz/www/delivery/ajs.php');
   var m3_r = Math.floor(Math.random()*99999999999);
   if (!document.MAX_used) document.MAX_used = ',';
   document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
   document.write ("?campaignid=1");
   document.write ('&amp;cb=' + m3_r);
   if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
   document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
   document.write ("&amp;loc=" + escape(window.location));
   if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
   if (document.context) document.write ("&context=" + escape(document.context));
   if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
   document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://adv.stream.uz/www/delivery/ck.php?n=ae97e0e4&amp;cb=21 <http://adv.stream.uz/www/delivery/ck.php?n=ae97e0e4&amp;cb=21>' target='_blank'><img src='http://adv.stream.uz/www/delivery/avw.php?campaignid=1&amp;cb=21&amp;n=ae97e0e4 <http://adv.stream.uz/www/delivery/avw.php?campaignid=1&amp;cb=21&amp;n=ae97e0e4>' border='0' alt='' /></a></noscript>

				</div>
				<!-- BANNER 468 x 60 END -->
				</td>
			</tr>
			<tr>
				<td id='cell2'>
				<div style="text-align:right; padding-bottom:14px;">
				<form name="headerform" action="index.php" method="post">
				<?php
				if (!empty($_COOKIE['USERID']) and !empty($_COOKIE['SESSIONID']) and !empty($_COOKIE['USERNAME']))
				{
					echo "<label id='auth_success'>Вы вошли в систему, как ".$_COOKIE['USERNAME']." <a href='index.php?act=logout'>[Выйти]</a></label>";
				}
				else
				{
					?>
					Логин: <input id="auth_field" name="login" type="text" size="12" maxlength="20" />
					Пароль: <input id="auth_field" name="password" type="password" size="12" maxlength="20" />
					<input id="auth_button" name="auth" type="submit" value="Войти" />
					<?php
				}
				?>
				Поиск: <input id="search_field" name="searchstring" type="text" size="20" maxlength="128" />
				<input id="search_button" name="search" type="submit" value="Найти" />
				</form>
				</div>
				<?php
				if (!empty($error))
				{
					echo "<div id='error'>".$error."</div>";
					unset ($error);
				}
				?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		