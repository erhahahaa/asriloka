<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asriloka - DETAILS</title>

    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">More Details</h2>
        <hr>
    </div>

    <div class="container">
        <?php
        $type = '';
        $id = '';
        if (isset($_GET['type']) && isset($_GET['id'])) {
            $type = $_GET['type'];
            $id = $_GET['id'];
        }

        if ($type == 'room') {
            // Fetch room details using a single query
            $sql = "SELECT * FROM room WHERE id = $id";
            $res = mysqli_query($conn, $sql);
            $room = mysqli_fetch_assoc($res);

            // Fetch facility details using JOIN query
            $sql = "SELECT f.* FROM facilityonroom fr
            JOIN facility f ON fr.facilityId = f.id
            WHERE fr.roomId = $id";
            $res = mysqli_query($conn, $sql);
            $facility = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $facility[] = $row;
            }

            // Fetch picture details using JOIN query
            $sql = "SELECT p.* FROM pictureonroom pr
            JOIN picture p ON pr.pictureId = p.id
            WHERE pr.roomId = $id";
            $res = mysqli_query($conn, $sql);
            $picture = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $picture[] = $row;
            }

            // Fetch rule details using JOIN query
            $sql = "SELECT r.* FROM ruleonroom rr
            JOIN rule r ON rr.ruleId = r.id
            WHERE rr.roomId = $id";
            $res = mysqli_query($conn, $sql);
            $rule = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $rule[] = $row;
            }

            // Fetch capacity details using JOIN query
            $sql = "SELECT c.* FROM capacityonroom cr
            JOIN capacity c ON cr.capacityId = c.id
            WHERE cr.roomId = $id";
            $res = mysqli_query($conn, $sql);
            $capacity = [];
            while ($row = mysqli_fetch_assoc($res)) {
                $capacity[] = $row;
            }

            $data = [
                'room' => $room,
                'facility' => $facility,
                'rule' => $rule,
                'capacity' => $capacity,
                'picture' => $picture
            ];

            $html = "<div class='card mb-4 border-0 shadow'>";
            $html .= "<div class='row g-0 p-3 align-items-center'>";
            $html .= "<div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>";
            $html .= "<div id='carousel$room[id]' class='carousel slide'>";
            $html .= "<div class='carousel-indicators'>";

            // Carousel indicators should be generated dynamically
            for ($i = 0; $i < count($picture); $i++) {
                $html .= "<button type='button' data-bs-target='#carousel$room[id]' data-bs-slide-to='$i'";
                if ($i == 0) {
                    $html .= " class='active'";
                }
                $html .= " aria-label='Slide $i'></button>";
            }

            $html .= "</div>";
            $html .= "<div class='carousel-inner'>";

            // Iterate through pictures to create carousel items
            foreach ($picture as $key => $value) {
                $html .= "<div class='carousel-item";
                if ($key == 0) {
                    $html .= " active";
                }
                $html .= "'>";
                $html .= "<img src='./assets/images/room/$value[name]' class='d-block w-100' alt='...'>";
                $html .= "</div>";
            }

            $html .= "</div>";
            $html .= "<button class='carousel-control-prev' type='button' data-bs-target='#carousel$room[id]' data-bs-slide='prev'>";
            $html .= "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
            $html .= "<span class='visually-hidden'>Previous</span>";
            $html .= "</button>";
            $html .= "<button class='carousel-control-next' type='button' data-bs-target='#carousel$room[id]' data-bs-slide='next'>";
            $html .= "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
            $html .= "<span class='visually-hidden'>Next</span>";
            $html .= "</button>";
            $html .= "</div>";
            $html .= "</div>";

            $html .= "<div class='col-md-4 px-lg-3 px-md-3 px-0'>";
            $html .= "<h5 class='mb-3'>$room[name]</h5>";
            $html .= "<p class='mb-3'>$room[description]</p>";
            $html .= "<p class='mb-3'>Rp. $room[price]</p>";
            $html .= "<p class='mb-3'>Fasilitas :</p>";
            $html .= "<ul class='mb-3'>";
            foreach ($facility as $key => $value) {
                $html .= "<li>$value[name]</li>";
            }
            $html .= "</ul>";
            $html .= "<p class='mb-3'>Rule :</p>";
            $html .= "<ul class='mb-3'>";
            foreach ($rule as $key => $value) {
                $html .= "<li>$value[description]</li>";
            }
            $html .= "</ul>";
            $html .= "<p class='mb-3'>Kapasitas :</p>";
            $html .= "<ul class='mb-3'>";
            foreach ($capacity as $key => $value) {
                $html .= "<li>$value[description]</li>";
            }
            $html .= "</ul>";
            $html .= ' <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#makeBooking">
            <i class="bi bi-plus-circle-fill"></i> Pesan
        </button>';
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";

            echo $html;
        } else {

            $sql = '';
            if (substr($type, 0, 5) == 'paket') {
                $sql = "SELECT * FROM bundling WHERE id = $id";
                $res = mysqli_query($conn, $sql);
                $bundling = mysqli_fetch_assoc($res);

                $sql = "SELECT f.* FROM facilityonbundling fb
                JOIN facility f ON fb.facilityId = f.id
                WHERE fb.bundlingId = $id";
                $res = mysqli_query($conn, $sql);
                $facility = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $facility[] = $row;
                }

                $sql = "SELECT p.* FROM pictureonbundling pb
                JOIN picture p ON pb.pictureId = p.id
                WHERE pb.bundlingId = $id";
                $res = mysqli_query($conn, $sql);
                $picture = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $picture[] = $row;
                }

                $sql = "SELECT r.* FROM ruleonbundling rb
                JOIN rule r ON rb.ruleId = r.id
                WHERE rb.bundlingId = $id";
                $res = mysqli_query($conn, $sql);
                $rule = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $rule[] = $row;
                }

                $data = [
                    'bundling' => $bundling,
                    'facility' => $facility,
                    'rule' => $rule,
                    'picture' => $picture
                ];

                $html = "<div class='card mb-4 border-0 shadow'>";
                $html .= "<div class='row g-0 p-3 align-items-center'>";
                $html .= "<div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>";
                $html .= "<div id='carousel$bundling[id]' class='carousel slide'>";
                $html .= "<div class='carousel-indicators'>";
                for ($i = 0; $i < count($picture); $i++) {
                    $html .= "<button type='button' data-bs-target='#carousel$bundling[id]' data-bs-slide-to='$i'";
                    if ($i == 0) {
                        $html .= " class='active'";
                    }
                    $html .= " aria-label='Slide $i'></button>";
                }
                $html .= "</div>";
                $html .= "<div class='carousel-inner'>";
                foreach ($picture as $key => $value) {
                    $html .= "<div class='carousel-item";
                    if ($key == 0) {
                        $html .= " active";
                    }
                    $html .= "'>";
                    $html .= "<img src='./assets/images/bundling/$value[name]' class='d-block w-100' alt='...'>";
                    $html .= "</div>";
                }
                $html .= "</div>";
                $html .= "<button class='carousel-control-prev' type='button' data-bs-target='#carousel$bundling[id]' data-bs-slide='prev'>";
                $html .= "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                $html .= "<span class='visually-hidden'>Previous</span>";
                $html .= "</button>";
                $html .= "<button class='carousel-control-next' type='button' data-bs-target='#carousel$bundling[id]' data-bs-slide='next'>";
                $html .= "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                $html .= "<span class='visually-hidden'>Next</span>";
                $html .= "</button>";
                $html .= "</div>";
                $html .= "</div>";
                $html .= "<div class='col-md-4 px-lg-3 px-md-3 px-0'>";
                $html .= "<h5 class='mb-3'>$bundling[name]</h5>";
                $html .= "<p class='mb-3'>$bundling[description]</p>";
                $html .= "<p class='mb-3'>Rp. $bundling[price]</p>";
                $html .= "<p class='mb-3'>Fasilitas :</p>";
                $html .= "<ul class='mb-3'>";
                foreach ($facility as $key => $value) {
                    $html .= "<li>$value[name]</li>";
                }
                $html .= "</ul>";
                $html .= "<p class='mb-3'>Ketentuan :</p>";
                $html .= "<ul class='mb-3'>";
                foreach ($rule as $key => $value) {
                    $html .= "<li>$value[description]</li>";
                }
                $html .= "</ul>";
                $html .= ' <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal" data-bs-target="#makeBooking"> 
                <i class="bi bi-plus-circle-fill"></i> Pesan
            </button>';
                $html .= "</div>";
                $html .= "</div>";
                $html .= "</div>";

                echo $html;


            }
        }
        ?>
        <div class="modal" id="makeBooking">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pemesanan</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form method="POST" id="form_pembayaran">
                        <div class="modal-body">
                            <div class="mb-3">
                                <!-- <label for="payment_method" class="form-label">Pilih metode
                                    pembayaran</label>
                                <select class="form-select" name="tipe_pembayaran" disabled>
                                    <option value="dp">DP</option>
                                    <option value="full">Full</option>
                                </select> -->
                                <input type="hidden" id="tipe_pembayaran" name="tipe_pembayaran" value="dp">

                                <!-- if tipe_pembayan is DP shown an input box -->
                                <div class="mb-3 mt-3" id="dp">
                                    <label for="dp" class="form-label">DP (min Rp. 100.000,-)</label>
                                    <input type="number" class="form-control" id="dp" name="dp"
                                        placeholder="Masukkan Nominal DP">
                                </div>

                                <!-- date picker for check in and check out -->
                                <label for="check_in" class="form-label">Tanggal Check In</label>
                                <input type="date" class="form-control" id="check_in" name="check_in" required>
                                <label for="check_out" class="form-label">Tanggal Check Out</label>
                                <input type="date" class="form-control" id="check_out" name="check_out" required>
                                <?php
                                if ($type == 'paketLDK' || $type == "paketPERUSAHAAN" || $type == "paketCAMP") {
                                    echo '<label for="number_of_people" class="form-label">Jumlah Orang';
                                    if ($type == 'paketCAMP') {
                                        echo '<span class="text-danger">(min 2 orang)</span>';
                                    } else {
                                        echo '<span class="text-danger">(min 35 orang)</span>';
                                    }
                                    echo '</label>';
                                    echo '<input type="number" class="form-control" id="number_of_people" name="number_of_people" placeholder="Masukkan Jumlah Orang" required>';
                                }
                                ?>

                                <input type="hidden" value="Transfer Bank" name="payment_method">

                                <!-- hidden room input -->
                                <input type="hidden" name="room_id" value="<?php if (!empty($room['id'])) {
                                    echo $room['id'];
                                } else {
                                    echo $id;
                                } ?>">
                                <input type="hidden" name="type" value="<?php if (!empty($type))
                                    echo substr($type, 5); ?>">
                                <!-- hidden user -->
                                <input type="hidden" name="user_id" value="<?php
                                if (isset($_SESSION['data']['id'])) {
                                    echo $_SESSION['data']['id'];
                                }
                                ?>">
                            </div>

                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <?php
                            if (isset($_SESSION['data']['id'])) {
                                echo '<button type="submit" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#paymentModal">
                        Bayar</button>';
                            } else {
                                echo alert('danger', 'Silahkan login terlebih dahulu');
                            }
                            ?>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Detail Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="formModalPaymey">
                    </div>
                </div>
            </div>
        </div>
        <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
            crossorigin="anonymous"></script>
        <?php include './admin/inc/scripts.php' ?>
        <script>
            // $("#dp").hide();

            // $("#tipe_pembayaran").on("change", function () {
            //     console.log($(this).val());
            //     if ($(this).val() == "dp") {
            //         $("#dp").show();
            //     } else {
            //         $("#dp").hide();
            //     }
            // });

            $("#form_pembayaran").on("submit", function (e) {
                e.preventDefault();
                var dana_number = "0857 2003 4203 1980";
                var bank_number = "1234567890";
                var html = "";
                console.log($(this).serialize());
                $.ajax({
                    url: "admin/ajax/payment.php?action=pembayaran",
                    type: "POST",
                    data: $(this).serialize(),
                    caches: false,
                    success: function (response) {
                        console.log("Response : ", response);
                        var data = JSON.parse(response);
                        console.log('Details : ', data);
                        var type_bundling = "room";
                        if (data.status == "success") {

                            if (data.room.type != "" && data.room.type != undefined) {
                                type_bundling = data.room.type;
                            } else {
                                type_bundling = "room";
                            }

                            html += `<form action="admin/ajax/payment.php?action=konfirmasi" method="POST" id="konfirmasi_pembayaran">`;
                            html += `<h5>Nama : ${data.user.name}</h5>`;
                            // html += `<h5>Email : ${data.user.email}</h5>`;
                            html += `<h5>Phone : ${data.user.phone}</h5>`;

                            if (data.room.type != "" && data.room.type != undefined) {
                                type_bundling = data.room.type;

                                html += `<h5>Nama Paket : ${data.room.name}</h5>`;
                                html +=
                                    '<h5>Nomor Paket : <span class="text-primary">' +
                                    data.room.id +
                                    "</span></h5>";
                                html += `<h5>Jenis Paket : ${data.room.type}</h5>`;
                                html += `<h5>Jumlah Orang : ${data.number_of_people}</h5>`;
                            } else {
                                type_bundling = "room";
                                html += `<h5>Nama Kamar : ${data.room.name}</h5>`;
                                html +=
                                    '<h5>Nomor Kamar : <span class="text-primary">' +
                                    data.room.id +
                                    "</span></h5>";
                            }
                            html += `<h5>Check In : <span class="text-primary">${data.check_in}</span></h5>`;
                            html += `<h5>Check Out : <span class="text-primary">${data.check_out}</span></h5>`;
                            if (data.payment == "dana") {
                                html += `<h5>Nomor Rekening : <span class="text-primary">${dana_number}</span></h5>`;
                            } else {
                                html += `<h5>Nomor Rekening : <span class="text-primary">${bank_number}</span></h5>`;
                            }
                            html +=
                                '<h5>Metode Pembayaran : <span class="text-primary">' +
                                data.payment.toUpperCase();
                            if (data.sisa != 0) {
                                html += ` (DP)</span></h5>`;
                                const formattedDp = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.dp);
                                const formattedSisa = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.sisa);

                                html += `<h5>Nominal DP : <span class="text-primary">${formattedDp}</span></h5>`;
                                html += `<h5>Sisa Pembayaran : <span class="text-danger">${formattedSisa} (+PPN 1% Bayar Waktu Check-in)</span></h5>`;

                            } else {
                                html += "</span></h5>";
                                html += `<h5>Total Pembayaran :<span class="text-danger"> Rp ${data.total_price.toLocaleString('id-ID')} (+PPN 1%) </span> </h5>`;
                            }
                            html += `<button type="submit" class="btn btn-primary">Konfirmasi</button>`;
                            // hidden input
                            html += `<input type="hidden" name    ="type_bundling" value="${type_bundling}">`;
                            html += `<input type="hidden" name    ="user_id" value="${data.user.id}">`;
                            html += `<input type="hidden" name    ="room_id" value="${data.room.id}">`;
                            html += `<input type="hidden" name    ="payment" value="${data.payment}">`;
                            html += `<input type="hidden" name    ="total_price" value="${data.total_price}">`;
                            html += `<input type="hidden" name    ="check_in" value="${data.check_in}">`;
                            html += `<input type="hidden" name    ="check_out" value="${data.check_out}">`;
                            html += `<input type="hidden" name    ="tipe_pembayaran" value="dp">`;
                            html += `<input type="hidden" name    ="dp" value="${data.dp}">`;
                            html += `<input type="hidden" name    ="number_of_people" value="${data.number_of_people}">`;

                            html += `</form>`;
                        } else {
                            html += `<h3>${data.message}</hh3`;
                        }
                        $("#formModalPaymey").html(html);
                    },
                });
            });
            $("#konfirmasi_pembayaran").on("submit", function (e) {
                e.preventDefault();
            });
        </script>
</body>

</html>