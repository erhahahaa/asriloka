<?php
require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';

if (isset($_POST['id']) && isset($_POST['status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $totalPrice = $_POST['totalPrice'];

    if ($status == 'PAYED') {
        $sql = "UPDATE booking SET status = ?, userPayed = ? WHERE id = ?";
    } else if ($status == 'CHECKEDIN') {
        $sql = "UPDATE booking SET status = ?, userPayed =? WHERE id = ?";
    } else if ($status == 'CHECKEDOUT') {
        $sql = "UPDATE booking SET status = ?, userPayed =? WHERE id = ?";
    } else if ($status == 'CANCELLED') {
        $sql = "UPDATE booking SET status = ?, userPayed =? WHERE id = ?";
    }

    if ($status == 'CANCELLED') {
        $sql = "UPDATE booking SET status = ?, userPayed =? WHERE id = ?";
        $res = update($sql, [$status, 0, $id], 'sii');
    } else {
        $sql = "UPDATE booking SET status = ?, userPayed =? WHERE id = ?";
        $res = update($sql, [$status, $totalPrice, $id], 'sii');
    }


    if ($res) {
        echo json_encode(['status' => 'success', 'message' => 'Booking status updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Booking status updated failed']);
    }


}