<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
require ("includes/connect.php");
//getts the user info and friend to remove
$usernameAdd = $_SESSION['username'];
$friendAdd = $_GET['uid'];


echo $friendAdd;
// turns the username into a user id
$queryFriend = mysql_query ( "SELECT `id` FROM `users` WHERE `username` = '$usernameAdd'" ) or die ("Siva can't code2");

  while ($row69 = mysql_fetch_array ($queryFriend)){
		$usernameAdd = $row69;
  }
 $userfinal = $usernameAdd[0];
print_r ($userfinal);
//removes them as friends
$query = "DELETE FROM `friends` WHERE `userID` = '$userfinal' AND `friendID` = '$friendAdd'";
mysql_query($query);

?>