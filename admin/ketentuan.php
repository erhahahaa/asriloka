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
        <h2 class="fw-bold h-font text-center">Ketentuan</h2>
    </div>

    <!-- Ketentnuan Umum -->
    <div class="container-fluid">

        <!-- Tambah Fasilitas -->
        <div class="mb-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="bi bi-plus-circle-fill"></i> Tambah Ketentuan
            </button>

            <!-- Modal Tambah Fasilitas-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form method="POST" id="tambahKetentuanUmum">
                                <div class="form-group">
                                    <label for="add_description">Deskripsi</label>
                                    <textarea class="form-control" id="add_description" name="add_description"
                                        required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button name="close" id="close" type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button name="add_tambah" type="submit" class="btn btn-primary"
                                        data-bs-dismiss="modal">Save
                                        changes</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <!-- Data Ketentuan -->
        <div class="mb-4">
            <div class="card card-body">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Ketentuan</h6>
                    <!-- <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="dataKetentuanUmumSwitch"
                            data-bs-toggle="collapse" data-bs-target="#dataKetentuanUmumCollapse" aria-expanded="false"
                            aria-controls="dataKetentuanUmumCollapse">
                        <label class="form-check-label" for="dataKetentuanUmumSwitch"></label>
                    </div> -->
                </div>

                <div class="card-body " id="dataKetentuanUmumCollapse">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataKetentuan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="">No</th>
                                    <th class="w-75">Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="ketentuanTable">
                                <!-- Modal Edit Ketentuan -->
                                <div class="modal fade" id="staticBackdropUmumEdit" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit
                                                    Ketentuan
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" id="editKetentuanUmum">
                                                    <input type="hidden" id="edit_id" name="edit_id"></input>

                                                    <div class="form-group">
                                                        <label for="edit_description">Deskripsi</label>
                                                        <textarea class="form-control" id="edit_description"
                                                            name="edit_description" required></textarea>
                                                    </div>

                                                    <button type="submit" name="edit" data-bs-dismiss="modal"
                                                        class="btn btn-primary w-100 mt-1">Simpan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="staticBackdropUmumHapus" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Hapus
                                                    Fasilitas
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form method="POST" id="hapusKetentuanUmum">
                                                <input type="hidden" id="hapus_id" name="hapus_id"></input>
                                                <div class="modal-body">
                                                    Apa anda yakin menghapus ketentuan :
                                                    <div>
                                                        <span id="hapus_description"></span> ?
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button class="btn btn-secondary" type="button"
                                                        data-dismiss="modal">Batal</button>
                                                    <input type="hidden" name="id" value="">
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

        <!-- Ketentnuan Kamar -->


        <?php require('inc/scripts.php'); ?>
        <script src="../assets/js/ketentuan.js"></script>

</body>

</html>