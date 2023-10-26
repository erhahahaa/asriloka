<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AW - FACILITIES</title>


    <?php require('inc/links.php'); ?>

    <style>
        .pop:hover {
            border-top-color: var(--teal) !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }
    </style>

</head>

<body class="bg-light">
    <?php require('inc/header.php');
    $facility = new Facility();
    $facilties = $facility->getFacilityByPublicity(1);
    ?>
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Fasilitas</h2>
        <hr>
        <!-- <p class="text-center mt-3">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus odit architecto sunt ratione
            voluptate, fugit maxime odio animi asperiofacilties deserunt harum, ipsam molestiae fuga numquam tenetur et
            labore
            aspernatur? Quas?
        </p> -->
    </div>

    <div class="container">
        <div class="row">

            <?php foreach ($facilties as $r): ?>
                <div class='col-lg-4 col-md-6 mb-5 px-4'>
                    <div class='bg-white rounded shadow p-4 border-top border-4 border-dark pop'>
                        <div class='d-flex align-items-center mb-2'>
                            <img src='assets/images/facility/<?= $r['picture'] ?>' alt='<?= $r['name'] ?>' height='40px'>
                            <h5 class='m-0 ms-3'>
                                <?= $r['name'] ?>
                            </h5>
                        </div>
                        <p>
                            <?= $r['description'] ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>


        </div>
    </div>

    <?php require('inc/footer.php'); ?>

</body>

</html>