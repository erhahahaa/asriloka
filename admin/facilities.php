<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - FASILITAS</title>


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
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">Data Fasilitas</h2>
        <!-- <p class="text-center mt-3">
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus odit architecto sunt ratione
            voluptate, fugit maxime odio animi asperiores deserunt harum, ipsam molestiae fuga numquam tenetur et labore
            aspernatur? Quas?
        </p> -->
    </div>

    <div class="container-fluid">

        <!-- Tambah Fasilitas -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle-fill"></i> Tambah Fasilitas
            </button>

            <!-- Modal Tambah Fasilitas-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" id="tambahFasilitasUmum" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="nama_fasilitas">Nama Fasilitas</label>
                                    <input type="text" class="form-control" id="nama_fasilitas" name="nama_fasilitas"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_fasilitas">Gambar</label>
                                    <input type="file" class="form-control" name="gambar_fasilitas"
                                        id="gambar_fasilitas" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi_fasilitas" name="deskripsi_fasilitas"
                                        required></textarea>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="flexCheckChecked">
                                        Umum?
                                    </label>
                                    <input class="form-check-input" type="checkbox" id="isGeneral" name="isGeneral"
                                        checked>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button id="add_fasilitas" type="submit" class="btn btn-primary"
                                        data-bs-dismiss="modal">Add Facility</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        <!-- Data Fasilitas -->
        <div class="card">
            <div class="card-header">
                <h6>Data Fasilitas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataX" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Umum</th>
                                <th class='w-25'>Gambar</th>
                                <th>Nama Fasilitas</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="fasilitasTable">


                            <!-- Modal Edit Fasilitas -->
                            <div class="modal fade" id="staticBackdropFasilitasEdit" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Fasilitas</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" id="editFasilitasUmum">
                                                <input type="hidden" name="edit_id" id="edit_id">

                                                <div class="form-group">
                                                    <label for="edit_nama">Nama Fasilitas</label>
                                                    <input type="text" class="form-control" id="edit_nama"
                                                        name="edit_nama" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_gambar">Gambar</label>
                                                    <input type="file" class="form-control" name="edit_gambar"
                                                        id="edit_gambar" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="edit_description">Deskripsi</label>
                                                    <textarea class="form-control" id="edit_description"
                                                        name="edit_description" required></textarea>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label" for="flexCheckChecked">
                                                        Umum?
                                                    </label>
                                                    <input class="form-check-input" type="checkbox" id="edit_isGeneral"
                                                        name="edit_isGeneral">
                                                </div>
                                                <button type="submit" name="edit" data-bs-dismiss="modal"
                                                    class="btn btn-primary w-100 mt-1">Simpan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Hapus Fasilitas -->
                            <div class="modal fade" id="staticBackdropFasilitasHapus" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus Fasilitas</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="POST" id="hapusFasilitasUmum">
                                            <div class="modal-body">
                                                Apa anda yakin menghapus fasilitas
                                                <div>
                                                    <span id="hapus_nama"></span> ?
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button"
                                                    data-dismiss="modal">Batal</button>
                                                <input type="hidden" id="hapus_id" name="hapus_id"></input>
                                                <button type="submit" name="hapus" data-bs-dismiss="modal"
                                                    class="btn btn-danger">Hapus</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>
    <!-- <script src="../assets/js/fasilitas.js"></script> -->
    <script>
        $(document).ready(function () {
            function loadFasilitasData() {
                $.ajax({
                    url: "ajax/fasilitas.php?action=loadUmum",
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        html = "";
                        for (var i = 0; i < data.length; i++) {
                            html += "<tr>";

                            html += "<td>" + (i + 1) + "</td>";
                            if (data[i].isGeneral == 1) {
                                html += "<td class='text-center'> <i class='bi bi-check-circle-fill text-success'></i></td>";
                            } else {
                                html += "<td class='text-center'> <i class='bi bi-x-circle-fill text-danger'></i></td>";
                            }
                            html +=
                                "<td class='w-25'> <img class='rounded img-thumbnail' src='./../assets/images/facility/" +
                                data[i].picture +
                                "' width='124' height='124'></td>";
                            html += "<td>" + data[i].name + "</td>";
                            html += "<td>" + data[i].description + "</td>";
                            html += "<td>";
                            html +=
                                "<button type='button' data-bs-toggle='modal' data-bs-target='#staticBackdropFasilitasEdit' class='btn btn-primary me-2 pop' data-id='" +
                                data[i].id +
                                "' data-name='" +
                                data[i].name +
                                "' data-isGeneral='" +
                                data[i].isGeneral +
                                "' data-description='" +
                                data[i].description +
                                "' data-picture='" +
                                data[i].picture +
                                "'>Edit</button>";
                            html +=
                                "<button type='button' data-bs-toggle='modal' data-bs-target='#staticBackdropFasilitasHapus' class='btn btn-danger pop' data-id='" +
                                data[i].id +
                                "' data-name='" +
                                data[i].name +
                                "' data-description='" +
                                data[i].description +
                                "'>Delete</button>";
                            html += "</td>";
                            html += "</tr>";

                        }
                        $("#fasilitasTable").html(html);
                    },
                });
            }
            loadFasilitasData();
            $(document).on(
                "click",
                "button[data-bs-target='#staticBackdropFasilitasEdit']",
                function () {
                    var name = $(this).data("name");
                    var description = $(this).data("description");
                    var images = $(this).data("picture");
                    var id = $(this).data("id");
                    var isGeneral = $(this).data("isgeneral");
                    $("#edit_nama").val(name);
                    $("#edit_description").val(description);
                    $("#edit_id").val(id);
                    $("#edit_image").val(images);
                    $("#edit_isGeneral").prop("checked", isGeneral == 1);
                }
            );
            $(document).on(
                "click",
                "button[data-bs-target='#staticBackdropFasilitasHapus']",
                function () {
                    var name = $(this).data("name");
                    var id = $(this).data("id");
                    $("#hapus_id").val(id);
                    $("#hapus_nama").text(name);
                }
            );
            $("#tambahFasilitasUmum").on("submit", function (e) {
                var formData = new FormData(this);
                e.preventDefault();
                $.ajax({
                    url: "ajax/fasilitas.php?action=tambahFasilitasUmum",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        $("#tambahFasilitasUmum")[0].reset();
                        loadFasilitasData();
                    },
                });
            });
            $("#editFasilitasUmum").on("submit", function (e) {
                var formData = new FormData(this);
                console.log(formData);
                e.preventDefault();
                $.ajax({
                    url: "ajax/fasilitas.php?action=editFasilitasUmum",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        $("#editFasilitasUmum")[0].reset();
                        loadFasilitasData();
                    },
                });
            });
            $("#hapusFasilitasUmum").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "ajax/fasilitas.php?action=hapusFasilitasUmum",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log(response);
                        $("#hapusFasilitasUmum")[0].reset();
                        loadFasilitasData();
                    },
                });
            });
        });

    </script>

</body>

</html>