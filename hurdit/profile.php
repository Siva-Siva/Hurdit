<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="shortcut icon" href="favicon.ico">
        <title>Hurdit</title>
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
                        alert ("ADDED");
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
                        alert ("REMOVED");
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
    $userID = $_SESSION['userID'];
    if (!isset($checkId)) {
        $checkId = $userID;
    }
    $username = $_SESSION['username'];

    $result = mysql_query("SELECT * FROM users WHERE username = '$username'") or die('Query Failed to get User information');
    while ($row = mysql_fetch_array($result)) {
        $joined = $row['timeJoined'];
        $userId = $row['id'];
        $userLevel = $row['userLevel'];
        $gender = $row['gender'];
        $displayPicture = $row['displayPicture'];
    }


//checking if someone is logged in
    if (isset($username) == true) {

//if logged checks if they are visiting a friends page, this one is for if they aren't
        if (isset($checkId)) {
//setting the gender to a word instead of a character
            $m = "m";
            if ($gender == $m) {
                $gender = "Male";
            } else {
                $gender = "Female";
            }

//setting the user level variable to a word, instead of a number
            if ($userLevel == "1") {
                $userLevel = "Hurder";
            }
            if ($userLevel == "2") {
                $userLevel = "Moderator";
            }
            if ($userLevel == "3") {
                $userLevel = "Admin";
            }



            echo "<br>";

// table to contain and Display Account id, when they joined, and their Display Picture
            echo "<table border=0 bgcolor=#509AD9 align=center>";
            echo "<tr><td rowspan=2><img src=$displayPicture></td>";
            echo "<td width=>Account #$checkId</td></tr><tr><td>You joined on $joined.</td></tr>";
            echo "</table>";

            echo "<br>";

// Table to contain their followers and who they are following also contains their account info
            echo "<table border=0 bgcolor=#509AD9 align=center width=1000>";
            echo "<tr><td width=150 valign=top>";

// title for their herd
            echo "<br><center>Hurding</center>";

// grab herd info, sets in variable and displays it
			
            $findHerd = "SELECT * FROM friends WHERE userID = '$checkId'";
            $findHerdResults = mysql_query($findHerd) or die('Query to get Herd Failed');
            while ($herd = mysql_fetch_array($findHerdResults)) {
                $friend = $herd['friendID'];
				
					
                $resultFriend = mysql_query("SELECT * FROM users WHERE id = '$friend'") or die('Query Failed to get FRIEND information');
                while ($row = mysql_fetch_array($resultFriend)) {
                    $friendName = $row['username'];
                    $friendDisplayPicture = $row['displayPicture'];
                }
                $friendHerd = $friendHerd + 1;

                echo "<a href=profile.php?uid=$friend ><img src=$friendDisplayPicture> $friendName</a> <br>";
            }

//title for their herding
            echo "<br><center>Hurd</center>";
// grab herding info, sets in variable and displays it
            $query = "SELECT `userID` FROM `friends` WHERE `friendID` = '$checkId'";
            $extract = mysql_query($query);
            while ($row = mysql_fetch_assoc($extract)) {
                $dbUserID = $row['userID'];
                $queryFriend = "SELECT * FROM `users` WHERE `id` = $dbUserID";
                $extractUser = mysql_query($queryFriend);
                while ($rowUser = mysql_fetch_assoc($extractUser)) {
                    $dbHurdingID = $rowUser['id'];
                    $dbHurdingName = $rowUser['username'];
                    $dbHurdingDP = $rowUser['displayPicture'];
                }
            }
			
			
			if ($userID == $dbHurdingID ) {
				$isFriend = "no";
			} else {
				$isFriend = "yes";
			}


            $friendHerd = $friendHerd + 1;
			if (isset($dbHurdingID)){
				echo "<a href=profile.php?uid=$dbHurdingID ><img src=images/profile_pic_small.png> $dbHurdingName</a> <br>";
			}
        }
//profile information
        echo "<td width=400 valign=top>";
        echo "<br>Profile";
        echo "<ol>";
        echo "<li>Gender : $gender</li>";
        echo "<li>User Level : $userLevel</li>";
        echo "</ol>";
		if ($checkId == $userID) {
		
		} else {
			if ($isFriend == "no") {
				echo "<a id = $checkId class = 'removefriend'><img id=$checkId class ='addfriend' src='images/leave_hurd.png'></a>";
			}
			if ($isFriend == "yes") {
				echo "<a id =$checkId class = 'addfriend'><img id=$checkId class ='removefriend'  src='images/join_hurd.png'></a>";
			}
		}
		
        echo "</td>";
        if ($checkId == $userID) {
            echo "<td width=450 valign=top>";
            echo "<br>Edit Information";
            echo "<ol>";
            echo "<li><a href=edit.php?what=password&huh=no>Change Password</a></li>";
            echo "<li><a href=edit.php?what=sex&huh=no>Change Sex</a></li>";
            echo "</ol>";
            echo "</td>";
        } else {
            echo "<td width=450>";
            echo "</td>";
        }
        echo "</td></tr>";
        echo "</table>";
    }
    include ('includes/footer.php');
    ?>
</body>
</html>