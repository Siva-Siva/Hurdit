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
                    //Gets variables to know either to ban, unban, or promote
                    session_start();
                    $userID = $_SESSION['userID'];
                    $banUser = $_POST['ban'];
                    $unbanUser = $_POST['unban'];
                    $promoteUser = $_POST['promote'];
                    $promotion = $_POST['promotion'];
                    include("includes/connect.php");
                    include("includes/banner.php");
                    echo "<br>";
                    //Checks to make sure that the person accessing the code has a user level of 3 or up
                    $query = "SELECT * FROM `users` WHERE `id` = $userID";
                    $result = mysql_query($query) or die("Error");
                    while ($row = mysql_fetch_assoc($result)) {
                        $userLevel = $row['userLevel'];
                    }
                    if ($userLevel > 2) {
                        //bans the user
                        if (isset($banUser)) {
                            $query = "SELECT `id` FROM `users` WHERE `username` = '$banUser'";
                            $result = mysql_query($query) or die("Error");
                            $numrows = mysql_num_rows($result);
                            if ($numrows > 0) {
                                $query = "SELECT `userLevel` FROM `users` WHERE `username` = '$banUser'";
                                $result = mysql_query($query);
                                while ($row = mysql_fetch_assoc($result)) {
                                    $userLevel = $row['userLevel'];
                                }
                                if ($userLevel == 4) {
                                    echo "Users of user level 4 cannot be banned.";
                                } else {
                                    $query = "UPDATE `users` SET banned='1' WHERE `username` = '$banUser'";
                                    mysql_query($query);
                                    echo "User $banUser has been banned.";
                                }
                            } else {
                                echo "Username cannot be found.";
                            }
                        }
                        //unbans the user
                        if (isset($unbanUser)) {
                            $query = "SELECT `id` FROM `users` WHERE `username` = '$unbanUser'";
                            $result = mysql_query($query) or die("Error");
                            $numrows = mysql_num_rows($result);
                            if ($numrows > 0) {
                                $query = "UPDATE `users` SET banned='0' WHERE `username` = '$unbanUser'";
                                mysql_query($query);
                                echo "User $unbanUser has been unbanned.";
                            } else {
                                echo "Username cannot be found.";
                            }
                        }
                        //promotes the user
                        if (isset($promoteUser)) {
                            $query = "SELECT `id` FROM `users` WHERE `username` = '$promoteUser'";
                            $result = mysql_query($query) or die("Error");
                            $numrows = mysql_num_rows($result);
                            if ($numrows > 0) {
                                $query = "SELECT * FROM `users` WHERE `username` = '$promoteUser'";
                                $result = mysql_query($query) or die("Error");
                                while ($row = mysql_fetch_assoc($result)) {
                                    $userLevel = $row['userLevel'];
                                }
                                if ($userLevel < $promotion) {
                                    if ($promotion == 2) {
                                        $query = "UPDATE `users` SET userLevel='2' WHERE `username` = '$promoteUser'";
                                    }
                                    if ($promotion == 3) {
                                        $query = "UPDATE `users` SET userLevel='3' WHERE `username` = '$promoteUser'";
                                    }
                                    mysql_query($query) or die("Error");
                                    echo "User $promoteUser has been promoted to user level $promotion.";
                                } else {
                                    echo "User is already at the same or a higher level";
                                }
                            } else {
                                echo "Username cannot be found.";
                            }
                        }
                        echo "<h1>Admin Options</h1>";
                        echo "
                                <form action='admin.php' method='POST'>
                                    <table>
                                        <tr>
                                            <td>
                                                Ban User
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Enter username: <input type='text' name='ban'/>
                                            </td>
                                            <td>
                                                <input type='submit' value='Ban User'/>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <form action='admin.php' method='POST'>
                                    <table>
                                        <tr>
                                            <td>
                                                Unban User
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Enter username: <input type='text' name='unban'/>
                                            </td>
                                            <td>
                                                <input type='submit' value='Unban User'/>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                <form action='admin.php' method='POST'>
                                    <table>
                                        <tr>
                                            <td>
                                                Promote User
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Enter username: <input type='text' name='promote'/>
                                            </td>
                                            <td>
                                                <select name='promotion'>
                                                    <option value=2>Moderator</option>
                                                    <option value=3>Admin</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type='submit' value='Promote User'/>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                    ";
                    } else {
                        //if the user level is 2 or under
                        echo "No permission to view this page";
                    }
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>