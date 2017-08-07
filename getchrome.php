<?php
define ("SourceDir", "http://build.chromium.org/f/chromium/snapshots/Win_Webkit_Latest/");
define ("SourceFile", "mini_installer.exe");
define ("LatestFile", "LATEST");
define ("TargetDir", "/var/www/soft.stream.uz/htdocs/chrome-latest/");
define ("ProsoftID", "930");
define ("ProsoftTitle", "Chromium 18.0");
define ("ProsoftDir", "/media/matrix2/Software/Internet_and_networks/Browsers/");

if (file_exists(TargetDir."lock")) {
	die("Another copy of downloader is active. Process terminated");
}

$lock = fopen(TargetDir."lock", 'a+');
fwrite($lock, date("Y-m-d H:i:s"));
fclose($lock);


$LatestDir = file_get_contents(SourceDir.LatestFile);
if (file_exists(TargetDir.LatestFile)) {
    $LatestDownloaded = file_get_contents(TargetDir.LatestFile);
}
else {
    $LatestDownloaded = "0";
}

if ($LatestDir != $LatestDownloaded) {
    $handle = fopen (SourceDir.$LatestDir."/".SourceFile, 'rb');
    $contents = "";
    if(!$handle) {
		unlink(TargetDir."lock");
        die("Unable to open source file");
    }
    
    if (file_exists(TargetDir.basename(SourceFile))) {
        unlink(TargetDir.basename(SourceFile));
    }
    
    $handle_d = fopen(TargetDir.basename(SourceFile), 'w+b');
    if(!$handle_d) {
        fclose($handle);
		unlink(TargetDir."lock");
        die("Unable to create local target file");
    }
    
    while(!feof($handle)) {
        $data = fread($handle, 8192);
        fwrite($handle_d, $data);
    }

    fclose($handle_d);
    fclose ($handle);

    $ch = curl_init(SourceDir.$LatestDir."/".SourceFile);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //not necessary unless the file redirects (like the PHP example we're using here)
    $data = curl_exec($ch);
    curl_close($ch);
    if ($data === false) {
		unlink(TargetDir."lock");
        die("cURL failed");
    }

    $contentLength = 'unknown';
    $status = 'unknown';
    if (preg_match('/^HTTP\/1\.[01] (\d\d\d)/', $data, $matches)) {
        $status = (int)$matches[1];
    }
    if (preg_match('/Content-Length: (\d+)/', $data, $matches)) {
        $contentLength = (int)$matches[1];
    }

    /*
    echo 'HTTP Status: ' . $status . "\n";
    echo 'Content-Length: ' . $contentLength;
    */

    if ($contentLength == filesize(TargetDir.SourceFile)) {
        chmod(TargetDir.SourceFile, 0777);

        unlink(ProsoftDir.SourceFile);
		if (file_exists(ProsoftDir.SourceFile)) {
			unlink(TargetDir."lock");
			die("Unable to temove previous file");
		}
        rename(TargetDir.SourceFile, ProsoftDir.SourceFile);
		if (!file_exists(ProsoftDir.SourceFile)) {
			unlink(TargetDir."lock");
			die("Unable to move downloaded file");
		}

        $SoftDB = mysql_connect("localhost", "softstream", "cjanbyf");
        mysql_select_db("softstream", $SoftDB);
        mysql_query("UPDATE `files` SET
            `title` = '".ProsoftTitle." Build ".$LatestDir."',
            `size` = '".$contentLength."',
            `downloads_today` = '0',
            `downloads_total` = '0', 
            `create_date` = '".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."'
                 WHERE `id` = '".ProsoftID."'") or die("Unable to update Prosoft Database: ".mysql_error().". Do not forget to remove lock file manually");
        mysql_close($SoftDB);

        if (file_exists(TargetDir.LatestFile)) {
            unlink(TargetDir.LatestFile);
        }
        $fp = fopen(TargetDir.LatestFile, "a+");
        fwrite($fp, $LatestDir);
        fclose($fp);
		unlink(TargetDir."lock");
        die("Transfer complete");
    }
    else {
		unlink(TargetDir."lock");
        die("Transfer error. File sizes do not match. Please try again.");
    }
}
else {
	unlink(TargetDir."lock");
    die("No new version avaliable (".$LatestDownloaded.")");
}
unlink(TargetDir."lock");
die();
?>

