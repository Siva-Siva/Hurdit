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
            //$("#myImage").attr("src", "path/to/newImage.jpg");
        </script>
    </head>
    <body>
        <table class="top_news_background">
            <table class="get_top_news">
                <?php
                include("includes/connect.php");
                error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                session_start();
                $filter = $_GET['filter'];

                //time periods stated
                $today = mktime(date('H'), date('i'), date('s'), date("m"), date("d") - 1, date("y"));
                $lastWeek = mktime(date('H'), date('i'), date('s'), date("m"), date("d") - 7, date("y"));
                $last30Days = mktime(date('H'), date('i'), date('s'), date("m"), date("d") - 30, date("y"));
                $last365Days = mktime(date('H'), date('i'), date('s'), date("m"), date("d") - 365, date("y"));

                //get page number
                $pageNumber = $_GET['page'];
                if (!isset($pageNumber)) {
                    $pageNumber = 1;
                }
                //starts session
                $username = $_SESSION['username'];
                $userID = $_SESSION['userID'];
                for ($topNews = 1; $topNews <= 10; $topNews++) {
                    $name[$topNews] = "No Title";
                    $description[$topNews] = "No Description";
                    $commentNumber[$topNews] = 0;
                    $votes[$topNews] = 0;
                }
                //gets total number of rows in table
                $extract = mysql_query("SELECT * FROM `story` ORDER BY `upVotes` - `downVotes` DESC") or die("Error");
                $storyStart = ($pageNumber - 1) * 10;

                // cases for the filters and getting information properly
                switch ($filter) {
                    case 1:
                        $date = date('y-m-d H:i:s', $today);
                        $extract = mysql_query("SELECT * FROM `story` WHERE timeSubmitted > '$date' ORDER BY `upVotes` - `downVotes` DESC LIMIT $storyStart,10") or die("Error with Date");
                        $totalStories = mysql_num_rows($extract);
                        $highestPage = ((int) (($totalStories) / 10)) + 1;
                        break;
                    case 7:
                        $date = date('y-m-d H:i:s', $lastWeek);
                        $extract = mysql_query("SELECT * FROM `story` WHERE 'timeSubmitted' > '$date' ORDER BY `upVotes` - `downVotes` DESC LIMIT $storyStart,10") or die("Error with Date");
                        $totalStories = mysql_num_rows($extract);
                        $highestPage = ((int) (($totalStories) / 10)) + 1;
                        break;
                    case 30:
                        $date = date('y-m-d H:i:s', $last30Days);
                        $extract = mysql_query("SELECT * FROM `story` WHERE 'timeSubmitted' > '$date' ORDER BY `upVotes` - `downVotes` DESC LIMIT $storyStart,10") or die("Error with Date");
                        $totalStories = mysql_num_rows($extract);
                        $highestPage = ((int) (($totalStories) / 10)) + 1;
                        break;
                    case 365:
                        $date = date('y-m-d H:i:s', $last365Days);
                        $extract = mysql_query("SELECT * FROM `story` WHERE 'timeSubmitted' > '$date' ORDER BY `upVotes` - `downVotes` DESC LIMIT $storyStart,10") or die("Error with Date");
                        $totalStories = mysql_num_rows($extract);
                        $highestPage = ((int) (($totalStories) / 10)) + 1;
                        break;
                    default:
                        $extract = mysql_query("SELECT * FROM `story` ORDER BY `upVotes` - `downVotes` DESC LIMIT $storyStart,10") or die("Error");
                        $totalStories = mysql_num_rows($extract);
                        $highestPage = ((int) (($totalStories) / 10)) + 1;
                }
                if ($totalStories == 0) {
                    echo "No news to show.";
                }
                $topNews = 1;
                while ($row = mysql_fetch_assoc($extract)) { //gathers all the required data in relation to the stories being printed out
                    $id[$topNews] = $row['id'];
                    $name[$topNews] = $row['name'];
                    $description[$topNews] = $row['description'];
                    $upVotes[$topNews] = $row['upVotes'];
                    $downVotes[$topNews] = $row['downVotes'];
                    $votes[$topNews] = $upVotes[$topNews] - $downVotes[$topNews];
                    $storyUsername[$topNews] = $row['storyUsername'];
                    $views[$topNews] = $row['views'];
                    $storyLink[$topNews] = $row['storyLink'];
                    $timeSubmitted[$topNews] = $row['timeSubmitted'];
                    $query = "SELECT * FROM `comments` WHERE `comments`.`storyID` = $id[$topNews]";
                    $result = mysql_query($query);
                    $commentNumber[$topNews] = mysql_num_rows($result);
                    $topNews++;
                }
				 $extractvotes = mysql_query("SELECT * FROM `storyvotes` WHERE `storyvotes`.`userID` = '$userID'") or die("Error");
				 while ($row = mysql_fetch_assoc($extractvotes)) { // gathers voting data on the stories being printed out
				  $dbStoryID = $row['storyID'];
				  $existingVote [$dbStoryID] = $row['direction'];		  
				  }				
				 $storyEnd = ($topNews);
				 $justNews=1;   
                for ($newNews = 1; $newNews < $storyEnd; $newNews++) { // prints out the stories
                    $oldNews = $id[$newNews] + 1000;
                    $divId = $id[$newNews] + 5000;
                     echo "
                      <tr>
                            <td>
                                <table class='thumbs'>
                                    <tr>
                                        <td>
                                            <a id = $id[$newNews] class = 'common'>";
											
											if ($existingVote[$id[$newNews]] == 0) // makes a check to see whether the user has voted on the specified item
											{
										echo "										
                                 <img id= $id[$newNews] class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";}// all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
								 if ($existingVote[$id[$newNews]] > 0) // makes a check to see whether the user has voted on the specified item
											{
										echo "										
                                 <img id= $id[$newNews] class = 'common' name=imgName border=0 src='images/thumbup_blue.png'";}// all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
								 if ($existingVote[$id[$newNews]] < 0) // makes a check to see whether the user has voted on the specified item
											{
										echo "										
                                 <img id= $id[$newNews] class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";}// all items carry a unique id and belong to a specific class so that it can be manipulated by the javascript
								
								echo "							 
                                 </a >
                                 </td>
                                <td>                       
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>";
										if ($existingVote[$id[$newNews]] == 0) // makes a check to see whether the user has voted on the specified item
									{
									echo "											
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'>
                  </a>";}
				  					if ($existingVote[$id[$newNews]] < 0) // makes a check to see whether the user has voted on the specified item
									{
									echo "											
                                            <a id = $oldNews class = 'common2'>
                 <img id=$oldNews class = 'common2' name=imgName2 border=0 src='images/thumbdown_red.png'>
                  </a>";}
				  					if ($existingVote[$id[$newNews]] > 0) // makes a check to see whether the user has voted on the specified item
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
                                            <a href='$storyLink[$newNews]'>$name[$justNews]</a> ($views[$newNews] view(s))
                                        </td>
                                    </tr>
                                    <tr>
                                         <td class='story_description'>";
                    if ($description[$newNews] != "") {
                        echo "<a href='show_story.php?story=$id[$newNews]'>$description[$newNews]</a>";
                    } else {
                        echo "<a href='show_story.php?story=$id[$newNews]'>No Description</a>";
                    }
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
                if ($pageNumber > 1) {
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