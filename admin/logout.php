<?php
require '../lib/essentials.php';
require '../app/config/config.php';
session_start();
session_destroy();
$home = BASEURL . '/index.php';
redirect($home);
?>