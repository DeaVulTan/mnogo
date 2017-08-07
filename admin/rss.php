<?php
include ("include.php");

$today=mktime(0, 0, 0, date("m"), date("d"), date("Y"));
$query=mysql_query("SELECT * FROM files ORDER BY create_date DESC LIMIT 50");

mysql_close($db);

$pubDate=date('D, d M Y H:i:s T', time());
$lastBuildDate=date('D, d M Y H:i:s T', mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));

header("Content-Type: application/rss+xml");

echo "<?xml version=\"1.0\" encoding=\"koi8-r\"?>
<rss version=\"2.0\">
  <channel>
    <title>Трхнедпке прюкпмк www.ProSOFT.uz</title>
    <link>http://www.prosoft.uz/</link>
    <description>Трфжвн тфръфвоопрър рчехтеаепку</description>
    <language>ru-ru</language>
    <pubDate>{$pubDate}</pubDate>
    <lastBuildDate>{$lastBuildDate}</lastBuildDate>
    <webMaster>info@st.uz</webMaster>
";

while ( $row=mysql_fetch_assoc($query) ) {
    $pubDate=date('D, d M Y H:i:s T', $row["birthday"]);
    
    echo "
    <item>
      <title>{$row['title']}</title>
      <link>http://www.prosoft.uz/index.php?f={$row['id']}</link>
      <description>{$row['desc_small']}</description>
      <pubDate>{$pubDate}</pubDate>
      <guid>http://www.prosoft.uz/index.php?f={$row['id']}</guid>
    </item>
";
}

echo "  </channel>
</rss>";

?>