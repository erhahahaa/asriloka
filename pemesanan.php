<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pemesanan </title>
    <?php require('./admin/inc/links.php'); ?>
</head>

<body>
    <?php require('./inc/header.php'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3 mx-auto">
                <div class="card">
                    <div class="card-body text-center">
                        <?php
                        if (isset($_SESSION['data'])) {
                            if ($user['picture'] != null || $user['picture'] != '') {
                                echo "<img src='assets/images/user/$user[picture]' class='card-img-top' alt='...'>";
                            } else {
                                echo "<img src='assets/images/user/default.jpg' class='card-img-top' alt='...'>";
                            }
                            echo "<h5 class='card-title'>$user[name]</h5>";
                            echo "<p class='card-text'>$user[phone]</p>";
                            echo "<p class='card-text'>$user[address]</p>";
                        } else {
                            echo "<h5 class='text-center'>Silahkan login terlebih dahulu</h5>";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['data'])) {
                            echo "<h5 class='card-title'>Pemesanan</h5>";
                            $sql = "SELECT * FROM booking WHERE userId = ?";
                            $res = select($sql, [$user['id']], 'i');
                            $booking = [];
                            while ($row = mysqli_fetch_assoc($res)) {
                                $booking[] = $row;
                            }
                            if (count($booking) != 0) {
                                $html = "<table class='table table-striped'>";
                                $html .= "<thead>";
                                $html .= "<tr>";
                                $html .= "<th style='width: 10px;'>ID</th>";
                                $html .= "<th scope='col'>Room</th>";
                                $html .= "<th scope='col'>Status</th>";
                                $html .= "<th scope='col'>Invoice</th>";
                                $html .= "<th scope='col'>Action</th>";
                                $html .= "</tr>";

                                $html .= "</thead>";
                                $html .= "<tbody>";
                                foreach ($booking as $key => $value) {
                                    if ($value['roomId'] == null) {
                                        // fetch bundling
                                        $sql = "SELECT * FROM bundling WHERE id = ?";
                                        $res = select($sql, [$value['bundlingId']], 'i');

                                        // append bundling
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $room[] = $row;
                                        }

                                    } else {
                                        // fetch room
                                        $sql = "SELECT * FROM room WHERE id = ?";
                                        $res = select($sql, [$value['roomId']], 'i');

                                        // append room
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $room[] = $row;
                                        }

                                    }
                                }
                                foreach ($booking as $key => $value) {
                                    $html .= "<tr>";
                                    $html .= " <th scope='row'>$value[id]</th>";
                                    $html .= "<td>";
                                    foreach ($room as $k => $v) {
                                        if ($v['id'] == $value['roomId']) {
                                            $html .= "$v[name]";
                                            break;
                                        }
                                        if ($v['id'] == $value['bundlingId']) {
                                            $html .= "$v[name]";
                                            break;

                                        }
                                    }
                                    $html .= "<td>$value[status]</td>";
                                    if ($value['status'] == 'BOOKED' && $value['paymentMethod'] == 'DP') {
                                        $_SESSION['sukses'] = "Segera lakukan pembayaran untuk mengkonfirmasi pemesanan anda";
                                        $html .= "<td><div class='text-center'><div>";
                                        $html .= "Menunggu Sisa Pembayaran :";
                                        $html .= "<span class='text-danger'> ";
                                        $html .= "Rp. " . number_format($value['totalPrice'] - $value['userPayed'], 0, ',', '.') . "</span>";
                                        $html .= "</div></div></td>";
                                    } else if ($value['status'] == 'CANCELLED') {
                                        $html .= "<td><div class='text-center'><div>";
                                        $html .= "Pemesanan Dibatalkan";
                                        $html .= "</div></div></td>";
                                    } else if ($value['status'] == 'CHECKEDIN') {
                                        $html .= "<td><div class='text-center'><div>";
                                        $html .= "Check In";
                                        $html .= "</div></div></td>";
                                    } else if ($value['status'] == 'CHECKEDOUT') {
                                        $html .= "<td><div class='text-center'><div>";
                                        $html .= "Check Out";
                                        $html .= "</div></div></td>";
                                    } else {
                                        $html .= "<td><a href='invoice.php?booking_id=$value[id]&user_id=$user[id]&room_id=$value[roomId]&check_in=$value[checkIn]&check_out=$value[checkOut]&bundling_id=$value[bundlingId]&number_of_people=$value[capacity]' class='btn btn-primary'>Invoice</a></td>";
                                    }
                                    $html .= "<td>";
                                    $html .= "<div class='d-flex justify-content-center'>";
                                    $html .= "<button type='button' class='btn btn-primary viewBookingBtn' data-booking-id='$value[id]'>View</button>";

                                    if ($value['status'] == 'BOOKED' && $value['paymentMethod'] == 'DP') {
                                        $html .= "<button type='button' class='btn btn-primary mx-2' data-bs-toggle='modal' data-bs-target='#uploadBuktiPembayaran' data-bs-id='$value[id]'>Upload Bukti Pembayaran</button>";
                                    }
                                    $html .= "</div>";

                                    $html .= "</td>";
                                    $html .= "</tr>";
                                }
                                $html .= "</tbody>";
                                $html .= "</table>";
                                // $html .= "<div class='modal fade' id='viewBooking$value[id]' tabindex='-1' aria-labelledby='viewBookingLabel$value[id]' aria-hidden='true'>";
                                // $html .= "<div class='modal-dialog modal-dialog-centered'>";
                                // $html .= "<div class='modal-content'>";
                                // $html .= "<div class='modal-header'>";
                                // $html .= "<h5 class='modal-title' id='viewBookingLabel$value[id]'>Pemesanan $value[id]</h5>";
                                // $html .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                // $html .= "</div>";
                                // $html .= "<div class='modal-body' id='viewPembayaran$value[id]'>";
                                // $html .= "<table class='table table-striped'>";
                                // $html .= "<thead>";
                                // $html .= "<tr>";
                                // $html .= "<th scope='col'>Room</th>";
                                // $html .= "<th scope='col'>Check In</th>";
                                // $html .= "<th scope='col'>Check Out</th>";
                                // $html .= "<th scope='col'>Total Price</th>";
                                // $html .= "<th scope='col'>Status</th>";
                                // $html .= "<th scope='col'>Pembayaran</th>";
                                // $html .= "</tr>";
                                // $html .= "</thead>";
                                // $html .= "<tbody>";
                                // $html .= "<tr>";
                                // $html .= "<td>";
                                // foreach ($room as $k => $v) {
                                //     if ($v['id'] == $value['roomId']) {
                                //         $html .= "$v[name]";
                                //         break;
                                //     }
                                //     if ($v['id'] == $value['bundlingId']) {
                                //         $html .= "$v[name]";
                                //         break;
                        
                                //     }
                                // }
                                // $html .= "</td>";
                                // $html .= "<td>" . date('d-m-Y', strtotime($value['checkIn'])) . "</td>";
                                // $html .= "<td>" . date('d-m-Y', strtotime($value['checkOut'])) . "</td>";
                                // $html .= "<td>Rp. " . number_format($value['totalPrice'], 0, ',', '.') . "</td>";
                        
                                // $html .= "<td>$value[status]</td>";
                                // $html .= "<td>";
                                // if ($value['paymentMethod'] == 'DP') {
                                //     $html .= "<div class='text-center'>";
                                //     $html .= "DP : $value[userPayed] <br>";
                                //     $html .= "</div>";
                                // } else {
                                //     $html .= "<span>Lunas</span>";
                                // }
                                // $html .= "</td>";
                                // $html .= "</tr>";
                                // $html .= "</tbody>";
                                // $html .= "</table>";
                                // $html .= "</div>";
                                // $html .= "</div>";
                                // $html .= "</div>";
                                // $html .= "</div>";
                            }

                            echo $html;
                        }
                        ?>

                    </div>
                </div>

                <div class="modal fade" id="uploadBuktiPembayaran" tabindex="-1"
                    aria-labelledby="uploadBuktiPembayaranLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadBuktiPembayaranLabel">Upload Bukti Pembayan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="uploadBuktiPembayarnBody">
                                <form method="POST" enctype="multipart/form-data" id="formUploadBukti">
                                    <input type="hidden" name="action" value="uploadBuktiPembayaran">
                                    <input type="hidden" name="booking_id" id="booking_id">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="col-form-label">Upload Bukti
                                            Pembayaran</label>
                                        <input type="file" class="form-control" id="recipient-name"
                                            name="bukti_pembayaran">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <div class='modal fade' id='viewBookingModal' tabindex='-1' aria-labelledby='viewBookingLabel'
                    aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='viewBookingLabel'></h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal'
                                    aria-label='Close'></button>
                            </div>
                            <div class='modal-body' id='viewPembayaranDetails'>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div </div>
                <?php
                if (isset($_SESSION['data'])) {
                    echo "<h5 class='text-center mt-5'><strong>No Rekening Asriloka</strong></h5>";
                    echo "<span class='pl-5'>Transfer ke nomor rekening <strong>di bawah ini</strong></span>";
                    echo "<span class='pl-5'> dengan mencantumkan <strong>ID pemesanan</strong></span>";
                    echo "<div class='card m-4 p-4'>";
                    echo "<h4>Muamalat - An. Nuryadi</h4>";
                    echo "<h5>7010126818</h5>";
                    echo "</div>";
                }
                ?>

            </div>

            <?php require('./admin/inc/scripts.php'); ?>
            <script>

                $('#uploadBuktiPembayaran').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('bs-id')
                    var modal = $(this)
                    modal.find('.modal-body #booking_id').val(id)
                })
                $('#formUploadBukti').submit(function (e) {
                    e.preventDefault();
                    // id 
                    var id = $('#booking_id').val();
                    var formData = new FormData(this);
                    formData.append('booking_id', id);
                    console.log(formData);
                    $.ajax({
                        url: 'admin/ajax/payment.php?action=uploadBuktiPembayaran',
                        type: 'POST',
                        data: formData,
                        success: function (data) {
                            alert(data);
                            console.log(data);
                            location.reload();
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                });
                $(document).on('click', '.viewBookingBtn', function () {
                    var bookingId = $(this).data('booking-id');
                    console.log("booking id : " + bookingId);
                    $.ajax({
                        url: 'admin/ajax/fetchBookingDetails.php',
                        type: 'POST',
                        data: {
                            booking_id: bookingId
                        },
                        success: function (response) {
                            const data = JSON.parse(response);
                            console.log(data);
                            var html = "<table class='table table-striped'>";
                            html += "<thead>";
                            html += "<tr>";
                            html += "<th scope='col'>Room</th>";
                            html += "<th scope='col'>Check In</th>";
                            html += "<th scope='col'>Check Out</th>";
                            html += "<th scope='col'>Total Price</th>";
                            html += "<th scope='col'>Status</th>";
                            html += "<th scope='col'>Pembayaran</th>";
                            html += "</tr>";
                            html += "</thead>";
                            html += "<tbody>";
                            html += "<tr>";
                            if (data.roomId != null) {
                                html += "<td>" + data.room.name + "</td>";
                            } else {
                                html += "<td>" + data.bundling.name + "</td>";
                            }
                            html += "<td>" + data.checkIn + "</td>";
                            html += "<td>" + data.checkOut + "</td>";
                            html += "<td>Rp. " + data.totalPrice + "</td>";
                            html += "<td>" + data.status + "</td>";
                            html += "<td>";
                            if (data.paymentMethod == 'DP') {
                                html += "<div class='text-center'>";
                                html += "DP : " + data.userPayed + "<br>";
                                html += "</div>";
                            } else {
                                html += "<span>Lunas</span>";
                            }
                            html += "</td>";
                            html += "</tr>";
                            html += "</tbody>";
                            html += "</table>";
                            $('#viewBookingLabel').html("Pemesanan " + data.id);
                            $('#viewPembayaranDetails').html(html);
                            $('#viewBookingModal').modal('show');

                        }
                    });
                });
            </script>
</body>

</html>