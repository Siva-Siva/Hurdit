<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="shortcut icon" href="favicon.ico">
        <title>Hurdit</title>
    </head>
    <?php
    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
    session_start();
    include("includes/connect.php");
    include("includes/banner.php");
//gets the username and prints out the news that ther user's friends have submitted
    $username = $_SESSION['username'];

    if (isset($username) == true) {

        echo "<p align=center> This is what your friends have been doing<br><a href=search.php>Search for friend here!</a> </p>";
//selects id from username
        $getUser = "SELECT * FROM users WHERE username = '$username'";
        $getUserNow = mysql_query($getUser) or die(' MYSQL QUERY : HURD NEWS - GET USER ');
        while ($getUserRow = mysql_fetch_array($getUserNow)) {
            $id = $getUserRow['id'];
        }
//gets the Story info from the people that you are following
        $getFriends = "SELECT * FROM friends WHERE userID = '$id'";
        $getFriendsNow = mysql_query($getFriends) or die('MYSQL QUERY : Hurd news - FRIENDS ');
        while ($getFriendsRow = mysql_fetch_array($getFriendsNow)) {

            $friend = $getFriendsRow['friendID'];

            $getUserF = "SELECT * FROM users WHERE id = '$friend'";
            $getUserNowF = mysql_query($getUserF) or die(' MYSQL QUERY : HURD NEWS - GET USER FRIEND');
            while ($getUserRowF = mysql_fetch_array($getUserNowF)) {
                $id = $getUserRowF['id'];
                $friendUser = $getUserRowF['username'];
            }
//gets the info for the stories which your friends have submitted
            $getStory = "SELECT * FROM story WHERE username = '$friendUser'";
            $getStoryNow = mysql_query($getStory) or die('MYSQL QUERY : HURD NEWS - STORY');
            while ($getStoryRow = mysql_fetch_array($getStoryNow)) {

                $storyID = $getStoryRow['id'];
                $storyName = $getStoryRow['name'];
                $storyDescription = $getStoryRow['description'];
                $storyUpVotes = $getStoryRow['upVotes'];
                $storyDownVotes = $getStoryRow['downVotes'];
                $storyUser = $getStoryRow['username'];
                $storyViews = $getStoryRow['views'];
                $storyTimeSubmitted = $getStoryRow['timeSubmitted'];
                $storyLink = $getStoryRow['storyLink'];

                $getStoryComments = "SELECT * FROM comments WHERE userID = '$friend'";
                $getStoryCommentsNow = mysql_query($getStoryComments) or die(' MYSQL QUERY : HURD NEWS - GET STORY COMMENTs');
                $comments = 0;
                while ($getStoryCommentsRow = mysql_fetch_array($getStoryCommentsNow)) {

                    $comments = $comments + 1;
                }
                //displays all the info
                echo "<div class = story_now >";
                echo "<table border=0 bgcolor='#DCEAF4'>";
                echo "<tr><td width=1000 colspan=4><a href=$storyLink>$storyName</a></td></tr>";
                echo "<tr><td width=1000 colspan=4><a href=show_story.php?story=$storyID>$storyDescription</a></td></tr>";
                echo "<tr><td width=200 align=left><a href=show_story.php?story=$storyID>($comments comments)</a> - $storyViews views</td>";
                echo "<td width=300 align=center><img src=like_dislike_bar.php?upVotes=$storyUpVotes&downVotes=$storyDownVotes ></td>";
                echo "<td width=250 align=left><a href=profile.php?uid=$friend>Author : $storyUser</a></td>";
                echo "<td width=250 align=left>Submitted : $storyTimeSubmitted</td></tr>";
                echo "</table>";
                echo "</div>";
                echo "<br>";
            }
        }
    } else {

        
    }

    include("includes/footer.php");
    ?>
</html>
