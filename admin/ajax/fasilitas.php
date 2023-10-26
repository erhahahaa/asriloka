<?php
require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';
include './../../app/model/Facility.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'loadUmum') {
    $sql = "SELECT * FROM facility";
    $res = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }

    echo json_encode($data);

}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'tambahFasilitasUmum') {
    $data = filteration($_POST);
    $name = $data['nama_fasilitas'];
    $description = $data['deskripsi_fasilitas'];
    $isGeneral = $data['isGeneral'];
    $pic = $_FILES['gambar_fasilitas']['name'];

    if ($isGeneral == 'on') {
        $isGeneral = 1;
    } else {
        $isGeneral = 0;
    }

    $sql = "INSERT INTO facility (name, description, picture, isGeneral) VALUES (?, ?, ?, ?)";
    $res = update($sql, [$name, $description, $pic, $isGeneral], 'sssi');
    if ($res) {
        $target_dir = './../../assets/images/facility/';
        $target_file = $target_dir . basename($_FILES["gambar_fasilitas"]["name"]);
        move_uploaded_file($_FILES["gambar_fasilitas"]["tmp_name"], $target_file);
        echo "Fasilitas Umum Berhasil Ditambahkan";
    } else {
        echo "Fasilitas Umum Gagal Ditambahkan";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'editFasilitasUmum') {
    $data = filteration($_POST);
    $id = $data['edit_id'];
    $name = $data['edit_nama'];
    $description = $data['edit_description'];
    $isGeneral = $data['edit_isGeneral'];
    $pic = $_FILES['edit_gambar']['name'];
    if ($isGeneral == 'on') {
        $isGeneral = 1;
    } else {
        $isGeneral = 0;
    }


    $sql = "UPDATE facility SET name = ?, description = ?, picture = ?, isGeneral = ? WHERE id = ?";
    $res = update($sql, [$name, $description, $pic, $isGeneral, $id], 'ssssi');
    if ($res) {
        $target_dir = './../../assets/images/facility/';
        $target_file = $target_dir . basename($_FILES["edit_gambar"]["name"]);
        move_uploaded_file($_FILES["edit_gambar"]["tmp_name"], $target_file);
        echo "Fasilitas Umum Berhasil Diubah";
    } else {
        echo "Fasilitas Umum Gagal Diubah";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'hapusFasilitasUmum') {
    $data = filteration($_POST);
    $id = $data['hapus_id'];



    $sql = "DELETE FROM facilityonbundling WHERE facilityId = ?";
    $res = update($sql, [$id], 'i');


    $sql = "DELETE FROM facilityonroom WHERE facilityId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM facility WHERE id = ?";
    $res = update($sql, [$id], 'i');

    if ($res) {
        echo "Fasilitas Umum Berhasil Dihapus";
    } else {
        echo "Fasilitas Umum Gagal Dihapus";
    }
}

?>