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
                    include("includes/banner.php");
                    ;
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    session_start();
                    //gets which comment needs to be edited
                    $userID = $_SESSION['userID'];
                    $storyID = $_REQUEST['storyID'];
                    $commentID = $_REQUEST['commentID'];
                    $comment = $_REQUEST['comment'];
                    $query = "SELECT `comment` FROM `comments` WHERE `id`=$commentID";
                    $result = mysql_query($query);
                    while ($row = mysql_fetch_assoc($result)) {
                        $oldComment = $row['comment'];
                    }
                    if ($commentID && !isset($comment)) {
                        //displays the comment in the textbox to be edited
                        echo "
                            <table>
                                <tr>
                                    <td>
                                        <form method='GET' action='edit_comment.php'>
                                            <table class='submit_comment'>
                                                <tr>
                                                    <td class='submit_comment_text'>
                                                        Edit Comment:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <textarea rows='3' cols='110' name='comment'/>$oldComment</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class='submit_comment_button'>
                                                        <input type='hidden' name='storyID' value='$storyID'>
                                                        <input type='hidden' name='commentID' value='$commentID'>
                                                        <input type='submit' value='Submit' name='submit' />
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                            ";
                    }
                    if (isset($comment)) {
                        //replaces the ' with &#039 so it can be stored in the database, and then stores it in the database
                        $comment = str_replace("'", "&#039;", $comment);
                        require 'includes/profanity_filter.php';
                        $query = "UPDATE `gwu`.`comments` SET `comment` = '$comment' WHERE `comments`.`id`=$commentID";
                        mysql_query($query) or die("Error: Comment contains illegal characters.");
                        echo "<meta HTTP-EQUIV='REFRESH' content='0; url=show_story.php?story=$storyID'>";
                    }
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>