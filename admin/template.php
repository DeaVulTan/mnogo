<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<META NAME="Author" CONTENT="NessawolF [NF], nfstrider@gmail.com">
<title>PROSoft - SharqSTREAM Soft Portal</title>
<link href="../style.css" rel="stylesheet" type="text/css">
</head>

<? include ('include.php'); ?>

<body>
<? include ('header.php'); ?>

<?
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr>";

	// ======================
	// ===== LEFT FIELD =====
	// ======================
	
	echo "<td width='250' valign='top'>"; // ----

		include ('left.php');
	
	echo "</td>"; // ----
	
	// ======================
	// == VERTICAL DIVIDER ==
	// ======================
		
	echo "<td width='30'>&nbsp;</td>"; // ----

	// ======================
	// ===== MAIN  PART =====
	// ======================
		
	echo "<td valign='top'>"; // ----
	
	// CATEGORIES LIST

		include ('cat_list.php');
	
	// ---- START HERE ----
		
	echo "</td>"; 	 // ----
	echo "</tr>"; 	 // ----
	echo "</table>"; // ----

?>

<? include ('footer.php'); ?>
</body>
</html>
