<?php
session_start();
session_destroy();
//destroys all the sessions and redirects you do the main page
echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php'>";
?>
