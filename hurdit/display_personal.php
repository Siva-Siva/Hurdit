<?php
//Displays the personal display picture
$username= $_GET['username'];
include('includes/connect.php');
$result2 = mysql_query("SELECT * FROM users WHERE username = '$username'") or die ('Query Failed : display_personal');
while($row2= mysql_fetch_array($result2)) {
$type = $row2['imgType'];
$content = $row2['imgContent'];
}
if ($type == null) {
    echo "<img src= images/profile_pic.png";
} else {
header ('Content-type: $type',false);
echo $content;
}
?>

