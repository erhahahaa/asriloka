<?php
require_once('controller/token.php');
require_once('db.php');
function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['data']['role']) && $_SESSION['data']['role'] == "ADMIN")) {
        $token = $_COOKIE['token'];
        // $tokenConn = new TokenController();
        // $res = json_decode($tokenConn->verify($token, 'ADMIN'), true);
        // if (!$res['success']) {
        //     redirect('../index.php');
        // }
    }
}

function redirect($url)
{
    echo "<script>
    window.location.href='$url';
    </script>";
    exit;
}

function alert($type, $msg)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
}

function toast($type, $title, $msg)
{
    $svg = ($type == "success") ? "success" : "error";
    echo '<script> swalToast("' . $svg . '","' . $title . '","' . $msg . '"); </script>';
}

?>