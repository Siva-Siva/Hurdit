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
                    //gets the top news
                    error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
                    include("includes/banner.php");
                    include("includes/top_news_select.php");
                    echo "<br>";
                    include("includes/get_top_news.php");
                    include("includes/footer.php");
                    ?>
                </td>
            </tr>
        </table>
    </body>
</html>