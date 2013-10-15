<?php
$connect = mysql_connect('localhost', 'root', '') or die("Could not connect"); // connects to mysql
mysql_select_db("gwu") or die ("Could not select Database"); // connects to the database so that it can be used throughout all the files
?>