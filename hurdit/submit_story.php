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
                    //gets all the info
                    $storyURL = mysql_real_escape_string($_POST['storyURL']);
                    $storyTitle = mysql_real_escape_string($_POST['storyTitle']);
                    $storyDescription = mysql_real_escape_string($_POST['storyDescription']);
                    $autoFill = $_POST['autoFill'];
                    $submitStory = $_POST['submitStory'];
                    $username = $_SESSION['username'];
                    $userID = $_SESSION['userID'];
                    if (!isset($username)) {
                        echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
                    }
                    include("includes/banner.php");
                    echo "<br>";
                    $tags = get_meta_tags($storyURL);
                    if (isset($autoFill)) {
                        //gets the title and description of the story
                        $websiteSource = (string) file_get_contents($storyURL, 1000);
                        preg_match("/\<title\>(.*)\<\/title\>/", $websiteSource, $title);
                        $title = $title[1];
                        $storyDescription = $tags['description'];
                        //user enters the URL and title and description here
                        echo "
                            <table class='submit_story_background'>
                                <tr>
                                    <td>
                                        <form method='POST' action='submit_story.php'>
                                            <table class='submit_story'>
                                                <tr>
                                                    <td>
                                                        URL
                                                    </td>
                                                    <td>
                                                        <input type='text' value='$storyURL' name='storyURL'/>
                                                    </td>
                                                    <td>
                                                        <input type='submit' name='autoFill' value='Auto Fill'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Title
                                                    </td>
                                                    <td>
                                                        <input type='text' value='$title' name='storyTitle'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Description
                                                    </td>
                                                    <td colspan='2'>
                                                        <textarea rows='10' cols='30' name='storyDescription'/>$storyDescription</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td colspan='2'>
                                                        <input type='submit' name='submitStory' value='Submit'/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        </td>
                                </tr>
                            </table>
                    ";
                    }
                    //Takes out esacpe characters out of the title
                    if (isset($submitStory)) {
                        if (!(preg_match('/^[\p{L&} -]+$/u', $storyTitle))) {
                            $storyTitle = "No Title";
                        }
                        //inserts the stories into the database
                        $query = "INSERT INTO `gwu`.`story` (`id`, `name`, `description`, `upVotes`, `downVotes`, `username`, `views`, `timeSubmitted`, `storyLink`) VALUES (NULL, '$storyTitle', '$storyDescription', '0', '0', '$username', '0', CURRENT_TIMESTAMP, '$storyURL')";
                        mysql_query($query) or die("Error");
                        $result = mysql_query("SELECT * FROM story WHERE username = '$username'") or die("Error");
                        while ($row = mysql_fetch_assoc($result)) {
                            $storyID = $row['id'];
                        }
                        echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
                    }
                    //gets the info for submitting a story
                    if ((!(isset($submitStory)) && !(isset($autoFill))) || !(isset($storyURL))) {
                        echo"
                            <table class='submit_story_background'>
                                <tr>
                                    <td>
                                        <form method='POST' action='submit_story.php'>
                                            <table class='submit_story'>
                                                <tr>
                                                    <td>
                                                        URL
                                                    </td>
                                                    <td>
                                                        <input type='text' value='$storyURL' name='storyURL'/>
                                                    </td>
                                                    <td>
                                                        <input type='submit' name='autoFill' value='Auto Fill'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Title
                                                    </td>
                                                    <td>
                                                        <input type='text' value='$storyTitle' name='storyTitle'/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Description
                                                    </td>
                                                    <td colspan='2'>
                                                        <textarea rows='10' cols='30' value='$storyDescription' name='storyDescription'/></textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td colspan='2'>
                                                        <input type='submit' name='submitStory' value='Submit'/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        </td>
                                </tr>
                            </table>
                    ";
                    }
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>