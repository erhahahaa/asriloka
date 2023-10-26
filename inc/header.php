<?php
session_start();
require 'app/config/config.php';
require 'app/core/Database.php';
require 'app/model/Facility.php';
require 'app/model/Capacity.php';
require 'app/model/Picture.php';
require 'app/model/Rule.php';
require 'app/model/Room.php';
require 'app/model/User.php';


require('././debug/logger.php');
require './lib/controller/auth.php';
require './lib/essentials.php';
$auth = new AuthController();
$user = new User();
if (isset($_POST['user_register'])) {
    $data = filteration($_POST);
    if ($data['password'] != $data['confirm_password']) {
        echo alert('error', 'Password and Confirm Password must be same');
    }
    if (empty($data['dob']) || $data['dob'] > date('Y-m-d')) {
        echo alert('error', 'Invalid Date of Birth');
    }

    $res = $auth->register($data, $_FILES['picture']);
    $json = json_decode($res, true);
    logger($res);

    header('url=index');

    if ($json['success'] == true) {
        $_SESSION["sukses"] = 'Registrasi Berhasil';
    } else {
        $_SESSION["gagal"] = $json['message'];
    }

}

if (isset($_POST['user_login'])) {
    $res = $user->login($_POST);
    $json = json_decode($res, true);

    if ($json['success'] == false) {
        $_SESSION["gagal"] = $json['message'];
    } else {
        $_SESSION["sukses"] = $json['message'];
    }
    if ($json['success'] == true && $json['data']['role'] == 'ADMIN') {
        redirect('admin/dashboard');
    }

}

?>
<nav class=" navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid ">
        <a class="navbar-brand me-5" href="index">

            <img width=20% src="./assets/images/logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon "></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active me-2" aria-current="page" href="index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2" aria-current="page" href="fasilitas">Fasilitas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2" aria-current="page" href="ketentuan">Ketentuan</a>
                </li>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Reservasi
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="rooms">Penginapan</a></li>
                        <li><a class="dropdown-item" href="pktLDK">Paket LDK</a></li>
                        <li><a class="dropdown-item" href="pktPerusahaan">Paket Perusahaan</a></li>
                        <li><a class="dropdown-item" href="pktCamp">Paket Camp</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active me-2" aria-current="page" href="pemesanan">Pemesanan</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                // session_start(); 
                $user = '';
                if (isset($_SESSION['data'])) {
                    $user = $_SESSION['data'];
                }
                if (!empty($user)) {
                    echo "<a href='logout' class='btn btn-outline-dark shadow-none me-lg-2 me-3'>Logout</a>";
                } else {
                    echo "<button type='button' class='btn btn-outline-dark shadow-none me-lg-3 me-2' data-bs-toggle='modal' data-bs-target='#loginModal'>Login</button>";
                    echo "<button type='button' class='btn btn-outline-dark shadow-none me-lg-2 me-3' data-bs-toggle='modal' data-bs-target='#registerModal'>Register</button>";
                }
                ?>

            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-item-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i>User Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="phone" class="form-control shadow-none" name="phone" id="phone" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control shadow-none" name="password" id="password" required>
                    </div>
                    <div class="d-flex align-item-center justify-content-between mb-2">
                        <button name="user_login" type="submit" class="btn btn-dark shadow-none">LOGIN</button>
                        <a href="javascript: void(0)" class="text-scondary text-decoration-none">Forgot
                            Password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-item-center">
                        <i class="bi bi-person-fill fs-3 me-2"></i>User Registration
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">Note : Your details
                        must match with your ID</span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 ps-0 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" name="name" type="text" class="form-control shadow-none" required>
                            </div>
                            <!-- <div class="col-md-6 p-0">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" name="email" type="email" class="form-control shadow-none" required>
                            </div> -->
                            <div class="col-md-6 ps-0 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input id="phone" name="phone" type="number" class="form-control shadow-none required">
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label for="picture" class="form-label">Picture</label>
                                <input id="picture" name="picture" type="file" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label for="dob" class="form-label">Date of birth</label>
                                <input id="dob" name="dob" type="date" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" name="password" type="password" class="form-control shadow-none"
                                    required>
                            </div>
                            <div class="col-md-6 ps-0 mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input id="confirm_password" name="confirm_password" type="password"
                                    class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 p-0 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea id="address" name="address" class="form-control shadow-none" rows="3"
                                    required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-1">
                        <button name="user_register" type="submit" class="btn btn-dark shadow-none">REGISTER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>