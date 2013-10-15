<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title></title>
        <script type="text/javascript" src="jquery-1.5.2.js"></script>
        <script type="text/javascript">

            $(document).ready(function()
            {
                $('a.common').bind('click',function() // checks if the <a> tag which belongs to the class of common if clicked upon
                {  
                    var myid = $(this).attr('id'); //gathers the id of of the object that was clicked in the <a> tag
                    var newValue = parseInt(myid) + 10; 
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in the database
                    "http://localhost/hurdit/includes/upvote_story.php?id="+myid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                        var divId = parseInt(myid) + 50;
                        if( value == 'log' ) {
                            alert ("You have to be logged on to rate stories");
                        }
                        else{
                            $( "#" + myid + " img").attr("src","images/thumbup_blue.png");              // changes the voting image 
                            $( "#" + (newValue) + " img").attr("src","images/thumbdown_gray.png"); 		// changes the voting image
                            $( "#" + divId).html(value);} // prints out the final result to the browser
                    }
                )
                }
            )
                $('a.common2').bind('click',function() // checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id');//gathers the id of of the object that was clicked in the <a> tag
                    var newmyid = myid -10;
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in thhe database
                    "http://localhost/hurdit/includes/downvote_story.php?id="+newmyid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value2 = data; 
                        var divId = parseInt(myid) + 40;				
                        if( value2 == 'log' ) {
                            alert ("You have to be logged on to rate stories");
                        }
                        else{
                            $("#" + myid + " img").attr("src","images/thumbdown_red.png"); // changes the voting image
                            $("#" + (myid-10) + " img").attr("src","images/thumbup_gray.png");  // changes the voting image
                            $( "#" + divId).html(value2);} // prints out the final result to the browser
                    }
                )                                        
                }
            )
            }
        )         
        </script>
    </head>
    <body>
        <table class="new_news_background">
            <table class="new_news">
                <?php
                include("connect.php");
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                session_start(); // starts a session with the required variables
                $pageNumber = $_GET['page']; // gets the pageNumber that the user is on
                if (!isset($pageNumber)) {
                    $pageNumber = 1;
                }
                $username = $_SESSION['username']; // gets the username
                $userID = $_SESSION['userID']; // gets the userid
                for ($newNews = 1; $newNews <= 10; $newNews++) { // sets values to news that is going to be printed incase they are empty
                    $name[$newNews] = "No Title";
                    $description[$newNews] = "No Description";
                    $commentNumber[$newNews] = 0;
                    $votes[$newNews] = 0;
                }
                $storyStart = ($pageNumber - 1) * 10;
                $extract = mysql_query("SELECT * FROM `story` ORDER BY `id`") or die("Error"); // selects all the stories in order of when it was submitted
                $totalStories = mysql_num_rows($extract);
                $highestPage = ((int) (($totalStories) / 10)) + 1;
                $extract = mysql_query("SELECT * FROM `story` ORDER BY `id` DESC LIMIT $storyStart,10") or die("Error"); // selects all the stories in order of when it was submitted
                $newNews = 1;
                while ($row = mysql_fetch_assoc($extract)) { // gathers all the data from the database involving the stories to be printed
                    $id[$newNews] = $row['id'];
                    $name[$newNews] = $row['name'];
                    $description[$newNews] = $row['description'];
                    $upVotes[$newNews] = $row['upVotes'];
                    $downVotes[$newNews] = $row['downVotes'];
                    $votes[$newNews] = $upVotes[$newNews] - $downVotes[$newNews];
                    $storyUsername[$newNews] = $row['storyUsername'];
                    $views[$newNews] = $row['views'];
                    $storyLink[$newNews] = $row['storyLink'];
                    $query = "SELECT * FROM `comments` WHERE `comments`.`storyID` = $id[$newNews]";
                    $result = mysql_query($query);
                    $commentNumber[$newNews] = mysql_num_rows($result);
                    $newNews++;
                }
                $justNews = 1;
                $extractvotes = mysql_query("SELECT * FROM `storyvotes` WHERE `storyvotes`.`userID` = '$userID'") or die("Error");
                while ($row = mysql_fetch_assoc($extractvotes)) {  // checks to see what the user has already voted on
                    $dbStoryID = $row['storyID'];
                    $existingVote [$dbStoryID] = $row['direction'];
                }
                for ($newNews = 1; $newNews <= 10; $newNews++) { // prints out 10 storyID's per page
                    $oldNews = $id[$newNews] + 10;
                    $divId = $id[$newNews] + 50;

                    echo "
                      <tr>
                            <td>
                                <table class='thumbs'>
                                    <tr>
                                        <td>
                                          <a id = $id[$newNews] class = 'common'>";

                    if ($existingVote[$id[$newNews]] == 0) { // makes a check to see whether the user has voted on the specified item
                        echo "
                                 <img id= $id[$newNews] class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";
                    } // all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
                    if ($existingVote[$id[$newNews]] > 0) { // makes a check to see whether the user has voted on the specified item
                        echo "
                                 <img id= $id[$newNews] class = 'common' name=imgName border=0 src='images/thumbup_blue.png'";
                    } // all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
                    if ($existingVote[$id[$newNews]] < 0) { // makes a check to see whether the user has voted on the specified item
                        echo "
                                 <img id= $id[$newNews] class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";
                    } // all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript

                    echo "
                                 </a >
                                 </td>
                                <td>                       
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            ";
                    if ($existingVote[$id[$newNews]] == 0) { // makes a check to see whether the user has voted on the specified item
                        echo "
                                            <a id = $oldNews class = 'common2'> 
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'>
                  </a>";
                    } // all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
                    if ($existingVote[$id[$newNews]] < 0) { // makes a check to see whether the user has voted on the specified item
                        echo "
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_red.png'>
                  </a>";
                    }  // all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
                    if ($existingVote[$id[$newNews]] > 0) { // makes a check to see whether the user has voted on the specified item
                        echo "
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'>
                  </a>";
                    } // all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
                    echo "
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class='vote_number'>
                                    <tr>
                                        <td> ";
                    // prints out the votes of the story being printed
                    echo " <div id=$divId class = 'common' >$votes[$justNews]</div> 
                    
                   
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
                                            <a href='$storyLink[$newNews]'>$name[$newNews]</a> ($views[$newNews] view(s)) 
                                        </td>
                                    </tr>
                                    <tr>
                                         <td class='story_description'>";
                    if ($description[$newNews] != "") { // Prints out the description and changes it if needed
                        echo "<a href='show_story.php?story=$id[$newNews]'>$description[$newNews]</a>";
                    } else {
                        echo "<a href='show_story.php?story=$id[$newNews]'>No Description</a>";
                    } // The code below prints out the number of comments for a specified story
                    echo "</td>
                                    </tr>
                                     <tr>
                                        <td>
                                            <a href='show_story.php?story=$id[$newNews]'>($commentNumber[$newNews] comments)</a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    ";
                    $justNews++;
                }
                echo "
                    <table class='change_page'>
                        <tr>
                            <td class='last_page'>";
                $prevPage = $pageNumber - 1;
                if ($pageNumber > 1) { // checks the page number that the user is currently on
                    echo "<a href='new_news.php?page=$prevPage'>Previous Page</a>";
                }
                echo "</td>
                            <td class='next_page'>";
                if ($pageNumber < $highestPage) {
                    $nextPage = $pageNumber + 1;
                    echo "<a href='new_news.php?page=$nextPage'>Next Page</a>";
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