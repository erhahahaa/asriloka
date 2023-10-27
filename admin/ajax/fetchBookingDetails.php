<?php

require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';
include './../../app/model/Facility.php';

if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    $sql = "SELECT * FROM booking WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        $booking['checkIn'] = date('d-m-Y', strtotime($booking['checkIn']));
        $booking['checkOut'] = date('d-m-Y', strtotime($booking['checkOut']));
        if ($booking['roomId'] != null) {
            $sql = "SELECT * FROM room WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking['roomId']);
            $stmt->execute();
            $result = $stmt->get_result();
            $room = $result->fetch_assoc();
            $booking['room'] = $room;
        } else {
            $sql = "SELECT * FROM bundling WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $booking['bundlingId']);
            $stmt->execute();
            $result = $stmt->get_result();
            $bundling = $result->fetch_assoc();
            $booking['bundling'] = $bundling;
        }
        echo json_encode($booking);
    } else {
        echo json_encode(['error' => 'No booking found for given ID']);
    }
}
?>