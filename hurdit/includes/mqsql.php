<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require ("connect.php");
session_start();
$userName = $_SESSION['username'];
$userId = $_SESSION['userID'];
$id = $_GET['id'];
if ($userId == null) {
    echo "log";
} else {
//mysql_select_db("story") or die ("Could not select Database");
    $extract = mysql_query("SELECT * FROM story where id = $id") or die("Not working");
//$numrows = mysql_num_row($extract);

    while ($row = mysql_fetch_assoc($extract)) {
        $upVotes = $row['upVotes'];
        $downVotes = $row['downVotes'];
    }

    $extract2 = mysql_query("SELECT * FROM storyvotes WHERE storyID =$id AND userID=$userId") or die("Not working2");
    while ($row = mysql_fetch_assoc($extract2)) {
        $direction = $row['direction'];
    }
    if ($direction == null) {
        $upVotes = $upVotes + 1;
        echo $upVotes- $downVotes;
        mysql_query("UPDATE  `gwu`.`story` SET  `upVotes` = $upVotes where id = $id");
        mysql_query("
INSERT INTO  `gwu`.`storyvotes` (
`userID` ,
`storyID` ,
`direction` ,
`timeVoted` ,
`dateVoted`
)
VALUES (
$userId,  $id,  '1',
CURRENT_TIMESTAMP ,  CURRENT_DATE
)");
    }
    if ($direction == 1) {
        $vote = $upVotes - $downVotes;
        echo $vote;
    }
    if ($direction == -1) {
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
