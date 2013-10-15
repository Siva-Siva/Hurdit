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
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);
                    include("includes/connect.php");
                    include("includes/banner.php");
                    echo "<br>";
                    if (isset($username)) {
                        //gets the info for the user log in
                        $result = mysql_query("SELECT * FROM users WHERE username = '$username'") or die("Error");
                        while ($row = mysql_fetch_assoc($result)) {
                            $passwordDb = $row['password'];
                            $userID = $row['id'];
                            $banned = $row['banned'];
                        }
                        if ($password == $passwordDb) {
                            //makes sure you are not banned
                            if ($banned == 0) {
                                $_SESSION['username'] = $username;
                                $_SESSION['userID'] = $userID;
                                //if you are not banned, sets session, and then redirects you do the main page (popular news)
                                echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
                            } else {
                                echo "You have been banned. You cannot login until the ban is revoked.";
                            }
                        } else {
                            echo "Login Failed.";
                        }
                    }
                    //gets the login info
                    echo "
                        <form action='login.php' method='POST'>
                            <table>
                                <tr>
                                    <td>
                                        Username
                                    </td>
                                    <td>
                                        <input type='text' name='username'   />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Password
                                    </td>
                                    <td>
                                        <input type='password' name='password' />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type='submit' value='Submit' />
                                    </td>
                                </tr>
                            </table>
                        </form>
                        ";
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
