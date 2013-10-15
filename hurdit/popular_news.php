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
                    var newValue = parseInt(myid) + 1000;

                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in the database
                    "http://localhost/hurdit/includes/upvote_story.php?id="+myid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                        var divId = parseInt(myid) + 5000;
                        if( value == 'log' ) {
                            alert ("You have to be logged on to rate stories");
                        }
                        else{
						                    $( "#" + myid + " img").attr("src","images/thumbup_blue.png"); // changes the voting image
                    $( "#" + (newValue) + " img").attr("src","images/thumbdown_gray.png"); // changes the voting image
                            $( "#" + divId).html(value);} // prints out the final result to the browser
                    }
                )
                }
            )
                $('a.common2').bind('click',function()// checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id');  //gathers the id of of the object that was clicked in the <a> tag

                    var newmyid = myid -1000;
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in the database
                    "http://localhost/hurdit/includes/downvote_story.php?id="+newmyid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results

                        var value2 = data;

                        var divId = parseInt(myid) + 4000;

                        if( value2 == 'log' ) {
                            alert ("You have to be logged on to rate stories");
                        }
                        else{
						$("#" + myid + " img").attr("src","images/thumbdown_red.png"); // changes the voting image
                    $("#" + (myid-1000) + " img").attr("src","images/thumbup_gray.png"); // changes the voting image
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
                 $extractvotes3 = mysql_query("SELECT * FROM `storyvotes` WHERE `storyvotes`.`userID` = '$userID'") or die("Error");
				 while ($row = mysql_fetch_assoc($extractvotes3)) { // gathers voting data on the stories being printed out
				  $dbStoryID = $row['storyID'];
				  $existingVote [$dbStoryID] = $row['direction'];
				  }
                                  
                for ($popularNews = 1; $popularNews < $storyEnd; $popularNews++) {
                $oldNews = $id[$popularNews] + 1000;
                    $divId = $id[$popularNews] + 5000;
                     echo "
                      <tr>
                            <td>
                                <table class='thumbs'>
                                    <tr>
                                        <td>
                                            <a id = $id[$popularNews] class = 'common'>";

											if ($existingVote[$id[$popularNews]] == 0) // makes a check to see whether the user has voted on the specified item
											{
										echo "
                                 <img id= $id[$popularNews] class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";}// all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
								 if ($existingVote[$id[$popularNews]] > 0) // makes a check to see whether the user has voted on the specified item
											{
										echo "
                                 <img id= $id[$popularNews] class = 'common' name=imgName border=0 src='images/thumbup_blue.png'";}// all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
								 if ($existingVote[$id[$popularNews]] < 0) // makes a check to see whether the user has voted on the specified item
											{
										echo "
                                 <img id= $id[$popularNews] class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";}// all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript

								echo "
                                 </a >
                                 </td>
                                <td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>";
										if ($existingVote[$id[$popularNews]] == 0) // makes a check to see whether the user has voted on the specified item
									{
									echo "
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'>
                  </a>";}
				  					if ($existingVote[$id[$popularNews]] < 0) // makes a check to see whether the user has voted on the specified item
									{
									echo "
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_red.png'>
                  </a>";}
				  					if ($existingVote[$id[$popularNews]] > 0) // makes a check to see whether the user has voted on the specified item
									{
									echo "
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'>
                  </a>";}
				  echo "
                                        </td>
                                    </tr>
                                </table>
                            </td>
                       <td>
                                <table class='vote_number'>
                                    <tr>
                                        <td> ";
                    echo " <div id=$divId class = 'common' >$votes[$popularNews]</div>


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