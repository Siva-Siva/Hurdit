<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title>Hurdit</title>
    </head>
    <body>
        <table border=0 class="banner" width=1000>
            <tr>
                <td width=200>
                    <a href="index.php"><img src="images/logo_small.png" border="0" /></a>
                </td>
                <td width=800 valign="bottom">
					<OL>
					<div class="banner_CSS">
                    <li><a href="top_news_body.php?filter=1">Top</a></li>
           
                
                    <li><a href="new_news.php">New</a></li>
                
                    <?php
                    session_start();
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    if (isset($_SESSION['username'])) {
                       
                        echo "<li><a href='hurd_news.php'>Hurd News</a></li>";
                        
                    }
                    ?>
                    <?php
                    session_start();
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    if (isset($_SESSION['username'])) {
                        
                        echo "<li><a href='submit_story.php'>Submit</a></li>";
                        
                    }
                    ?>
                <?php
                    session_start();
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    if (isset($_SESSION['username'])) {
                        
                        echo "<li><a href='profile.php'>Profile</a></li>";
                        echo "<li><a href='search.php'>Search</a></li>";
                        echo "<li><a href='logout.php'>Logout</a></li>";
                       
                    } else {
                        
                        echo "<li><a href='login.php'>Login</a></li>";
                       echo " ";
                        echo "<li><a href='register.php'>Register</a></li>";
                       
                    }
                ?>
					</div>
				<OL>
            </tr>
        </table>
    </body>
</html>
