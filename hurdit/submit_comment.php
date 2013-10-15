<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <link rel="shortcut icon" href="favicon.ico">
        <title>Hurdit</title>
    </head>
    <body>
        <table class="background">
            <tr>
                <td>
                    <?php
                    include("includes/connect.php");
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    session_start();
                    $userID = $_SESSION['userID'];
                    $storyID = $_POST['storyID'];
                    $comment = $_POST['comment'];
                    //inserts the comment into the database
                    $query = "(SELECT MAX(id) FROM `comments` WHERE `storyID` = '$storyID')";
                    $extract = mysql_query($query) or die("ERROR: UNABLE TO GET COMMENT ID; PLEASE CONTACT US ");
                    while ($row = mysql_fetch_assoc($extract)) {
                        $maxID = $row['MAX(id)'];
                    }
                    if ($maxID == null) {
                        $id = 1;
                    } else {
                        $id = $maxID + 1;
                    }
                    //replaces ' with ASCII character #39 so it can be stored in the database
                    if ($comment) {
                        $comment = str_replace("'", "&#039;", $comment);
                        require 'includes/profanity_filter.php';
                        $query = "INSERT INTO `gwu`.`comments` (`id`, `userID`, `storyID`, `comment`, `timeWritten`, `upVotes`, `downVotes`, `edited`, `lastEdited`)
                        VALUES ($id, '$userID', '$storyID', '$comment', CURRENT_TIMESTAMP, '0', '0', '0', NOW());";
                        mysql_query($query) or die("$id value of id");
                    }
                    echo "<meta HTTP-EQUIV='REFRESH' content='0; url=show_story.php?story=$storyID'>";
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>