<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
require ("includes/connect.php");
//get user and friend to be info
$usernameAdd = $_SESSION['username'];
$friendAdd = $_GET['uid'];
$queryFriend = mysql_query ( "SELECT `id` FROM `users` WHERE `username` = '$usernameAdd'" ) or die ("Siva can't code1");

  while ($row69 = mysql_fetch_array ($queryFriend)){
		$usernameAdd = $row69;
                
  }
  $userfinal = $usernameAdd[0];

//add them as friend into the database
   $query = "SELECT * FROM `friends` WHERE `userID` = '$userfinal' AND `friendID`= '$friendAdd' ";
                            $result = mysql_query($query) or die("Error");
                            $numrows = mysql_num_rows($result);
                            if ($numrows ==0){
$queryAddFriend = "INSERT INTO friends ( userID , friendID ) VALUES ( '$userfinal' , '$friendAdd' )";
$queryAdd = mysql_query ( $queryAddFriend ) or die ("Im Dumb");}

?>