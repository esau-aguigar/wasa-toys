<?php
session_start();
session_destroy();
echo "<script>alert('Session Cerrada'); </script>";
echo '<meta http-equiv="refresh" content="0; url=./index.html">';
?>