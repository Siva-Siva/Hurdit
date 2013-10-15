<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ("connect.php");
session_start(); // starts a session with all the required variables
$userName = $_SESSION['username']; //gets the username
$userId = $_SESSION['userID']; // gets the userid
$id = $_GET['id'];// gets the id of the story that is being voted upon
if ($userId == null) { // if the user had already voted upon this, it returns log
    echo "log";
} else {
    $extract = mysql_query("SELECT * FROM story where id = $id") or die("Not working"); //selects all the votes and upvotes related to the story
    while ($row = mysql_fetch_assoc($extract)) {
        $upVotes = $row['upVotes'];
        $downVotes = $row['downVotes'];
    }
    $extract2 = mysql_query("SELECT * FROM storyvotes WHERE storyID =$id AND userID=$userId") or die("Not working2"); // selects all the votes and upvotes related to the story
    while ($row = mysql_fetch_assoc($extract2)) {
        $direction = $row['direction'];
    }
    if ($direction == null) { // if the story has not been voted on the following script is run
        $upVotes = $upVotes + 1;
        echo $upVotes- $downVotes;
        mysql_query("UPDATE  `gwu`.`story` SET  `upVotes` = $upVotes where id = $id");
        mysql_query("
INSERT INTO  `gwu`.`storyvotes` (
`userID` ,
`storyID` ,
`direction` ,
`timeVoted` 
)
VALUES (
$userId,  $id,  '1',
CURRENT_TIMESTAMP 
)");
    }
    if ($direction == 1) { // if the user has already voted on the story the following script is run
        $vote = $upVotes - $downVotes;
        echo $vote;
    }
    if ($direction == -1) { // if the user has already voted on the story and wants to change his vote the following script is run
        $upVotes = $upVotes + 1;
        $downVotes = $downVotes - 1;
        $direction1 = "1";
        mysql_query("UPDATE  `gwu`.`story` SET  `downVotes` = $downVotes where id = $id");
        mysql_query("UPDATE  `gwu`.`story` SET  `upVotes` = $upVotes where id = $id");
        mysql_query("UPDATE  `gwu`.`storyvotes` SET  `direction` = $direction1 where storyID = $id");
        $vote = $upVotes - $downVotes;
        echo $vote;
    }

//$Response = array( 'Id' => $id,  'Article' => $article,'ThumbsUp' => $thumbsup);
}
exit;
?>
