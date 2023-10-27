<?php
require './../lib/essentials.php';
adminLogin();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>


    <style>
        .bi-check-circle-fill {
            color: darkgreen;
        }
    </style>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid " id=main-content>
        <div class="row">
            <!-- <div class="col-lg-12 ms-auto p-4 overflow-hidden">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Deleniti reiciendis tempora repellat ratione
                culpa a quas dolorum! Ex, est pariatur voluptatem rerum sit accusantium explicabo totam ipsum, ipsa eum
                quisquam!
            </div> -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nama Pemesan</th>
                                    <th class="text-center">Nama Kamar</th>
                                    <!-- <th class="text-center">Check In</th>
                                    <th class="text-center">Check Out</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Pembayaran</th>
                                    <th class="text-center">Total DP</th>
                                    <th class="text-center">Total Harga</th>
                                    <th class="text-center">Sisa Pembayaran</th>
                                    <th class="text-center">Bukti Pembayaran</th>
                                    <th class="text-center">Jumlah Peserta</th> -->
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM booking";
                                $res = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $booking[] = $row;
                                }

                                if (isset($booking)) {
                                    foreach ($booking as $key => $value) {
                                        if ($value['roomId'] != null) {
                                            $sql = "SELECT * FROM room WHERE id = ?";
                                            $res = select($sql, [$value['roomId']], 'i');
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $room[] = $row;
                                            }
                                        } else {
                                            $sql = "SELECT * FROM bundling WHERE id = ?";
                                            $res = select($sql, [$value['bundlingId']], 'i');
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $room[] = $row;
                                            }
                                        }

                                    }
                                    foreach ($booking as $key => $value) {
                                        $sql = "SELECT * FROM user WHERE id = ?";
                                        $res = select($sql, [$value['userId']], 'i');
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            $user[] = $row;
                                        }
                                    }
                                    $html = '';
                                    foreach ($booking as $key => $value) {
                                        $html .= "<tr>";
                                        // $html .= "<th scope='row'>$key</th>";
                                        $html .= "<td class='text-center'>$value[id]</td>";

                                        $html .= "<td class='text-center'>";
                                        foreach ($user as $k => $v) {
                                            if ($v['id'] == $value['userId']) {
                                                $html .= "$v[name]";
                                                break;
                                            }
                                        }
                                        $html .= "</td>";
                                        $html .= "<td class='text-center'>";
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
                                        $html .= "</td>";
                                        // $html .= "<td class='text-center'>" . date('Y-m-d', strtotime($value['checkIn'])) . "</td>";
                                        // $html .= "<td class='text-center'>" . date('Y-m-d', strtotime($value['checkOut'])) . "</td>";
                                        // $html .= "<td class='text-center'>$value[status]</td>";
                                        // $html .= "<td class='text-center'>$value[paymentMethod]</td>";
                                        // // $html .= "<td class='text-center'>$value[userPayed]</td>";
                                        // $html .= "<td class='text-center'> Rp. " . number_format($value['userPayed'], 0, ',', '.') . "</td>";
                                        // // $html .= "<td class='text-center'>$value[totalPrice]</td>";
                                        // $html .= "<td class='text-center'> Rp. " . number_format($value['totalPrice'], 0, ',', '.') . "</td>";
                                        // $html .= "<td class='text-center'> Rp. " . number_format($value['totalPrice'] - $value['userPayed'], 0, ',', '.') . "</td>";
                                

                                        // if ($value['pictureId'] != null) {
                                        //     $sql = "SELECT * FROM picture WHERE id = ?";
                                        //     $res = select($sql, [$value['pictureId']], 'i');
                                        //     while ($row = mysqli_fetch_assoc($res)) {
                                        //         $picture[] = $row;
                                        //     }
                                        //     $html .= "<td class='text-center'>";
                                        //     foreach ($picture as $k => $v) {
                                        //         if ($v['id'] == $value['pictureId']) {
                                        //             $html .= "<img src='../assets/images/bukti_pembayaran/$v[name]' alt='$v[name]' width='100px'><br><a href='../assets/images/bukti_pembayaran/$v[name]' download='$v[name]'><i class='bi bi-download' style='font-size: 24px;'></i></a>";
                                        //             break;
                                        //         }
                                
                                        //     }
                                        // } else {
                                        //     $html .= "<td class='text-center'>-</td>";
                                        // }
                                
                                        // if ($value['capacity'] != null) {
                                        //     $html .= "<td class='text-center'>$value[capacity]</td>";
                                        // } else {
                                        //     $html .= "<td class='text-center'>-</td>";
                                        // }
                                
                                        $html .= "<td class='text-center'>";
                                        $html .= "<button type='button' class='btn btn-secondary mx-2' data-bs-toggle='modal' data-bs-target='#viewBooking$value[id]'>View</button>";

                                        $html .= "<button type='button' class='btn btn-primary mr-2 update-button' data-bs-toggle='modal' data-bs-target='#updateModal' data-bs-id='$value[id]' data-bs-total-price='$value[totalPrice]'>Update</button>";

                                        $html .= "<div class='modal fade' id='viewBooking$value[id]' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>";
                                        $html .= "<div class='modal-dialog modal-xl'>";
                                        $html .= "<div class='modal-content'>";
                                        $html .= "<div class='modal-header'>";
                                        $html .= "<h1 class='modal-title fs-5' id='exampleModalLabel'>Booking Details $value[id]</h1>";
                                        $html .= "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                                        $html .= "</div>";
                                        $html .= "<div class='modal-body'>";
                                        $html .= "<table class='table table-bordered table-hover'>";
                                        $html .= "<thead>";
                                        $html .= "<tr>";
                                        $html .= "<th class='text-center'>Nama Kamar</th>";
                                        $html .= "<th class='text-center'>Check In</th>";
                                        $html .= "<th class='text-center'>Check Out</th>";
                                        $html .= "<th class='text-center'>Status</th>";
                                        $html .= "<th class='text-center'>Pembayaran</th>";
                                        $html .= "<th class='text-center'>Total DP</th>";
                                        $html .= "<th class='text-center'>Total Harga</th>";
                                        $html .= "<th class='text-center'>Sisa Pembayaran</th>";
                                        $html .= "<th class='text-center'>Bukti Pembayaran</th>";
                                        $html .= "<th class='text-center'>Jumlah Peserta</th>";
                                        $html .= "</tr>";
                                        $html .= "</thead>";
                                        $html .= "<tbody>";
                                        $html .= "<tr>";
                                        $html .= "<td class='text-center'>";
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
                                        $html .= "</td>";
                                        $html .= "<td class='text-center'>" . date('Y-m-d', strtotime($value['checkIn'])) . "</td>";
                                        $html .= "<td class='text-center'>" . date('Y-m-d', strtotime($value['checkOut'])) . "</td>";
                                        $html .= "<td class='text-center'>$value[status]</td>";
                                        $html .= "<td class='text-center'>$value[paymentMethod]</td>";
                                        $html .= "<td class='text-center'>$value[userPayed]</td>";
                                        $html .= "<td class='text-center'>$value[totalPrice]</td>";
                                        $html .= "<td class='text-center'>" . ($value['totalPrice'] - $value['userPayed']) . "</td>";
                                        $html .= "<td class='text-center'>";
                                        if ($value['pictureId'] != null) {
                                            $sql = "SELECT * FROM picture WHERE id = ?";
                                            $res = select($sql, [$value['pictureId']], 'i');
                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $picture[] = $row;
                                            }
                                            foreach ($picture as $k => $v) {
                                                if ($v['id'] == $value['pictureId']) {
                                                    $html .= "<img src='../assets/images/bukti_pembayaran/$v[name]' alt='$v[name]' width='100px'><br><a href='../assets/images/bukti_pembayaran/$v[name]' download='$v[name]'><i class='bi bi-download' style='font-size: 24px;'></i></a>";
                                                    break;
                                                }
                                            }
                                        } else {
                                            $html .= "-";
                                        }
                                        $html .= "</td>";
                                        if ($value['capacity'] != null) {
                                            $html .= "<td class='text-center'>$value[capacity]</td>";
                                        } else {
                                            $html .= "<td class='text-center'>-</td>";
                                        }
                                        $html .= "</tr>";
                                        $html .= "</tbody>";
                                        $html .= "</table>";
                                        $html .= "</div>";
                                        $html .= "</div>";
                                        $html .= "</div>";
                                        $html .= "</div>";
                                        $html .= "</td>";
                                        $html .= "</tr>";

                                    }
                                    echo $html;
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Update Modal -->
            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Status Update</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- form to update status -->
                            <form id="updateStatus" method="POST">

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Of Booking</label>
                                    <span>Booking ID : </span> <span id="modalId"></span>
                                    <input type="hidden" name="id" id="modalIdInput">
                                    <input type="hidden" name="totalPrice" id="modalTotalPrice">
                                    <select class="form-select" name="status" id="status">
                                        <option value="BOOKED">Booked</option>
                                        <option value="PAYED">Payed</option>
                                        <option value="CHECKEDIN">Checked In</option>
                                        <option value="CHECKEDOUT">Checked Out</option>
                                        <option value="CANCELLED">Cancelled</option>
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var updateButtons = document.querySelectorAll('.update-button');

            updateButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    var id = button.getAttribute('data-bs-id');
                    console.log("BUTTON CLICKED");
                    console.log(id);
                    document.getElementById('modalIdInput').value = id;
                    document.getElementById('modalId').innerHTML = id;
                    document.getElementById('modalTotalPrice').value = button.getAttribute('data-bs-total-price');
                });
            });
            $('#updateStatus').submit(function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                console.log(formData);
                $.ajax({
                    type: 'POST',
                    url: 'ajax/updateStatus.php',
                    data: formData,
                    success: function (response) {
                        console.log(response);
                        var data = JSON.parse(response);
                        if (data.status == 'success') {
                            // reload page then show swal
                            showSwal();
                            setTimeout(function () {
                                location.reload();
                            }, 1000);

                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Status Update Failed',
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            })
                        }
                    }
                });
            });

            function showSwal() {
                Swal.fire({
                    title: 'Success',
                    text: 'Status Updated',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
            }
        });
    </script>

    <?php require('inc/scripts.php'); ?>
</body>

</html>