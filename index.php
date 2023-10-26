<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asriloka - HOME</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <?php require('inc/links.php'); ?>

    <style>
        .avaibility-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .avaibility-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <!-- carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./assets/images/penginapan1.jpg" class="w-100 d-block">
                </div>
                <div class="swiper-slide">
                    <img src="./assets/images/slide2.jpg" class="w-100 d-block">
                </div>
                <div class="swiper-slide">
                    <img src="./assets/images/penginapan1.jpg" class="w-100 d-block">
                </div>
                <div class=" swiper-slide">
                    <img src="./assets/images/slide2.jpg" class="w-100 d-block">
                </div>
            </div>
        </div>
    </div>

    <!-- Check avaibility form -->

    <div class="container avaibility-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-4">Check Booking Availability</h5>
                <form action="rooms" method="POST">`;
                    <div class="row align-items-end">
                        <div class="col-lg-5 mb-3">
                            <label for="check_in" class="form-label" style="font-weight: 500">Check-in</label>
                            <input type="date" class="form-control shadow-none" id="check_in" name="check_in">
                        </div>
                        <div class="col-lg-5 mb-3">
                            <label for="check_out" class="form-label" style="font-weight: 500">Check-out</label>
                            <input type="date" class="form-control shadow-none" id="check_out" name="check_out">
                        </div>

                        <div class="col-lg-2 mb-lg-3 mt-2">
                            <button type="submit" class=" btn text-white shadow-none custom-bg">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Our Room / Penginapan -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Penginapan</h2>
    <div class="container">
        <div class="row">
            <?php

            $room = new Room();
            $rooms = $room->getRoom();

            // get room facility
            $facility = new Facility();
            foreach ($rooms as $key => $value) {
                $rooms[$key]['facility'] = $facility->getFacilityByRoomId($value['id']);

            }

            // get real facility data from database
            foreach ($rooms as $key => $value) {
                foreach ($value['facility'] as $k => $v) {
                    $rooms[$key]['facility'][$k] = $facility->getFacilityById($v['facilityId']);
                }
            }

            // get room capacity
            $capacity = new Capacity();
            foreach ($rooms as $key => $value) {
                $rooms[$key]['capacity'] = $capacity->getCapacityByRoomId($value['id']);
            }

            // get real capacity data from database
            foreach ($rooms as $key => $value) {
                foreach ($value['capacity'] as $k => $v) {
                    $rooms[$key]['capacity'][$k] = $capacity->getCapacityById($v['capacityId']);
                }
            }

            // get room picture
            $picture = new Picture();
            foreach ($rooms as $key => $value) {
                $rooms[$key]['picture'] = $picture->getPictureByRoomId($value['id']);
            }

            // get real picture data from database
            foreach ($rooms as $key => $value) {
                foreach ($value['picture'] as $k => $v) {
                    $rooms[$key]['picture'][$k] = $picture->getPictureById($v['pictureId']);
                }
            }

            // get rule on room
            $rule = new Rule();
            foreach ($rooms as $key => $value) {
                $rooms[$key]['rule'] = $rule->getRuleByRoomId($value['id']);
            }

            // get real rule data from database
            foreach ($rooms as $key => $value) {
                foreach ($value['rule'] as $k => $v) {
                    $rooms[$key]['rule'][$k] = $rule->getRuleById($v['ruleId']);
                }
            }

            ?>
            <?php foreach ($rooms as $r): ?>
                <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <!-- carousel -->
                        <div style="height: 200px; overflow: hidden;">
                            <div id="carouselExampleControls<?= $r['id'] ?>" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($r['picture'] as $key => $value): ?>
                                        <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                            <img src="./assets/images/room/<?= $value[0]['name'] ?>" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleControls<?= $r['id'] ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleControls<?= $r['id'] ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <h5>
                                <?= $r['name'] ?>
                            </h5>
                            <h6 class="mb-4">Rp
                                <?= number_format($r['price'], 0, ',', '.') ?> / night
                            </h6>
                            <div class="facilities mb-4">
                                <h6 class="mb-1">Fasilitas</h6>
                                <?php foreach ($r['facility'] as $key => $value): ?>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                        <?= $value[0]['name'] ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                            <div class="guests mb-4">
                                <h6 class="mb-1">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    <?= $r['capacity'][0][0]['description'] ?>
                                </span>
                            </div>

                            <div class="d-flex justify-content-evenly mb-2s">
                                <a href='details?type=room&id=<?= $r['id'] ?>'
                                    class='btn btn-sm text-white custom-bg shadow-none'>Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
    </div>

    <!-- Fasilitas -->

    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Fasilitas</h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">

            <?php
            $sql = "SELECT * FROM facility WHERE isGeneral = ?";
            $res = select($sql, [1], 'i');

            foreach ($res as $row) {
                echo "<div class='col-lg-4 col-md-4 mb-4'>";
                echo "<div class='card h-100 bg-white rounded shadow'>";
                echo "<img src='./assets/images/facility/" . $row['picture'] . "' class='card-img-top' alt='" . $row['name'] . "'>";
                echo "<div class='card-body text-center'>";
                echo "<h5 class='card-title'>" . $row['name'] . "</h5>";
                if (isset($row['description']) && !empty($row['description'])) { // Check if description exists and is not empty
                    echo "<p class='card-text'>" . $row['description'] . "</p>";
                }
                echo "</div>"; // end card-body
                echo "</div>"; // end card
                echo "</div>"; // end column
            }
            ?>

        </div>
    </div>


    <!-- Testimoni -->

    <!-- <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Review</h2>
    <div class="contaier mt-5">
        <div class="swiper swiper-testimoni">
            <div class="swiper-wrapper">
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/slide2.jpg" width="30px">
                        <h6 class="m-0 ms-2">Random user1</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo neque voluptate iste modi vel
                        praesentium officiis enim rem, rerum voluptatum iure soluta, eius magnam animi velit
                        perspiciatis? Cum, id nihil?
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/slide2.jpg" width="30px">
                        <h6 class="m-0 ms-2">Random user1</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo neque voluptate iste modi vel
                        praesentium officiis enim rem, rerum voluptatum iure soluta, eius magnam animi velit
                        perspiciatis? Cum, id nihil?
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
                <div class="swiper-slide bg-white p-4">
                    <div class="profile d-flex align-items-center mb-3">
                        <img src="images/slide2.jpg" width="30px">
                        <h6 class="m-0 ms-2">Random user1</h6>
                    </div>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo neque voluptate iste modi vel
                        praesentium officiis enim rem, rerum voluptatum iure soluta, eius magnam animi velit
                        perspiciatis? Cum, id nihil?
                    </p>
                    <div class="rating">
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                        <i class="bi bi-star-fill text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pahination"></div>
    </div>
    <div class="co-lg-12 text-center mt-5">
        <a href="#" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">Know More >>></a>
    </div> -->

    <!-- Reach Us -->
    <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Reach Us</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white rounded">
                <iframe class="w-100 rounded" height="320"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.8005102408815!2d112.36837287391936!3d-7.704544676310731!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7865cfa750407b%3A0xb421ef31b6eb0c0b!2sAsriloka%20Wonosalam!5e0!3m2!1sid!2sid!4v1693028552110!5m2!1sid!2sid"
                    style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="bg-white p-4 rounded mb-4">
                    <h3 class="h-font fw-bold fs-3 mb-2">Asriloka Wonosalam</h3>
                    <p>Asriloka Wonosalam merupakan salah satu provider outbound terbaik di Wonosalam yang memfokuskan
                        pelatihan
                        pengembangan sumber daya manusia dengan program yang bisa disesuaikan dengan permintaan klien.
                        Kami
                        memiliki tim dan fasilitator yng sudah profesional dan berpengalaman dalam bidangnya.</p>
                </div>
                <div class="bg-white p-4 rounded mb-4">
                    <h5>
                        Call Us
                    </h5>
                    <a href="https://www.instagram.com/asriloka.wonosalam/"
                        class="d-inline-block text-dark text-decoration-none mb-2">
                        <span class="badge bg-light rounded-circle text-dark fs-1 p-2">
                            <i class="bi bi-instagram me-1"></i>
                        </span>
                    </a>
                    <a href="http://wa.me/+6281234988894" class="d-inline-block text-dark text-decoration-none mb-2">
                        <span class="badge bg-light rounded-circle text-dark fs-1 p-2">
                            <i class="bi bi-whatsapp me-1"></i>
                        </span>
                    </a>
                    <a href="https://l.wl.co/l?u=https%3A%2F%2Fyoutube.com%2F%40asrilokawonosalam2111"
                        class="d-inline-block text-dark text-decoration-none mb-2">
                        <span class="badge bg-light rounded-circle text-dark fs-1 p-2">
                            <i class="bi bi-youtube me-1"></i>
                        </span>
                    </a>
                    <a href="https://www.tiktok.com/@asriloka.wonosalam?_t=8f9aODQXp5O&_r=1"
                        class="d-inline-block text-dark text-decoration-none">
                        <span class="badge bg-light rounded-circle text-dark fs-1 p-2">
                            <i class="bi bi-tiktok me-1"></i>
                        </span>
                    </a>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>



    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effct: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });


        var swiper = new Swiper(".swiper-testimoni", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true,
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadow: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    </script>
</body>

</html>