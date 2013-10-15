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
                    include("includes/connect.php");
                    //gets the info for the registration
                    $username = $_POST['username'];
                    $password = md5($_POST['password']);
                    $passwordAgain = md5($_POST['passwordAgain']);
                    $gender = $_POST['gender'];
                    include("includes/banner.php");
                    //checks to make sure the user does not already exist
                    $query = "SELECT `id` FROM `users` where `username` = '$username'";
                    $result = mysql_query($query);
                    $existingAccount = mysql_num_rows($result);
                    if ($existingAccount < 1) {
                        //checks to make sure that the passwords 
                        if ($username != "" && $password == $passwordAgain) {
                            require 'includes/profanity_filter.php';
                            $query = "INSERT INTO `gwu`.`users` (`id`, `username`, `password`, `timeJoined`, `banned`, `banUntil`, `userLevel`, `gender`, `displayPicture`) VALUES (NULL, '$username', '$password', CURRENT_TIMESTAMP, '0', NULL, '1', '$gender', 'images/profile_pic_small.png')";
                            mysql_query($query) or die("error");
                            $result = mysql_query("SELECT * FROM users WHERE username = '$username'") or die("Error");
                            echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
                        } else {
                            if ($password != $passwordAgain) {
                                echo "Passwords do not match";
                            }
                        }
                    } else {
                        //if the username is already taken
                        if (isset($username)) {
                            echo "The username is already taken.";
                            unset($username);
                            unset($password);
                            unset($passwordAgain);
                            unset($gender);
                        }
                    }
                    if (!isset($username)) {
                        //gets the info for the registration
                        echo "
                            <form action='register.php' method='POST'>
                                <table>
                                    <tr>
                                        <td>
                                            Username
                                        </td>
                                        <td>
                                            <input type='text' name='username' />
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
                                            Re-Type Password
                                        </td>
                                        <td>
                                            <input type='password' name='passwordAgain' />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Gender
                                        </td>
                                        <td>
                                            <select name='gender'>
                                                <option value='m'>Male</option>
                                                <option value='f'>Female</option>
                                            </select>
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
                    }
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>