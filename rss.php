<?php
require_once('include.php');

$today=mktime(0, 0, 0, date("m"), date("d"), date("Y"));
$query=mysql_query("SELECT * FROM files WHERE parent_item = 0 ORDER BY create_date DESC limit 50");

$pubDate=date('D, d M Y H:i:s T', time());
$lastBuildDate=date('D, d M Y H:i:s T', mktime(23, 59, 59, date("m"), date("d")-1, date("Y")));

header("Content-Type: application/rss+xml");

echo "<?xml version=\"1.0\" encoding=\"windows-1251\"?>
<rss version=\"2.0\">
  <channel>
    <title>Новинки портала mySoft.uz</title>
    <link>http://mysoft.uz/</link>
    <description>Портал программного обеспечения</description>
    <language>ru-ru</language>
    <pubDate>{$pubDate}</pubDate>
    <lastBuildDate>{$lastBuildDate}</lastBuildDate>
    <webMaster>info@st.uz</webMaster>
";

while ( $row=mysql_fetch_assoc($query) ) {
    $pubDate=date('D, d M Y H:i:s T', $row["create_date"]);
    
    echo "
    <item>
      <title>{$row['title']}</title>
      <link>http://mysoft.uz/index.php?id={$row['id']}</link>
      <description>{$row['desc_short']}</description>
      <pubDate>{$pubDate}</pubDate>
      <guid>http://mysoft.uz/index.php?id={$row['id']}</guid>
    </item>
";
}

echo "  </channel>
</rss>";

?>