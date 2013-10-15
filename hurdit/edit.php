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

                    $huh = $_GET['huh'];
                    $oldp = $_GET['oldp'];
                    $newp = $_GET['newp'];
                    $newp2 = $_GET['newp2'];
                    $gender = $_GET['gender'];
                    if ($huh == "yes" && !(ctype_alnum($oldp) || ctype_alnum($newp) || ctype_alnum($newp2))) {
                        die("Password must be alphanumeric.");
                    }
                    //main page (popular news)
                    include("includes/connect.php");
                    include("includes/banner.php");
                    echo "<br>";
                    $user = $_SESSION['username'];
                    $change = $_GET['what'];
                    $queryChange = "SELECT * FROM users WHERE username = '$username'";
                    $result = mysql_query($queryChange) or die('Query Failed 1');
                    while ($row = mysql_fetch_array($result)) {
                        $oldPicture = $row['username'];
                        $oldPassword = $row['password'];
                        $oldSex = $row['gender'];
                    }
                    if ($huh == "yes") {
                        if (isset($oldp) && isset($newp) && isset($newp2)) {
                            if ($newp == $newp2) {
                                $newPass = md5($newp);
                                $query = "UPDATE `gwu`.`users` SET `password` = '$newPass' WHERE `users`.`username` ='$user'";
                                mysql_query($query) or die('ERROR');
                                echo "<br><center>Password has been changed.<Br><a href=profile.php>Click here to go back to profile.</a></center>";
                            }
                        }

                        if (isset($gender)) {
                            $query = "UPDATE `gwu`.`users` SET `gender` = '$gender' WHERE `users`.`username` ='$user'";
                            mysql_query($query) or die('ERROR');
                            echo "<br><center>Password has been changed.<Br><a href=profile.php>Click here to go back to profile.</a></center>";
                        }
                        if (!(isset($oldp) || isset($newp) || isset($newp2) || isset($gender))) {
                            echo "<br><center>Please Try Again.<Br><a href=profile.php>Click here to go back to profile.</a></center>";
                        }
                    }


                    if ($huh == "no") {
                        if ($change == "password") {
                            echo "<form method=GET action=edit.php?what=password&huh=yes >";
                            echo "<table width=500 align=center bgcolor=#509AD9>";
                            echo "<tr>";
                            echo "<td width=200 align=right>Old Password :</td>";
                            echo "<td width=200><input type=password width=100 name=oldp id=oldp ></td>";
                            echo "</tr><tr>";
                            echo "<td align=right width=200>New Password :</td>";
                            echo "<td width=150><input type=password width=100 name=newp id=newp ></td>";
                            echo "</tr><tr>";
                            echo "<td align=right width=200>Re-Enter New Password :</td>";
                            echo "<td width=200><input type=password width=100 name=newp2 id=newp2 ></td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td colspan=2 align=center><input type=hidden name=huh id=huh value=yes><input type=submit value=Change></td>";
                            echo "</tr>";
                            echo "</table>";
                            echo "</form>";
                        }
                        if ($change == "sex") {
                            echo "<form method=get action=edit.php?what=sex&huh=yes>";
                            echo "<table align=center bgcolor=#509AD9 width=200>";
                            echo "<tr>";
                            echo "<td width=100 align=right>New Sex</td>";
                            echo "<td width=100>";
                            echo "<select name='gender'>";
                            echo "<option value='m'>Male</option>";
                            echo "<option value='f'>Female</option>";
                            echo "</select>";
                            echo "</td>";
                            echo "</tr>";
                            echo "<td colspan=2 align=center><input type=hidden name=huh id=huh value=yes><input type=submit value=Change></td>";
                            echo "</table>";
                        }
                    }
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
