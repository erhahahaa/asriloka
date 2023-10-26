<?php
session_start();
// unset($_SESSION['data']);
session_destroy();
// header('location: /index');
require './lib/essentials.php';
redirect('index');
?>