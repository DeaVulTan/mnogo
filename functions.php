<?
	function Get_Links ($fileid, $var, $is_russ)
	{
		$links = explode ("http://", $var);
		if ($links[2])
		{
			$num = 1;
			while ($links[$num])
			{
				echo "<td width='60' align='center'><div class='download_button'>";
				echo " <a href='download.php?"."id=".$fileid."&part=".($num - 1);
				if ($is_russ)
				{
					echo "&russ=1";
				}
				echo "' id='part'>";
				echo " 
					<br>
					Часть ".$num."
					</a>
					</div>
					</td>";
				$num++;
			}
		}
		else
		{
			echo "<td align='center'><div class='download_button'>";
			echo " <a href='download.php?id=".$fileid."&part=0";
			if ($is_russ)
			{
				echo "&russ=1";
			}
			echo "'>";
			echo " <br>
				Скачать
				</a>
				</div>
				</td>";
		}
	}
	
	function FileInfo($file, $license, $is_addition)
	{
		$var = $file['links'];
		$links = explode ("http://", $var);
		if ($links[2])
		{
			$num = 1;
			while ($links[$num])
			{
				echo "<label id='fileinfo_data'><a href='download.php?"."id=".$file['id']."&part=".($num - 1);
				echo "' id='part'>";
				echo "<strong>Часть ".$num."</strong></a>&nbsp;|&nbsp;";
				$num++;
			}
		}
		else
		{
			echo "<label id='fileinfo_data'><a href='download.php?id=".$file['id']."&part=0'><strong>";
			switch ($is_addition)
			{
				case 0:
				if ($file['title_download'])
				{
					echo $file['title_download'];
				}
				else
				{
					// echo $file['title'];
					echo "Скачать";
				}
				break;
				
				case 1:
				if ($file['title_download'])
				{
					echo $file['title_download'];
				}
				else
				{
					echo $file['title'];
				}
				break;
			
				default:
				break;
			}
			echo "</strong></a>";
		}
		echo "<br />Размер: <strong>".returnfileSize($file['size'])."</strong>";
		echo "<br />Поддерживаемые ОС: <strong>".$file['os']."</strong>";
		if (!$is_addition)
		{
			$type = $file['license'];
			echo "<br />Тип лицензии: <strong>".$license[$type]."</strong>";
		}
		echo "<br />Скачали (сегодня / всего): <strong>".$file['downloads_today']." / ".$file['downloads_total']."</strong>";
		if (!$is_addition)
		{
			echo "<br />Обновлено: <strong>".date('d-m-Y', $file['create_date'])."</strong></label>";
		}
		else
		{
			echo "<br /><br /></label>";	
		}
	}
	
	function returnMIMEType($filename)
	{
        preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);

        switch(strtolower($fileSuffix[1]))
        {
            case "js" :
                return "application/x-javascript";

            case "json" :
                return "application/json";

            case "jpg" :
            case "jpeg" :
            case "jpe" :
                return "image/jpg";

            case "png" :
            case "gif" :
            case "bmp" :
            case "tiff" :
                return "image/".strtolower($fileSuffix[1]);

            case "css" :
                return "text/css";

            case "xml" :
                return "application/xml";

            case "doc" :
            case "docx" :
                return "application/msword";

            case "xls" :
            case "xlt" :
            case "xlm" :
            case "xld" :
            case "xla" :
            case "xlc" :
            case "xlw" :
            case "xll" :
                return "application/vnd.ms-excel";

            case "ppt" :
            case "pps" :
                return "application/vnd.ms-powerpoint";

            case "rtf" :
                return "application/rtf";

            case "pdf" :
                return "application/pdf";

            case "html" :
            case "htm" :
            case "php" :
                return "text/html";

            case "txt" :
                return "text/plain";

            case "mpeg" :
            case "mpg" :
            case "mpe" :
                return "video/mpeg";

            case "mp3" :
                return "audio/mpeg3";

            case "wav" :
                return "audio/wav";

            case "aiff" :
            case "aif" :
                return "audio/aiff";

            case "avi" :
                return "video/msvideo";

            case "wmv" :
                return "video/x-ms-wmv";

            case "mov" :
                return "video/quicktime";

            case "zip" :
                return "application/zip";
				
			case "rar" :
                return "application/x-rar";

            case "tar" :
                return "application/x-tar";

            case "swf" :
                return "application/x-shockwave-flash";

            default :
            if(function_exists("mime_content_type"))
            {
                $fileSuffix = mime_content_type($filename);
            }
			echo $fileSuffix[1];
            return "unknown/" . trim($fileSuffix[0], ".");
        }
    }
	
    function returnfileSuffix($filename)
    {
        preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);
        return strtolower($fileSuffix[1]);
    }
    
	function returnfileSize($filesize)
	{
		switch ($filesize)
		{
			case $filesize > 1 and $filesize <= 1000:
			$size  = round (($filesize / 1.048576), 2);
			$units = "Байт";
			break;
			
			case $filesize > 1000 and $filesize <= 1000000:
			$size  = round (($filesize / 1048.576), 2);
			$units = "Кб";
			break;
			
			case $filesize > 1000000 and $filesize <= 1000000000:
			$size  = round (($filesize / 1048576), 2);
			$units = "Мб";
			break;

			case $filesize > 1000000000:
			$size  = round (($filesize / 1048576000), 2);
			$units = "Гб";
			break;
		}
		return $size." ".$units;
	}
        
