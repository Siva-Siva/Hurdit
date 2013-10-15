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
                    //gets the variables and deletes the story as well as all the votes associated with the story
                    $userID = $_SESSION['userID'];
                    $storyID = $_GET['storyID'];
                    $commentID = $_GET['commentID'];
                    if ($commentID) {
                        $query = "DELETE FROM `gwu`.`comments` WHERE `comments`.`id`=$commentID";
                        mysql_query($query) or die("Error");
                        $query = "DELETE FROM `gwu`.`commentvotes` WHERE `commentvotes`.`commentID` = '$commentID'";
                        mysql_query($query) or die("Error");
                    }

                    echo "<meta HTTP-EQUIV='REFRESH' content='0; url=show_story.php?story=$storyID'>";
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>