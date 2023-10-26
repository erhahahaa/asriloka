<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - PERUSAHAANS</title>

    <?php require('inc/links.php'); ?>

</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Paket Perusahaan</h2>
    </div>

    <div class="container-fluid"> <button type="button" class="btn btn-primary my-2" data-bs-toggle="modal"
            data-bs-target="#addRoom">
            <i class="bi bi-plus-circle-fill"></i> Tambah Paket Perusahaan
        </button>
        <div class="col-lg-12 ">
            <div class="row">
                <div class="modal" id="addRoom">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Penginapan</h4>
                                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                                <form action="" id="tambahBundlingPERUSAHAAN">
                                    <div class="card">
                                        <div class="card-header">
                                            Paket Perusahaan
                                        </div>
                                        <div class="card-body">
                                            <input type="hidden" name="id">
                                            <div class="form-group">
                                                <label class="control-label">Ketersediaan</label>
                                                <div class="form-check form-switch">
                                                    <label class="form-check-label" for="isReady">No / Ready</label>
                                                    <input class="form-check-input" type="checkbox" name="isReady"
                                                        id="isReady">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Paket</label>
                                                <input type="text" class="form-control" name="bundling_name"
                                                    id="bundling_name">
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Harga</label>
                                                <input type="number" class="form-control text-right"
                                                    name="bundling_price" name="bundling_price">
                                            </div>
                                            <label class="control-label">Fasilitas</label>
                                            <div class="form-check" id="bundling_facility">
                                                <!-- Add content for Fasilitas -->
                                            </div> <label class="control-label">Ketentuan</label>
                                            <div class="form-check" id="bundling_rule">
                                                <!-- Add content for Ketentuan -->
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="control-label">Gambar</label>
                                                <input type="file" class="form-control" name="bundling_gambar[]"
                                                    id="bundling_gambar" multiple>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3">
                                                        Save</button>
                                                    <button class="btn btn-sm btn-default col-sm-3" type="button"
                                                        onclick="$('#manage-category').get(0).reset()"> Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button class="btn btn-sm btn-primary  " name="add_room" type="submit"> Save</button>
                                <button class="btn btn-sm btn-default" type="button"
                                    onclick="$('#manage-category').get(0).reset()">
                                    Cancel</button>
                            </div>

                        </div>
                    </div>
                </div>


                <!-- Table Panel -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ketersediaan</th>
                                        <th class="text-center">Paket</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Ketentuan</th>
                                        <th class="text-center">Fasilitas</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="bundling_table">


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal Edit Fasilitas -->
                <div class="modal fade" id="staticBackdropBundlingEdit" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Bundling</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" id="editBundling" enctype="multipart/form-data">
                                    <div class="card">

                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="control-label">Ketersediaan</label>
                                                <div class="form-check form-switch" id="edit_isReady>
                                                    <label class=" form-check-label" for="edit_isReady">No /
                                                    Ready</label>
                                                    <input class="form-check-input" type="checkbox" name="edit_isReady"
                                                        id="edit_isReady">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Nama</label>
                                                <input type="text" class="form-control" name="edit_nama" id="edit_nama"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Harga</label>
                                                <input type="number" class="form-control text-right" name="edit_price"
                                                    id="edit_price">
                                            </div>
                                            <label class="control-label">Fasilitas</label>
                                            <div class="form-check" id="edit_room_facility">
                                                <!-- Add content for Fasilitas -->
                                            </div>

                                            <label class="control-label">Ketentuan</label>
                                            <div class="form-check" id="edit_room_rule">
                                                <!-- Add content for Ketentuan -->
                                            </div>
                                            <div class="form-group" id="edit_gambar">
                                                <label for="edit_image" class="control-label">Gambar</label>
                                                <input type="file" class="form-control" name="edit_image[]"
                                                    id="edit_image" accept="image/*" multiple>
                                            </div>
                                            <input type="hidden" id="edit_id" name="edit_id"></input>
                                        </div>

                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"
                                                        name="add_room" data-bs-dismiss="modal" type="submit">
                                                        Save</button>
                                                    <button class="btn btn-sm btn-default col-sm-3" type="button"
                                                        data-bs-dismiss="modal"
                                                        onclick="$('#manage-category').get(0).reset()"> Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Hapus Fasilitas -->
                <div class="modal fade" id="staticBackdropBundlingHapus" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Fasilitas</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" id="hapusBundling">
                                <div class="modal-body">
                                    Apa anda yakin menghapus fasilitas
                                    <div>
                                        <span id="hapus_nama"></span> ?
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                                    <input type="hidden" id="hapus_id" name="hapus_id"></input>
                                    <button type="submit" name="hapus" data-bs-dismiss="modal"
                                        class="btn btn-danger">Hapus</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>

            <br>
            <!-- Form Panel -->



        </div>
    </div>
    <?php require('inc/scripts.php'); ?>
    <script>$(document).ready(function () {
            loadKetentuanData();
            loadFasilitasData();
            function loadKetentuanData() {
                $.ajax({
                    url: "ajax/ketentuan.php?action=loadUmum",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            html += "<div class='form-check'>";
                            html +=
                                "<input class='form-check-input' type='checkbox' value='" +
                                data[i].id +
                                "' id='rule" +
                                data[i].id +
                                "' name='rule[]'>";
                            html +=
                                "<label class='form-check-label' for='rule" +
                                data[i].id +
                                "'>" +
                                data[i].description +
                                "</label>";
                            html += "</div>";
                        }
                        loadPERUSAHAAN();
                        $("#bundling_rule").html(html);
                    },
                });
            }
            function loadFasilitasData() {
                $.ajax({
                    url: "ajax/fasilitas.php?action=loadUmum",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        var html = "";
                        for (var i = 0; i < data.length; i++) {
                            html += "<div class='form-check'>";
                            html +=
                                "<input class='form-check-input' type='checkbox' value='" +
                                data[i].id +
                                "' id='facility" +
                                data[i].id +
                                "' name='facility[]'>";
                            html +=
                                "<label class='form-check-label' for='facility" +
                                data[i].id +
                                "'>" +
                                data[i].name +
                                "</label>";
                            html += "</div>";
                        }
                        $("#bundling_facility").html(html);
                    },
                });
            }

            function loadPERUSAHAAN() {
                console.log("loadPERUSAHAAN");
                $.ajax({
                    url: "ajax/bundling.php?action=loadPERUSAHAAN",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        var html = "";
                        var isReady = 0;
                        for (var i = 0; i < data.length; i++) {
                            html += "<tr>";
                            if (data[i].isReady == 1) {
                                isReady = 1;
                                html +=
                                    "<td class='text-center'><i class='bi bi-check-circle-fill'></i></td>";
                            } else {
                                isReady = 0;
                                html +=
                                    "<td class='text-center'><i class='bi bi-x-circle-fill'></i></td>";
                            }
                            html += "<td>" + data[i].name + "</td>";

                            html += "<td class='text-center'>";
                            html += "<div class='carousel slide' data-ride='carousel' id='carousel" + i + "'>";
                            html += "<div class='carousel-inner'>";
                            html += "<div class='carousel-item active'>";
                            html += "<img class='d-block w-100' src='./../assets/images/bundling/" + data[i].picture[0].name + "' alt='First slide'>";
                            html += "</div>";
                            for (var j = 1; j < data[i].picture.length; j++) {
                                html += "<div class='carousel-item'>";
                                html += "<img class='d-block w-100 carousel-img' src='./../assets/images/bundling/" + data[i].picture[j].name + "' alt='Slide'>";
                                html += "</div>";
                            }
                            html += "</div>";
                            html += "<button class='carousel-control-prev' type='button' data-bs-target='#carousel" + i + "' data-bs-slide='prev'>";
                            html += "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                            html += "<span class='visually-hidden'>Previous</span>";
                            html += "</button>";
                            html += "<button class='carousel-control-next' type='button' data-bs-target='#carousel" + i + "' data-bs-slide='next'>";
                            html += "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                            html += "<span class='visually-hidden'>Next</span>";
                            html += "</button>";
                            html += "</div>";
                            html += "</td>";

                            html += "<td>" + data[i].price + "</td>";
                            html += "<td><ul>";
                            for (var j = 0; j < data[i].rule.length; j++) {
                                html += "<li class=''>" + data[i].rule[j].description + "</li>";
                            }
                            html += "</ul></td>";

                            html += "<td><ul>";
                            for (var j = 0; j < data[i].facility.length; j++) {
                                html +=
                                    "<li class=''><i class=''></i> " +
                                    data[i].facility[j].name +
                                    "</li>";
                            }
                            html += "</ul></td>";
                            html += "<td>";
                            html += "<button type='button' class='btn btn-primary me-2' ";
                            html +=
                                "data-bs-toggle='modal' data-bs-target='#staticBackdropBundlingEdit'";
                            html += "data-id='" + data[i].id + "'";
                            html += "data-name='" + data[i].name + "'";
                            html += "data-price='" + data[i].price + "'";
                            html += "data-isReady-val='" + isReady + "'";
                            html += "data-picture='" + data[i].picture + "'";
                            html += "data-rule-id='";
                            for (var j = 0; j < data[i].rule.length; j++) {
                                html += data[i].rule[j].id + ",";
                            }
                            html += "'";
                            html += "data-facility-id='";
                            for (var j = 0; j < data[i].facility.length; j++) {
                                html += data[i].facility[j].id + ",";
                            }
                            html += "'";
                            html += ">Edit</button>";
                            html += "<button type='button' class='btn btn-danger' ";
                            html +=
                                "data-bs-toggle='modal' data-bs-target='#staticBackdropBundlingHapus'";
                            html += "data-id='" + data[i].id + "'";
                            html += "data-name='" + data[i].name + "'";
                            html += ">Delete</button>";
                            html += "</td>";

                            html += "</tr>";
                        }
                        $("#bundling_table").html(html);
                        for (var i = 0; i < data.length; i++) {
                            $("#carousel" + i).carousel();
                        }
                    },
                });
            }

            $(document).on(
                "click",
                "button[data-bs-target='#staticBackdropBundlingEdit']",
                function () {
                    var name = $(this).data("name");
                    var price = $(this).data("price");
                    var id = $(this).data("id");
                    var facilitiesId = $(this).data("facility-id");
                    var rulesId = $(this).data("rule-id");
                    var isReady = $(this).data("isready-val");
                    console.log(isReady);
                    $("#edit_id").val(id);
                    $("#edit_nama").val(name);
                    $("#edit_price").val(price);
                    if (isReady == 1) {
                        $("#edit_isReady").html(
                            "<label class='form-check-label' for='edit_isReady'>No / Ready</label> <input class='form-check-input' type='checkbox' value='1' id='edit_isReady' name='edit_isReady' checked>"
                        );
                    } else {
                        $("#edit_isReady").html(
                            "<label class='form-check-label' for='edit_isReady'>No / Ready</label> <input class='form-check-input' type='checkbox' value='1' id='edit_isReady' name='edit_isReady'>"
                        );
                    }

                    $.ajax({
                        url: "ajax/fasilitas.php?action=loadUmum",
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            var html = "";
                            for (var i = 0; i < data.length; i++) {
                                html += "<div class='form-check'>";
                                html +=
                                    "<input class='form-check-input' type='checkbox' value='" +
                                    data[i].id +
                                    "' id='edit_facility" +
                                    data[i].id +
                                    "' name='edit_facility[]'";
                                if (facilitiesId.includes(data[i].id)) {
                                    html += "checked";
                                }
                                html += ">";
                                html +=
                                    "<label class='form-check-label' for='edit_facility" +
                                    data[i].id +
                                    "'>" +
                                    data[i].name +
                                    "</label>";
                                html += "</div>";
                            }
                            $("#edit_room_facility").html(html);
                        },
                    });
                    // get list rules and check the selected one
                    $.ajax({
                        url: "ajax/ketentuan.php?action=loadUmum",
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            var html = "";
                            for (var i = 0; i < data.length; i++) {
                                html += "<div class='form-check'>";
                                html +=
                                    "<input class='form-check-input' type='checkbox' value='" +
                                    data[i].id +
                                    "' id='edit_rule" +
                                    data[i].id +
                                    "' name='edit_rule[]'";
                                if (rulesId.includes(data[i].id)) {
                                    html += "checked";
                                }
                                html += ">";
                                html +=
                                    "<label class='form-check-label' for='edit_rule" +
                                    data[i].id +
                                    "'>" +
                                    data[i].description +
                                    "</label>";
                                html += "</div>";
                            }
                            $("#edit_room_rule").html(html);
                        },
                    });
                }
            );

            $(document).on(
                "click",
                "button[data-bs-target='#staticBackdropBundlingHapus']",
                function () {
                    var name = $(this).data("name");
                    var id = $(this).data("id");
                    $("#hapus_id").val(id);
                    $("#hapus_nama").text(name);
                }
            );

            $("#tambahBundlingPERUSAHAAN").on("submit", function (e) {
                e.preventDefault();

                var formData = new FormData(this);
                var selectedKetentuan = [];
                $("input[name='rule[]']:checked").each(function () {
                    selectedKetentuan.push($(this).val());
                });

                var selectedFasilitas = [];
                $("input[name='facility[]']:checked").each(function () {
                    selectedFasilitas.push($(this).val());
                });
                if (selectedKetentuan.length > 0) {
                    formData.append("selected_ketentuan", selectedKetentuan);
                }

                if (selectedFasilitas.length > 0) {
                    formData.append("selected_fasilitas", selectedFasilitas);
                }
                $.ajax({
                    url: "ajax/bundling.php?action=tambahBundlingPERUSAHAAN",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log(response);
                        $("#tambahBundlingPERUSAHAAN")[0].reset();
                        loadPERUSAHAAN();
                    },
                });
            });

            $("#editBundling").on("submit", function (e) {
                e.preventDefault();

                var formData = new FormData(this);

                var selectedKetentuan = [];
                $("input[name='edit_rule[]']:checked").each(function () {
                    selectedKetentuan.push($(this).val());
                });

                var selectedFasilitas = [];
                $("input[name='edit_facility[]']:checked").each(function () {
                    selectedFasilitas.push($(this).val());
                });
                var selectedCapacity = $("input[name='edit_capacity']:checked").val();
                if (selectedKetentuan.length > 0) {
                    formData.append("selected_ketentuan", selectedKetentuan);
                }

                if (selectedFasilitas.length > 0) {
                    formData.append("selected_fasilitas", selectedFasilitas);
                }

                if (selectedCapacity !== undefined) {
                    formData.append("selected_capacity", selectedCapacity);
                }


                if (formData.get("edit_image") != []) {
                    $.ajax({
                        url: "ajax/bundling.php?action=editBundlingPERUSAHAAN",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(JSON.stringify(response) + "\n");

                            loadPERUSAHAAN();
                            $("#editBundling")[0].reset();
                        },
                    });
                } else {
                    return "Image is empty";
                }
            });
            $("#hapusBundling").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "ajax/bundling.php?action=hapusBundlingPERUSAHAAN",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log(response);
                        loadPERUSAHAAN();
                    },
                });
            });
        });
    </script>

</body>

</html>