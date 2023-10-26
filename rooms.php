<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asriloka - Penginapan</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Penginapan</h2>
        <hr>
    </div>

    <div class="container">
        <div class="row">
            <!-- Availability -->
            <div class="col-lg-3 col-md-12 mb-lg-0 mb-4 px-lg-0">
                <nav class="navbar navbar-expand-lg navbar-light bg-white rounded shadow">
                    <div class="container-fluid flex-lg-column align-items-sretch mb-3">
                        <h4 class="mt-2">FILTERS</h4>
                        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filterDropdown" aria-controls="navbarNav" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <form action="rooms" method="POST">
                            <div class="collapse navbar-collapse flex-column align-items-stretch mt-2"
                                id="filterDropdown">
                                <div class="border bg-light p-3 rounded mb-3">
                                    <h5 class="mb-3" style="font-size: 18px;">Check Availability</h5>
                                    <label for="check_in" class="form-label">Check-in</label> <input type="date"
                                        class="form-control shadow-none" id="check_in" name="check_in">
                                    <label for="check_out" class="form-label">Check-out</label>
                                    <input type="date" class="form-control shadow-none" id="check_out" name="check_out">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm w-100 btn-outline-dark shadow-none">Check
                                Availability</button>
                        </form>
                    </div>
                </nav>
            </div>
            <div class="col-lg-9 col-md-12 px-4">
                <?php


                $sql = "SELECT * FROM room";

                if (isset($_POST['check_in']) && isset($_POST['check_out'])) {
                    $check_in = $_POST['check_in'];
                    $check_out = $_POST['check_out'];
                    $sql = "SELECT * FROM room WHERE id NOT IN (SELECT roomId FROM booking WHERE checkIn BETWEEN '$check_in' AND '$check_out' OR checkOut BETWEEN '$check_in' AND '$check_out')";
                }

                $res = mysqli_query($conn, $sql);
                $room = [];
                while ($row = mysqli_fetch_assoc($res)) {
                    $room[] = $row;
                }
                foreach ($room as $key => $value) {

                    $sql = "SELECT * FROM facilityonroom WHERE roomId = ?";
                    $res = select($sql, [$value['id']], 'i');
                    while ($row = mysqli_fetch_assoc($res)) {
                        $facility[] = $row;
                    }
                    $room[$key]['facility'] = $facility;
                    $facility = [];
                }

                foreach ($room as $key => $value) {
                    foreach ($value['facility'] as $k => $v) {
                        $sql = "SELECT * FROM facility WHERE id = ?";
                        $res = select($sql, [$v['facilityId']], 'i');
                        while ($row = mysqli_fetch_assoc($res)) {
                            $facility[] = $row;
                        }
                    }
                    $room[$key]['facility'] = $facility;
                    $facility = [];
                }

                foreach ($room as $key => $value) {
                    $sql = "SELECT * FROM pictureonroom WHERE roomId = ?";
                    $res = select($sql, [$value['id']], 'i');
                    while ($row = mysqli_fetch_assoc($res)) {
                        $picture[] = $row;
                    }
                    $room[$key]['picture'] = $picture;
                    $picture = [];
                }

                foreach ($room as $key => $value) {
                    foreach ($value['picture'] as $k => $v) {
                        $sql = "SELECT * FROM picture WHERE id = ?";
                        $res = select($sql, [$v['pictureId']], 'i');
                        while ($row = mysqli_fetch_assoc($res)) {
                            $picture[] = $row;
                        }
                    }
                    $room[$key]['pictures'] = $picture;
                    $picture = [];
                }


                foreach ($room as $key => $value) {
                    $html = "<div class='card mb-4 border-0 shadow'>";
                    $html .= "<div class='row g-0 p-3 align-items-center'>";
                    $html .= "<div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>";
                    $html .= "<div id='carousel$value[id]' class='carousel slide'>";
                    $html .= "<div class='carousel-indicators'>";

                    // Output carousel indicators
                    for ($i = 0; $i < count($value['pictures']); $i++) {
                        $html .= "<button type='button' data-bs-target='#carousel$value[id]' data-bs-slide-to='$i' class='active' aria-current='true' aria-label='Slide $i'></button>";
                    }

                    $html .= "</div>";
                    $html .= "<div class='carousel-inner'>";

                    foreach ($value['pictures'] as $i => $picture) {
                        $html .= "<div class='carousel-item ";
                        $html .= ($i === 0) ? 'active' : '';
                        $html .= "'>";
                        $html .= "<img src='assets/images/room/$picture[name]' class='d-block w-100' alt='...'>";
                        $html .= "</div>";
                    }

                    $html .= "</div>";
                    $html .= "<button class='carousel-control-prev' type='button' data-bs-target='#carousel$value[id]' data-bs-slide='prev'>";
                    $html .= "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                    $html .= "<span class='visually-hidden'>Previous</span>";
                    $html .= "</button>";
                    $html .= "<button class='carousel-control-next' type='button' data-bs-target='#carousel$value[id]' data-bs-slide='next'>";
                    $html .= "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                    $html .= "<span class='visually-hidden'>Next</span>";
                    $html .= "</button>";


                    $html .= "</div>";
                    $html .= "</div>";
                    $html .= "<div class='col-md-4 px-lg-3 px-md-3 px-0'>";
                    $html .= "<h5 class='mb-3'>$value[name]</h5>";
                    $html .= "<div class='facilities mb-3'>";
                    $html .= "<h6 class='mb-1'>Fasilitas Kamar</h6>";
                    for ($i = 0; $i < count($value['facility']); $i++) {
                        $html .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>";
                        $html .= $value['facility'][$i]['name'];
                        $html .= "</span>";
                    }
                    $html .= "</div>";
                    $html .= "</div>";
                    $html .= "<div class='col-md-3 text-center'>";
                    $html .= "<h6 class='mb-4'>Rp $value[price]/malam</h6>";
                    $html .= "<a href='details?type=room&id=$value[id]
                    ' class='btn btn-sm w-100 btn-outline-dark shadow-none'>More Details</a>";
                    $html .= "</div>";
                    $html .= "</div>";
                    $html .= "</div>";
                    echo $html;


                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <?php require('inc/footer.php'); ?>

</body>

</html>