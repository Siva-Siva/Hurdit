<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css" />
        <title></title>
    </head>
    <body>
        <div class="footer">
            <hr>
            <table width="90%" align="center">
                <tr>
                    <td>
                        &copy; Hurdit 2011    
                    </td>
                    <td align="right">
                        <?php
                        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                        session_start();
                        $userID = $_SESSION['userID'];
                        include("includes/connect.php");
                        $query = "SELECT `userLevel` FROM `users` WHERE `id` = '$userID'";
                        $result = mysql_query($query);
                        while ($row = mysql_fetch_assoc($result)) {
                            $userLevel = $row['userLevel'];
                        }
                        if ($userLevel >= 3) {
                            echo "<a href='admin.php'>Admin Options</a>";
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
