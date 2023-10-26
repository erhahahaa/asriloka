<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asriloka - PAKET CAMP</title>

    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Paket Camp</h2>
        <hr>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 px-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 px-4">
                            <?php
                            $sql = "SELECT * FROM bundling WHERE type='CAMP'";
                            $res = mysqli_query($conn, $sql);
                            $bundling = [];
                            while ($row = mysqli_fetch_assoc($res)) {
                                $bundling[] = $row;
                            }
                            foreach ($bundling as $key => $value) {

                                $sql = "SELECT * FROM facilityonbundling WHERE bundlingId = ?";
                                $res = select($sql, [$value['id']], 'i');
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $facility[] = $row;
                                }
                                $bundling[$key]['facility'] = $facility;
                                $facility = [];
                            }
                            foreach ($bundling as $key => $value) {
                                foreach ($value['facility'] as $k => $v) {
                                    $sql = "SELECT * FROM facility WHERE id = ?";
                                    $res = select($sql, [$v['facilityId']], 'i');
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $facility[] = $row;
                                    }
                                }
                                $bundling[$key]['facility'] = $facility;
                                $facility = [];
                            }

                            foreach ($bundling as $key => $value) {
                                $sql = "SELECT * FROM pictureonbundling WHERE bundlingId = ?";
                                $res = select($sql, [$value['id']], 'i');
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $picture[] = $row;
                                }
                                $bundling[$key]['picture'] = $picture;
                                $picture = [];
                            }
                            foreach ($bundling as $key => $value) {
                                foreach ($value['picture'] as $k => $v) {
                                    $sql = "SELECT * FROM picture WHERE id = ?";
                                    $res = select($sql, [$v['pictureId']], 'i');
                                    while ($row = mysqli_fetch_assoc($res)) {
                                        $picture[] = $row;
                                    }
                                }
                                $bundling[$key]['pictures'] = $picture;
                                $picture = [];
                            }


                            foreach ($bundling as $key => $value) {
                                // echo name, price, facility, and picture carousel as HTML
                                $html = "<div class='card mb-4 border-0 shadow'>";
                                $html .= "<div class='row g-0 p-3 align-items-center'>";
                                $html .= "<div class='col-md-5 mb-lg-0 mb-md-0 mb-3'>";
                                $html .= "<div id='carousel$value[id]' class='carousel slide'>";
                                $html .= "<div class='carousel-indicators'>";

                                // Output carousel indicators
                                for ($i = 0; $i < count($value['pictures']); $i++) {
                                    $activeClass = ($i === 0) ? 'active' : '';
                                    $html .= "<button type='button' data-bs-target='#carousel$value[id]' data-bs-slide-to='$i' class='$activeClass' aria-current='true' aria-label='Slide $i'></button>";
                                }

                                $html .= "</div>";
                                $html .= "<div class='carousel-inner'>";

                                // Output carousel images
                                foreach ($value['pictures'] as $i => $picture) {
                                    $activeClass = ($i === 0) ? 'active' : '';
                                    $html .= "<div class='carousel-item $activeClass'>";
                                    $html .= "<img src='./assets/images/bundling/{$picture['name']}' class='d-block w-100' alt='...'>";
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
                                $html .= "<h6 class='mb-1'>Fasilitas Khusus</h6>";
                                foreach ($value['facility'] as $facility) {
                                    $html .= "<span class='badge rounded-pill bg-light text-dark text-wrap'>";
                                    $html .= $facility['name'];
                                    $html .= "</span>";
                                }
                                $html .= "</div>";
                                $html .= "</div>";
                                $html .= "<div class='col-md-3 text-center'>";
                                $html .= "<h6 class='mb-4'>Rp $value[price]/malam</h6>";
                                $html .= "<a href='details?type=paketCAMP&id=$value[id]' class='btn btn-primary'>Book Now</a>";
                                $html .= "</div>";
                                $html .= "</div>";
                                $html .= "</div>";
                                echo $html;
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

</body>

</html>