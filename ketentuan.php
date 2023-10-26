<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asriloka - KETENTUAN</title>

    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Ketentuan</h2>
        <hr>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow">
                    <div class="row g-0 p-3 align-items-center">
                        <div class="col-md-12 px-lg-3 px-md-3 px-0">
                            <div class="features mb-3">
                                <h6 class="mb-1">Ketentuan</h6>
                                <ol>
                                    <?php

                                    $rule = new Rule();
                                    $res = $rule->getRuleByPublicity(1);

                                    foreach ($res as $r) {
                                        echo "<li>" . $r['description'] . "</li>";
                                    }
                                    ?>

                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/footer.php'); ?>

</body>

</html>