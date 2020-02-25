<?php
    $page = $_SERVER["REQUEST_URI"]; //URL of a visited page
    preg_match('/[^\/]+$/', $page, $pageScript);
    
    echo "$pageScript[0]" . "a";
?>