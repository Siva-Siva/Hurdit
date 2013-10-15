<?php
$friend = "43";
include('includes/connect.php');
$result3 = mysql_query("SELECT * FROM users WHERE id = '$friend'") or die ('Query Failed : display_personal');
while($row3= mysql_fetch_array($result3)) {
$type = $row3['imgType'];
$content = $row3['imgContent'];
}
header ('Content-type: $type',false);
echo $content;
?>