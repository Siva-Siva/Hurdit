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
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in thhe database
                    "http://localhost/hurdit/includes/upvote_story.php?id="+myid,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                        var divId = parseInt(myid) + 50;
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
                $('a.common2').bind('click',function() // checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id'); //gathers the id of of the object that was clicked in the <a> tag
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
                    $("#" + (newmyid) + " img").attr("src","images/thumbup_gray.png"); // changes the voting image
                            $( "#" + divId).html(value2);} // prints out the final result to the browser
                    }
                )                   
                }
            )

                    $('a.commentup').bind('click',function() // checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id'); //gathers the id of of the object that was clicked in the <a> tag
                    var myid2 = $('a.common').attr('id');   
                    var newValue = parseInt(myid) + 1000;
                    
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in thhe database
                    "http://localhost/hurdit/includes/upvote_comment.php?id="+myid+"&storyID="+myid2,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                      
                        var divId = parseInt(myid) + 2000;
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

                   $('a.commentdown').bind('click',function()  // checks if the <a> tag which belongs to the class of common if clicked upon
                {
                    var myid = $(this).attr('id');//gathers the id of of the object that was clicked in the <a> tag       
                    var myid2 = $('a.common').attr('id');
                    var newValue = parseInt(myid)-1000;
                    
                    $.get( // sends the gathered id to the URL specified below to be processed and data to be changed in thhe database
                    "http://localhost/hurdit/includes/downvote_comment.php?id="+newValue+"&storyID="+myid2,
                    null,
                    function(data) { // this processes the data returned by the php script and prints out the appropriate results
                        var value = data;
                        var divID = parseInt(myid) + 1000;
                        if( value == 'log' ) {
                            alert ("You have to be logged on to rate stories");
                        }
                       else{
					    $( "#" + myid + " img").attr("src","images/thumbdown_red.png"); // changes the voting image 
						$( "#" + (newValue) + " img").attr("src","images/thumbup_gray.png"); // changes the voting image
                          $( "#" + divID).html(value);} // prints out the final result to the browser
                    }
                )
                }
            )
            }

        )
        </script>
    </head>
    <body>
        <table class="get_show_story_background">
            <tr>
                <td>
                    <table class="get_show_story_news">
                        <?php
                        include("includes/connect.php");
                        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                        session_start(); // starts a session with the required variables
                        $username = $_SESSION['username'];  // gets the username
                        $userID = $_SESSION['userID']; // gets the userid
                        $storyID = $_GET['story'];
                        $sort = $_GET['sort'];
                        $result = mysql_query("SELECT * FROM `story` WHERE id='$storyID'") or die("Error"); // selects all the stories in order of when it was submitted
                        while ($row = mysql_fetch_assoc($result)) { // gathers all the data from the database involving the story to be printed
                            $storyID = $row['id'];
                            $name = $row['name'];
                            $description = $row['description'];
                            $upVotes = $row['upVotes'];
                            $downVotes = $row['downVotes'];
                            $votes = $upVotes - $downVotes;
                            $storyUsername = $row['storyUsername'];
                            $views = $row['views'];
                            $storyLink = $row['storyLink'];
                        }
                        $views = $views +1; // updates the views of the story
                        mysql_query("UPDATE  `gwu`.`story` SET  `views` = $views where id = $storyID");
                        $query = "SELECT * FROM `users` WHERE id='$userID'";
                        $result = mysql_query($query);
                        while ($row = mysql_fetch_assoc($result)) { 
                            $userLevel = $row['userLevel'];
                        }
						//orders it by what the user wants it to be ordered by (the comments)
                        $fields = "`comments`.`id`, `comments`.`comment`, `users`.`username`, `comments`.`timeWritten`, `comments`.`upVotes`, `comments`.`downVotes`  FROM `users` , `comments` WHERE `comments`.`storyID` = '$storyID' AND `comments`.`userID` = `users`.`id`";
                        if ($sort == "oldest" || $sort == "") {
                            $query = "SELECT $fields";
                        } elseif ($sort == "newest") {
                            $query = "SELECT $fields ORDER BY `comments`.`id` DESC";
                        } elseif ($sort == "rating") {
                            $query = "SELECT $fields ORDER BY `comments`.`upVotes` - `comments`.`downVotes` DESC";
                        }
                        $result = mysql_query($query) or ("Error");
                        $commentNumber = 1;
                        while ($row = mysql_fetch_assoc($result)) { // gathers the data about the comments
                            $usernameDB[$commentNumber] = $row['username'];
                            $timeWrittenDB[$commentNumber] = $row['timeWritten'];
                            $commentUpVotesDB[$commentNumber] = $row['upVotes'];
                            $commentDownVotesDB[$commentNumber] = $row['downVotes'];
                            $comment[$commentNumber] = $row['comment'];
                            $commentID[$commentNumber] = $row['id'];
                            $commentVotesDB [$commentNumber] = $commentUpVotesDB[$commentNumber] - $commentDownVotesDB[$commentNumber];
                            $commentNumber++;
                        }
                        $commentNumber = mysql_num_rows($result);
                        $commentEnd = $commentNumber;                  
                        $imgid2 = $storyID+10;
                        $divId = $storyID +50;

                           $extractvotes = mysql_query("SELECT * FROM `storyvotes` WHERE `storyvotes`.`userID` = '$userID'") or die("Error");
				 while ($row = mysql_fetch_assoc($extractvotes)) {
				  $dbStoryID = $row['storyID'];
				  $existingVote [$dbStoryID] = $row['direction'];
				  }		
                        echo "
                            <td>
                                <table class='thumbs'>
                                    <tr>
                                        <td>
                                                    <a id = $storyID class = 'common'>";

											if ($existingVote[$storyID] == 0) // checks to see if the user has already voted on the specified story
											{
										echo "
                                 <img id= $storyID class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";} // assigns each story a unique id and class 
								 if ($existingVote[$storyID] > 0) // checks to see if the user has already voted on the specified story
											{
										echo "
                                 <img id= $storyID class = 'common' name=imgName border=0 src='images/thumbup_blue.png'";} // assigns each story a unique id and class 
								 if ($existingVote[$storyID] < 0) // checks to see if the user has already voted on the specified story
											{
										echo "
                                 <img id= $storyID class = 'common' name=imgName border=0 src='images/thumbup_gray.png'";} // assigns each story a unique id and class 

								echo "
                                 </a >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          ";
										if ($existingVote[$storyID] == 0) // checks to see if the user has already voted on the specified story
									{									
									echo "
                                            <a id = $imgid2 class = 'common2'>
                 <img id=$imgid2 class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'> 
                  </a>";}// assigns each story a unique id and class
				  					if ($existingVote[$storyID] < 0) // checks to see if the user has already voted on the specified story
									{
									echo "
                                            <a id = $imgid2 class = 'common2'>
                 <img id=$imgid2 class = 'common2' name=imgName2 border=0 src='images/thumbdown_red.png'>
                  </a>";} // assigns each story a unique id and class
				  					if ($existingVote[$storyID] > 0) // checks to see if the user has already voted on the specified story
									{
									echo "
                                            <a id = $imgid2 class = 'common2'>
                 <img id=$imgid2 class = 'common2' name=imgName2 border=0 src='images/thumbdown_gray.png'>
                  </a>";} // assigns each story a unique id and class
				//prints out the number of votes for the specified story
				echo "
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class='vote_number'>
                                    <tr>
                                        <td>
                                         <div id=$divId class = 'common' >$votes</div>
                                        </td>
                                    </tr>
                                </table>
                            </td>";
                        echo "
                            <td>
                                <table>
                                    <tr>
                                        <td>
                                            <img src='images/preview.png'>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td>
                                <table class='story'>
                                    <tr>
                                        <td class='story_title'>
                                            <a href='$storyLink'>$name</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='story_description'>";
                     //prints or changes the story description
					 if ($description != "") {
                            echo "$description";
                        } else {
                            echo "No Description";
                        }
                        echo "</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            ($commentNumber comments)
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    ";         
//allows users to add comments to a story					
					if (isset($userID)) {
                            echo "    <tr>
                                        <td colspan='4'>
                                            <form method='POST' action='submit_comment.php'>
                                                <table class='submit_comment'>
                                                    <tr>
                                                        <td class='submit_comment_text'>
                                                            New Comment:
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <textarea rows='3' cols='110' name='comment'/></textarea>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class='submit_comment_button'>
                                                            <input type='hidden' name='storyID' value='$storyID'>
                                                            <input type='submit' value='Submit' name='submit' />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </td>
                                    </tr>";
                        }
                        if ($commentNumber > 0) {
                            echo "
                            <tr>
                            <td>
                                Sort By:
                            </td>
                            <td colspan=3>
                                <a href='show_story.php?story=$storyID&sort=oldest'>Oldest</a> | <a href='show_story.php?story=$storyID&sort=newest'>Newest</a> | <a href='show_story.php?story=$storyID&sort=rating'>Rating</a>
                            </td>
                        </tr>
                      <tr>";
                        }
                        
                         $extractvotes2 = mysql_query("SELECT * FROM `commentvotes` WHERE `commentvotes`.`userID` = '$userID' AND `storyID` = '$storyID'") or die("Error");
				 while ($row = mysql_fetch_assoc($extractvotes2)) {
				  $dbcommentID = $row['commentID'];
				  $existingVote2 [$dbcommentID] = $row['direction'];
				  }
                        for ($commentNumber = 1; $commentNumber <= $commentEnd; $commentNumber++) {
                            if ($commentNumber == 1) {                               
                           }
                            $commentNumber2 = $commentNumber + 1000;
                            $divID = $commentNumber + 2000;
                           // assigns each comment with a specific id and class
                            echo "    <tr>
                                                <td>
                                                    <table class='thumbs'>
                                                        <tr>
                                                            <td>
                                                               <a id = $commentNumber class = 'commentup'>

											
                                 <img id= $commentNumber class = 'commentup' name=imgName border=0 src='images/thumbup_gray.png' >
								                              </a >";
                            // assigns each comment with a specific id and class
                            echo "
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <a id = $commentNumber2 class = 'commentdown'>								
                                 <img id= $commentNumber2 class = 'commentdown' name=imgName border=0 src='images/thumbdown_gray.png'>	
                                 </a >"; echo "
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan='4'>
                                                    <table class='comment'>
                                                        <tr>
                                                            <td colspan='4'>
                                                                $usernameDB[$commentNumber] (<a id = $divID class = commentdown>$commentVotesDB[$commentNumber]</a> point(s)) submitted at: $timeWrittenDB[$commentNumber]";
                            if ($userLevel >= 2 || $username == $usernameDB[$commentNumber]) {
                                echo " | <a href='edit_comment.php?storyID=$storyID&commentID=$commentID[$commentNumber]'>edit</a> | <a href='delete_comment.php?storyID=$storyID&commentID=$commentID[$commentNumber]'>delete</a>";
                            }
                            echo "
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                $comment[$commentNumber]
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>";
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>