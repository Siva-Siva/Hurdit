<?php
$connect = mysql_connect('localhost', 'root', '') or die("Coult not connect");
mysql_select_db("hurdit");
$query = "INSERT INTO `gwu`.`users` (`id`, `username`, `password`, `email`, `dateJoined`, `banned`, `banUntil`, `ip`, `userLevel`) VALUES (NULL, 'test', '34', 'sgh6th', CURDATE(), '0', NULL, 'aeh', '1')";
mysql_query($query) or die ("error");
echo "Connected";
?>
