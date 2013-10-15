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
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    session_start();
                    $search = $_GET['search'];
                    include("includes/connect.php");
                    include("includes/banner.php");
                    echo "<br>";
                    if (isset($search)) {
                        if (is_numeric($search)) {
                            $query = "SELECT * FROM `users` WHERE `id` = $search";
                            $exists = mysql_num_rows($result);
                            if ($exists == 0) {
                                die("No results match this query.");
                            }
                            $result = mysql_query($query) or die("Error");
                            while ($row = mysql_fetch_assoc($result)) {
                                $id = $row['id'];
                                $username = $row['username'];
                                $gender = $row['gender'];
                            }
                            echo "<table width=500 border=1>";
                            echo "<tr>";
                            echo "<td rowspan=2><img src=display_personal.php></td>";
                            echo "<td>$username</td>";
                            echo "<td>$gender</td>";
                            echo "</tr>";
                            echo "</table>";
                        } else {
                            $query = "SELECT * FROM `users` WHERE `username` = '$search'";
                            $result = mysql_query($query) or die("Error");
                            $exists = mysql_num_rows($result);
                            if ($exists == 0) {
                                die("No results match this query.");
                            }
                            $result = mysql_query($query) or die("Error");
                            while ($row = mysql_fetch_assoc($result)) {
                                $id = $row['id'];
                                $username = $row['username'];
                                $gender = $row['gender'];
                            }
                            
                            if ($gender == "m") {
                                $gender = "Male";
                            }
                            if ($gender == "f") {
                                $gender = "female";
                            }
                            
                            echo "<table width=500 border=0 align=center bgcolor=#509AD9>";
                            echo "<tr>";
                            echo "<td valign=center><a href=profile.php?uid=$id>$username</a></td>";
                            echo "<td valign=center>$gender</td>";
                            echo "</tr>";
                            echo "</table>";
                        }
                    } else {
                        echo"
                    <table align=center>
                        <tr>
                            <td align='center'>
                                Enter username or id to search:
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form action='search.php' method='GET'>
                                    <br><center><input type=text size=25 id=search name=search width=100></center>
                                    <br><center><input type=submit value=Search></center>
                                </form>
                            </td>
                        </tr>
                    </table>";
                    }
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