function ProcessBBCodes($String, $AllowParagraph = true) {
    $StringChanged == false;
    if(preg_match("/\[b\]/", $String)) {
        $String = preg_replace("/\[b\]/", "<strong>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/b\]/", $String)) {
        $String = preg_replace("/\[\/b\]/", "</strong>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[i\]/", $String)) {
        $String = preg_replace("/\[i\]/", "<em>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/i\]/", $String)) {
        $String = preg_replace("/\[\/i\]/", "</em>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[u\]/", $String)) {
        $String = preg_replace("/\[u\]/", "<u>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/u\]/", $String)) {
        $String = preg_replace("/\[\/u\]/", "</u>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[s\]/", $String)) {
        $String = preg_replace("/\[s\]/", "<s>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/s\]/", $String)) {
        $String = preg_replace("/\[\/s\]/", "</s>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[img\]/", $String)) {
        $String = preg_replace("/\[img\]/", "<img src=\"", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/img\]/", $String)) {
        $String = preg_replace("/\[\/img\]/", "\" />", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[list\-basic\]/", $String)) {
        $String = preg_replace("/\[list\-basic\]/", "<ul class=\"list-basic\">", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[list\-nomarker\]/", $String)) {
        $String = preg_replace("/\[list\-nomarker\]/", "<ul class=\"list-nomarker\">", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/list\]/", $String)) {
        $String = preg_replace("/\[\/list\]/", "</ul>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\*\]/", $String)) {
        $String = preg_replace("/\[\*\]/", "", $String);
        $String = "<li>".$String."</li>";
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[br\]/", $String)) {
        $String = preg_replace("/\[br\]/", "<br />", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[hr\]/", $String)) {
        $String = preg_replace("/\[hr\]/", "<hr />", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[left\]/", $String)) {
        $String = preg_replace("/\[left\]/", "<p style=\"text-align: left;\">", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/left\]/", $String)) {
        $String = preg_replace("/\[\/left\]/", "</p>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[center\]/", $String)) {
        $String = preg_replace("/\[center\]/", "<p style=\"text-align: center;\">", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/center\]/", $String)) {
        $String = preg_replace("/\[\/center\]/", "</p>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[right]/", $String)) {
        $String = preg_replace("/\[right]/", "<p style=\"text-align: right;\">", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[\/right]/", $String)) {
        $String = preg_replace("/\[\/right]/", "</p>", $String);
        $NoParagraph = true;
        $StringChanged = true;
    }
    if(preg_match("/\[footnote]/", $String)) {
        $String = preg_replace("/\[footnote]/", "<span class=\"footnote\">", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[\/footnote]/", $String)) {
        $String = preg_replace("/\[\/footnote]/", "</span>", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[color=(.*?)\]/", $String, $Params)) {
        $String = preg_replace("/\[color=".$Params[1]."\]/", "<span style=\"color: ".$Params[1].";\">", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[\/color]/", $String)) {
        $String = preg_replace("/\[\/color]/", "</span>", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[class=(.*?)\]/", $String, $Params)) {
        $String = preg_replace("/\[class=".$Params[1]."\]/", "<span class=\"".$Params[1]."\">", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[\/class]/", $String)) {
        $String = preg_replace("/\[\/class]/", "</span>", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[url=(.*?)\]/", $String, $Params)) {
        $String = preg_replace("/\[url=".preg_replace("/\//", "\/", $Params[1])."\]/", "<a href=\"".$Params[1]."\">", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if(preg_match("/\[\/url]/", $String)) {
        $String = preg_replace("/\[\/url]/", "</a>", $String);
        $NoParagraph = false;
        $StringChanged = true;
    }
    if ($StringChanged == true) {
        $String = ProcessBBCodes($String, false);
    }
    if ($AllowParagraph) {
        if (!$NoParagraph) {
            $String = "<p>".$String."</p>";
        }
    }

    return $String;
}
?>