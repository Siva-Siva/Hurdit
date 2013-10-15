<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ("connect.php");
session_start(); // Starts the session with all the stored variables
$userName = $_SESSION['username'];// gets the username 
$userId = $_SESSION['userID'];// gets the userID
$id = $_GET['id'];// gets the id of the comment that is being upvoted
$storyID = $_GET['storyID'];// gets the id of the story that is being voted upon
if ($userId == null) {// if the user is not logged on, the program tells the user so
    echo "log";
} else {
    $extract = mysql_query("SELECT * FROM comments WHERE id = $id") or die("Not working");// gets all the upvotes and downvotes for a specific story
    while ($row = mysql_fetch_assoc($extract)) {
        $upVotes = $row['upVotes']; //upvotes
        $downVotes = $row['downVotes']; // downvotes
    }

    $extract2 = mysql_query("SELECT * FROM commentvotes WHERE commentID =$id AND userID=$userId AND storyID=$storyID") or die("Not working2");// gets all the commentvotes for the specified comment
    while ($row = mysql_fetch_assoc($extract2)) {
        $direction = $row['direction'];
    }
    if ($direction == null) { // if the comment has never been voted by the user, it performs the script below to add his/her vote
        $upVotes = $upVotes + 1;
       $vote = $upVotes - $downVotes;
        echo $vote;
        mysql_query("UPDATE  `gwu`.`comments` SET  `upVotes` = $upVotes where id = $id");
        mysql_query("
INSERT INTO  `gwu`.`commentvotes` (
`userID` ,
`commentID` ,
`storyID`,
`direction` ,
`timeVoted`
)
VALUES (
$userId,  $id, $storyID,  '1',
CURRENT_TIMESTAMP 
)");
    }
    if ($direction == 1) {// if the comment has already been upvoted, then it performs the script below
        $vote = $upVotes - $downVotes;      
        echo $vote;
    }
    if ($direction == -1) { // if the user wants to change his/her vote, then the script which is present below is performed
        $upVotes = $upVotes + 1;
        $downVotes = $downVotes - 1;
        $direction1 = "1";
        mysql_query("UPDATE  `gwu`.`comments` SET  `downVotes` = $downVotes where id = $id");
        mysql_query("UPDATE  `gwu`.`comments` SET  `upVotes` = $upVotes where id = $id");
        mysql_query("UPDATE  `gwu`.`commentvotes` SET  `direction` = $direction1  where storyID = $storyID AND userID=$userId AND commentID =$id");
        $vote = $upVotes - $downVotes;
        echo $vote;
    }

//$Response = array( 'Id' => $id,  'Article' => $article,'ThumbsUp' => $thumbsup);
}
exit;
?>
