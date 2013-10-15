<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title></title>
    </head>
    <body>
        <table class="popular_news_background">
            <table class="popular_news">
                <?php
                include("includes/connect.php");
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                session_start();
                $pageNumber = $_GET['page'];
                if (!isset($pageNumber)) {
                    $pageNumber = 1;
                }
                $username = $_SESSION['username'];
                $userID = $_SESSION['userID'];
                for ($popularNews = 1; $popularNews <= 10; $popularNews++) {
                    $name[$popularNews] = "No Title";
                    $description[$popularNews] = "No Description";
                }
                $storyStart = ($pageNumber - 1) * 10;
                $extract = mysql_query("SELECT * FROM `story` WHERE `story`.`upVotes` - `downVotes` > 49 ORDER BY `id`") or die("Error");
                $totalStories = mysql_num_rows($extract);
                $highestPage = ((int) (($totalStories) / 10)) + 1;
                $extract = mysql_query("SELECT * FROM `story` WHERE `story`.`upVotes` - `downVotes` > 49 ORDER BY `id` DESC LIMIT $storyStart,10") or die("Error");
                $popularNews = 1;
                while ($row = mysql_fetch_assoc($extract)) {
                    $id[$popularNews] = $row['id'];
                    $name[$popularNews] = $row['name'];
                    $description[$popularNews] = $row['description'];
                    $upVotes[$popularNews] = $row['upVotes'];
                    $downVotes[$popularNews] = $row['downVotes'];
                    $votes[$popularNews] = $upVotes[$popularNews] - $downVotes[$popularNews];
                    $storyUsername[$popularNews] = $row['storyUsername'];
                    $views[$popularNews] = $row['views'];
                    $storyLink[$popularNews] = $row['storyLink'];
                    $query = "SELECT * FROM `comments` WHERE `comments`.`storyID` = $id[$popularNews]";
                    $result = mysql_query($query);
                    $commentNumber[$popularNews] = mysql_num_rows($result);
                    $popularNews++;
                }
                $storyEnd = $popularNews;
                for ($popularNews = 1; $popularNews < $storyEnd; $popularNews++) {
                    mysql_query("SELECT * FROM `users` , `comments` WHERE `comments`.`userID` = `users`.`id`") or ("Error");
                }
                for ($popularNews = 1; $popularNews < $storyEnd; $popularNews++) {
                    echo "
                      <tr>
                            <td>
                                <table class='thumbs'>
                                    <tr>
                                        <td>
                                            <img src='images/thumbup_gray.png'>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <img src='images/thumbdown_gray.png'>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class='vote_number'>
                                    <tr>
                                        <td> ";
                    echo $votes[$popularNews];
                    echo "
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class='preview'>
                                    <tr>
                                        <td>
                                            
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class='story'>
                                    <tr>
                                        <td class='story_title'>
                                            <a href='$storyLink[$popularNews]'>$name[$popularNews]</a> ($views[$popularNews] view(s)) 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='story_description'>";
                    if ($description[$popularNews] != "") {
                        echo "<a href='show_story.php?story=$id[$popularNews]'>$description[$popularNews]</a>";
                    } else {
                        echo "<a href='show_story.php?story=$id[$popularNews]'>No Description</a>";
                    }
                    echo "</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href='show_story.php?story=$id[$popularNews]'>($commentNumber[$popularNews] comments)</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    ";
                }
                echo "
                    <table class='change_page'>
                        <tr>
                            <td class='last_page'>";
                $prevPage = $pageNumber - 1;
                if ($pageNumber > 1) {
                    echo "<a href='index.php?page=$prevPage'>Previous Page</a>";
                }
                echo "</td>
                            <td class='next_page'>";
                if ($pageNumber < $highestPage) {
                    $nextPage = $pageNumber + 1;
                    echo "<a href='index.php?page=$nextPage'>Next Page</a>";
                }
                echo "</td>
                        </tr>
                    </table>
                    ";
                ?>
            </table>
        </table>
    </body>
</html>