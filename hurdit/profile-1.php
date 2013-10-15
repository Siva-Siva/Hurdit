<html>
    <body>
    <head>
        <script type="text/javascript" src="jquery-1.5.2.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
            {
                $('a.addfriend').bind('click',function() // checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id'); //gathers the id of of the object that was clicked in the <a> tag
                   // alert (myid);
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in the database
                    "http://localhost/hurdit/friend_add.php?uid="+myid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                        alert (value);
                    }
                )
                }
            )

                    $('a.removefriend').bind('click',function() // checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id'); //gathers the id of of the object that was clicked in the <a> tag               
                  $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in the database
                    "http://localhost/hurdit/friend_remove.php?uid="+myid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                        alert (value);
                    }
                )
                }
            )
            }
        )
        </script>
    </head>
<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
session_start();
include("includes/connect.php");
include("includes/banner.php");
$checkId = $_GET['uid'];
$username = $_SESSION['username'];

//checking if someone is logged in
if (isset($username) == true ) {

			$result = mysql_query("SELECT * FROM users WHERE username = '$username'") or die ('Query Failed to get User information');
		while($row = mysql_fetch_array($result)) {
			$joined = $row['timeJoined'];
			$userId = $row['id'];
			$userLevel = $row['userLevel'];
			$gender = $row['gender'];
			$displayPicture = $row['displayPicture'];
		}


	//if logged checks if they are visiting a friends page, this one is for if they aren't
	if (isset($checkId) == false ) {
		//setting the gender to a word instead of a character
		$m = "m";
			if ($gender == $m){
				$gender = "Male";
			} else {
				$gender = "Female";
			}

		//setting the user level variable to a word, instead of a number
			if ($userLevel = "1") {
				$userLevel = "Hurder";
			}
			if ($userLevel = "2") {
				$userLevel = "Moderator";
			}
			if ($userLevel = "3") {
				$userLevel = "Admin";
			}



		echo "<br>";

			// table to contain and Display Account id, when they joined, and their Display Picture
			echo "<table border=1 align=center>";
					echo "<tr><td rowspan=2><img src=$displayPicture></td>";
					echo "<td width=>Account #$userId</td></tr><tr><td>You joined on $joined.</td></tr>";
			echo "</table>";

			echo "<br>";

			// Table to contain their followers and who they are following also contains their account info
			echo "<table border=1 align=center width=1000>";
			echo "<tr><td width=150 valign=top>";

							// title for their herd
							echo "<br><center>Herd</center>";

							// grab herd info, sets in variable and displays it
                            $findHerd = "SELECT * FROM friends WHERE userID = '$userId'";
                            $findHerdResults = mysql_query($findHerd) or die ('Query to get Herd Failed');
                            while ($herd = mysql_fetch_array ($findHerdResults)) {
									$friend = $herd['friendID'];

										$resultFriend = mysql_query("SELECT * FROM users WHERE id = '$friend'") or die ('Query Failed to get FRIEND information');
											while($row = mysql_fetch_array($resultFriend)) {
												$friendName = $row['username'];
												$friendDisplayPicture = $row['displayPicture'];
											}

									$friendHerd = $friendHerd + 1;
                                    echo "<a href=profile.php?uid=$friend ><img src=$friendDisplayPicture> $friendName</a> <br>";
                            }

							//title for their herding
							echo "<br><center>Herding</center>";

							// grab herding info, sets in variable and displays it
                            $findHerding = "SELECT * FROM friends WHERE friendID = '$userId'";
                            $findHerdingResults = mysql_query($findHerding) or die ('Query to get Herding Failed');
                            while ($herding = mysql_fetch_array ($findHerdingResults)) {
									$friend = $herd['userID'];

											$resultFriend = mysql_query("SELECT * FROM users WHERE id = '$friend'") or die ('Query Failed to get FRIEND information');
											while($row = mysql_fetch_array($resultFriend)) {
												$friendName = $row['username'];
												$friendDisplayPicture = $row['displayPicture'];
											}

									$friendHerd = $friendHerd + 1;
                                    echo "<a href=profile.php?uid=$friend ><img src=$friendDisplayPicture> $friendName</a> <br>";
                            }
				//profile information
				echo "<td width=400 valign=top>";
						echo "<br>Profile";
						echo "<ol>";
						echo "<li>Gender : $gender</li>";
						echo "<li>User Level : $userLevel</li>";
						echo "</ol>";
				echo "</td>";
				echo "<td width=450 valign=top>";
						echo "<br>Edit Information";
						echo "<ol>";
						echo "<li><a href=edit.php?what=password>Change Password</a></li>";
						echo "</ol>";
				echo "</td>";
			echo "</td></tr>";
			echo "</table>";
	}

		// once user is logged in, they can view friend profiles with this code.
        if (isset($checkId) == True ) {


				$result = mysql_query("SELECT * FROM users WHERE id = '$checkId'") or die ('Query Failed to get User information');
		while($row = mysql_fetch_array($result)) {
			$joined = $row['timeJoined'];
			$id = $row['id'];
			$userLevel = $row['userLevel'];
			$gender = $row['gender'];
			$displayPicture = $row['displayPicture'];
		}

		//setting the gender to a word instead of a character
		$m = "m";
			if ($gender == $m){
				$gender = "Male";
			} else {
				$gender = "Female";
			}

		//setting the user level variable to a word, instead of a number
			if ($userLevel = "1") {
				$userLevel = "Hurder";
			}
			if ($userLevel = "2") {
				$userLevel = "Moderator";
			}
			if ($userLevel = "3") {
				$userLevel = "Admin";
			}



		echo "<br>";

			// table to contain and Display Account id, when they joined, and their Display Picture
			echo "<table border=1 align=center>";
					echo "<tr><td rowspan=2><img src=$displayPicture></td>";
					echo "<td width=>Account #$id</td></tr><tr><td>You joined on $joined.</td></tr>";
			echo "</table>";

			echo "<br>";

			// Table to contain their followers and who they are following also contains their account info
			echo "<table border=1 align=center width=1000>";
			echo "<tr><td width=150 valign=top>";

							// title for their herd
							echo "<br><center>Herd</center>";

							//sets isfriend to no to restart check of being a friend
							$isFriend = "no";
							// grab herd info, sets in variable and displays it
                            $findHerd = "SELECT * FROM friends WHERE userID = '$id'";
                            $findHerdResults = mysql_query($findHerd) or die ('Query to get Herd Failed');
                            while ($herd = mysql_fetch_array ($findHerdResults)) {
									$friend = $herd['friendID'];

									//if they are a friend sets to yes



									if ($friend == $userId) {
										$isFriend = "yes";
									}

										$resultFriend = mysql_query("SELECT * FROM users WHERE id = '$friend'") or die ('Query Failed to get FRIEND information');
											while($row = mysql_fetch_array($resultFriend)) {

												$friendName = $row['username'];
												$friendDisplayPicture = $row['displayPicture'];
											}

									$friendHerd = $friendHerd + 1;
                                    echo "<a href=profile.php?uid=$friend ><img src=$friendDisplayPicture> $friendName</a> <br>";
                            }

							//title for their herding
							echo "<br><center>Herding</center>";

							// grab herding info, sets in variable and displays it
                            $findHerding = "SELECT * FROM friends WHERE friendID = '$id'";
                            $findHerdingResults = mysql_query($findHerding) or die ('Query to get Herding Failed');
                            while ($herding = mysql_fetch_array ($findHerdingResults)) {
									$friend = $herd['userID'];

											$resultFriend = mysql_query("SELECT * FROM users WHERE id = '$friend'") or die ('Query Failed to get FRIEND information');
											while($row = mysql_fetch_array($resultFriend)) {
												$friendName = $row['username'];
												$friendDisplayPicture = $row['displayPicture'];
											}

									$friendHerd = $friendHerd + 1;
									if ($friend == true) {
                                    echo "<a href=profile.php?uid=$friend ><img src=$friendDisplayPicture> $friendName</a> <br>";
									}
                            }
				//profile information
				echo "<td width=400 valign=top>";
						echo "<br>Profile";
						echo "<ol>";
						echo "<li>Gender : $gender</li>";
						echo "<li>User Level : $userLevel</li>";
						echo "</ol>";
						echo "<br><br><br>";

						/*vvvv SIVA THIS IS WHERE YOU EDIT IF THEY CAN CLICK */
                                                // in the code below; see where it says id = ; set that to the variable that you want to send to the php program
                                                // same thing for the second img
						if ( $isFriend == "no") {
							echo "<a id = $checkId class = 'addfriend'>
                                                             <img id=$checkId class ='addfriend' src='images/thumbdown_red.png'>
                                                            </a>";
						} else {
                                                    echo "<a id =$checkId class = 'removefriend'>
						 <img id=$checkId class ='removefriend'  src='images/thumbup_blue.png'>
                                               </a>";
						}

						/* ^^^here^^^ */
				echo "</td>";
				echo "<td width=450 valign=top>";
						echo "<br>Edit Information";
						echo "<ol>";
						echo "<li><a href=edit.php?what=password>Change Password</a></li>";
						echo "</ol>";
				echo "</td>";
			echo "</td></tr>";
			echo "</table>";


	}
}
?>
</body>
</html>