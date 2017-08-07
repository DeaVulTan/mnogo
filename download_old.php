<? 
	require_once ('functions.php');
	/*
	// IPFILTER
		$blocked = 1;
		$ip = convertIPtoNum($_SERVER['REMOTE_ADDR']);
		$from_ip = array("10.3.0.0", "217.29.116.197", "217.29.116.250");
		$to_ip = array("10.3.255.255", "217.29.116.197", "217.29.116.250");
		for ($i=0; $i < count($from_ip); $i++)
		{
			$from = convertIPtoNum($from_ip[$i]);
			$to = convertIPtoNum($to_ip[$i]);
			if ($ip >= $from and $ip <= $to)
			{
				$blocked = 0;
			}
		}
		unset($from, $to, $filter);
		// IPFILTER
		
	if ($blocked) {
		die("403 - Forbidden");
	}
	*/
	$blocked = 0;
	if (!isset($_GET['id']) or !isset($_GET['part']))
	{
		$another_page = "index.php";
		header ("Location: $another_page");
		die;
	}
	
	$id 	 = $_GET['id'];
	$part  = $_GET['part'];
	$is_russ = $_GET['russ'];
	
	require_once ('include.php');

	$result = mysql_query("SELECT id, links_inner, today, downloads_today, downloads_total FROM files WHERE id='".$id."'", $db);
	if (!mysql_num_rows($result))
	{
		mysql_close($db);
		$another_page = "index.php";
		header ("Location: $another_page");
		die;
	}
	
	$file = mysql_fetch_array($result);
	if (!$is_russ)
	{
		$links_inner = explode ("http://", $file['links_inner']);
	}
	else
	{
		$links_inner = explode ("http://", $file['russ_link']);
	}

//	echo "http://".$links_inner[($part+1)]; // -- debug --

	$today=mktime(0, 0, 0);
	if ( $file['today'] != $today )
	{
		$file['downloads_today'] = 0;
	}

	$file['downloads_today']++;
	$file['downloads_total']++;
	
	mysql_query("UPDATE files SET today = ('".$today."'), downloads_today = ('".$file['downloads_today']."'), downloads_total = ('".$file['downloads_total']."') WHERE id = '".$id."'", $db) or die("Error: UPDATE");
	mysql_close($db);
	
	$download_link = trim($links_inner[($part+1)]);
	$download_link = explode(',', $download_link);
	$download_link = $download_link[0];
	
	header('Content-type: application/force-download');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header('Pragma: no-cache');
	header("Location: http://".$download_link);
?>

