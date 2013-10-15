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
                    //shows the story info and comments
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    session_start();
                    include("includes/connect.php");
                    include("includes/banner.php");
                    echo "<br>";
                    include("includes/get_show_story.php");
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>
