<?php

require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'pembayaran') {

    $data = $_POST;
    $user = $data['user_id'];
    $room = $data['room_id'];
    $payment = $data['payment_method'];
    $check_in = $data['check_in'];
    $check_out = $data['check_out'];
    $hari = (strtotime($check_out) - strtotime($check_in)) / 86400;

    $conn = $GLOBALS['conn'];
    $sql = "SELECT * FROM user WHERE id = $user";
    $res = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($res);
    unset($user['password']);

    $sql = "SELECT * FROM booking WHERE roomId = $room";
    $res = mysqli_query($conn, $sql);
    $bookings = mysqli_fetch_all($res, MYSQLI_ASSOC);

    if ($check_in > $check_out) {
        echo json_encode([
            'status' => 'failed',
            'message' => 'Tanggal check-in tidak boleh lebih besar dari tanggal check-out'
        ]);
        die();
    }

    foreach ($bookings as $booking) {
        if ($check_in >= $booking['checkIn'] && $check_in < $booking['checkOut']) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Maaf kamar sudah dipesan pada tanggal tersebut'
            ]);
            die();
        }

        if ($check_out > $booking['checkIn'] && $check_out <= $booking['checkOut']) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Maaf kamar sudah dipesan pada tanggal tersebut'
            ]);
            die();
        }
        if ($check_in < date('d-m-Y')) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Tanggal check-in tidak boleh lebih kecil dari tanggal hari ini'
            ]);
            die();
        }
        if ($check_in == $booking['checkIn']) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Kamar sudah dipesan pada tanggal tersebut'
            ]);
            die();
        }
    }

    $number_of_people = 1;
    if (isset($data['number_of_people'])) {
        $number_of_people = $data['number_of_people'];
    } else {
        $number_of_people = 1;
    }
    if ($data['type'] === 'LDK' || $data['type'] === 'PERUSAHAAN') {
        if ($number_of_people <= 34) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Minimal 35 orang untuk pemesanan LDK dan PERUSAHAAN'
            ]);
            die();
        }
    } else if ($data['type'] === 'CAMP' && $number_of_people < 2) {
        echo json_encode([
            'status' => 'failed',
            'message' => 'Minimal 2 orang untuk pemesanan CAMP'
        ]);
        die();
    }


    if ($data['type'] != '') {
        $sql = "SELECT * FROM bundling WHERE id = $room";
        $res = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($res);
    } else {
        $sql = "SELECT * FROM room WHERE id = $room";
        $res = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($res);
    }

    $total_price = 0;

    if ($data['type'] != '') {
        $total_price = ($room['price'] * $hari) * $number_of_people;
        $total_price = $total_price + ($total_price * 0.01);
    } else {
        $total_price = $room['price'] * $hari;
        $total_price = $total_price + ($total_price * 0.01);
    }


    $sisa = 0;
    if ($data['tipe_pembayaran'] == 'dp') {
        $sisa = $total_price - $data['dp'];
    } else {
        $sisa = 0;
    }
    if ($data['tipe_pembayaran'] == 'dp') {
        if ($data['dp'] > $total_price) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'DP tidak boleh lebih besar dari total harga'
            ]);
            die();
        }
        if ($data['dp'] < 100000) {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Minimal DP Rp 100.000,-'
            ]);
            die();
        }
    }


    echo json_encode([
        'status' => 'success',
        'total_price' => $total_price,
        'user' => $user,
        'room' => $room,
        'hari' => $hari,
        'payment' => $payment,
        'check_in' => $check_in,
        'check_out' => $check_out,
        'dp' => $data['dp'],
        'sisa' => $sisa,
        'tipe_pembayaran' => $data['tipe_pembayaran'],
        'type_bundling' => $data['type'],
        'number_of_people' => $number_of_people,
    ]);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'konfirmasi') {
    $data = $_POST;
    echo json_encode($data);
    $user = $data['user_id'];
    $room = $data['room_id'];
    $check_in = $data['check_in'];
    $check_out = $data['check_out'];
    $number_of_people = $data['number_of_people'];

    $conn = $GLOBALS['conn'];

    if ($data['type_bundling'] == 'room') {
        $sql = "INSERT INTO booking (userId, roomId, checkIn, checkOut,totalPrice, paymentMethod, userPayed) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $res = update($sql, [$user, $room, $check_in, $check_out, $data['total_price'], $data['tipe_pembayaran'], $data['dp']], 'iissisi');
    } else if ($data['type_bundling'] == 'LDK' || $data['type_bundling'] == 'PERUSAHAAN' && $data['number_of_people'] >= 35) {
        $sql = "INSERT INTO booking (userId, bundlingId, checkIn, checkOut,totalPrice, paymentMethod, userPayed,capacity) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $res = update($sql, [$user, $room, $check_in, $check_out, $data['total_price'], $data['tipe_pembayaran'], $data['dp'], $data['number_of_people']], 'iissisii');
    } else if ($data['type_bundling'] == 'CAMP' && $data['number_of_people'] >= 2) {
        $sql = "INSERT INTO booking (userId, bundlingId, checkIn, checkOut,totalPrice, paymentMethod, userPayed,capacity) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $res = update($sql, [$user, $room, $check_in, $check_out, $data['total_price'], $data['tipe_pembayaran'], $data['dp'], $data['number_of_people']], 'iissisii');
    }
    if ($res) {
        $message = "Booking was successful!";
        $class = "success";
    } else {
        $message = "Booking failed. Please try again.";
        $class = "failed";
    }

    $sql = "SELECT * FROM user WHERE id = $user";
    $res = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($res);
    unset($user['password']);
    if ($data['type_bundling'] == 'room') {
        $sql = "SELECT * FROM room WHERE id = $room";
        $res = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($res);

        $sql = "SELECT * FROM booking WHERE userId = $user[id] AND roomId = $room[id] AND checkIn = '$check_in' AND checkOut = '$check_out'";
        $res = mysqli_query($conn, $sql);
        $booking = mysqli_fetch_assoc($res);
    } else {
        $sql = "SELECT * FROM bundling WHERE id = $room";
        $res = mysqli_query($conn, $sql);
        $room = mysqli_fetch_assoc($res);

        $sql = "SELECT * FROM booking WHERE userId = $user[id] AND bundlingId = $room[id] AND checkIn = '$check_in' AND checkOut = '$check_out'";
        $res = mysqli_query($conn, $sql);
        $booking = mysqli_fetch_assoc($res);
    }


    // header("Location: ./../../user/invoice.php?booking_id=$booking[id]&user_id=$user[id]&room_id=$room[id]&check_in=$check_in&check_out=$check_out&message=$message&class=$class");

    redirect("../../pemesanan");
    sleep(3);
    $_SESSION["sukses"] = 'Segera lakukan pembayaran sebelum tanggal ' . $booking['checkIn'] . ' dengan total harga Rp. ' . $data['total_price'] . ' ke nomor rekening 7010126818 Bank Muamalat - An. Nuryadi.';

}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'uploadBuktiPembayaran') {
    $data = $_POST;
    $bukti = $_FILES;
    $booking_id = $data['booking_id'];

    // hash file name
    $file_name = md5($_FILES["bukti_pembayaran"]["name"] . time());

    // get file extension
    $file_extension = pathinfo($_FILES["bukti_pembayaran"]["name"], PATHINFO_EXTENSION);
    $picture_name = $file_name . '.' . $file_extension;

    // upload file
    $target_dir = './../../assets/images/bukti_pembayaran/';
    $target_file = $target_dir . $picture_name;
    if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
        $sql = "INSERT INTO picture (name) VALUES (?)";
        $res = update($sql, [$picture_name], 's');
        if ($res) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Bukti pembayaran berhasil diupload'
            ]);
        } else {
            echo json_encode([
                'status' => 'failed',
                'message' => 'Bukti pembayaran gagal diupload'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'failed',
            'message' => 'Bukti pembayaran gagal diupload'
        ]);
    }

    $sql = "SELECT * FROM picture WHERE name = '$picture_name'";
    $res = mysqli_query($conn, $sql);
    $picture = mysqli_fetch_assoc($res);

    $sql = "UPDATE booking SET pictureId = ? WHERE id = ?";
    $res = update($sql, [$picture['id'], $booking_id], 'ii');


    if ($res) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Bukti pembayaran berhasil diupload'
        ]);
    } else {
        echo json_encode([
            'status' => 'failed',
            'message' => 'Bukti pembayaran gagal diupload'
        ]);
    }

}



?>