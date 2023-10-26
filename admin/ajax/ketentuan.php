<?php
require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'loadUmum') {

    $sql = "SELECT * FROM rule WHERE isGeneral = ?";

    $res = select($sql, [1], 'i');

    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    echo json_encode($data);

}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'tambahUmum') {
    $data = filteration($_POST);
    $description = $data['add_description'];

    $sql = "INSERT INTO rule (description, isGeneral) VALUES (?, ?)";
    $res = update($sql, [$description, 1], 'si');


    if ($res) {
        echo toast("success", "Data berhasil ditambahkan", "$deskripsi berhasil ditambahkan");
        redirect('ketentuan');
    } else {
        echo toast("error", "Data gagal ditambahkan", "$deskripsi gagal ditambahkan");
        redirect('ketentuan');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'editUmum') {
    $data = filteration($_POST);
    $id = $data['edit_id'];
    $description = $data['edit_description'];

    $sql = "UPDATE rule SET description = ? WHERE id = ?";
    $res = update($sql, [$description, $id], 'si');
    if ($res) {
        echo toast("success", "Data berhasil diubah", "Description : $description  ID : $id");
        redirect('ketentuan');
    } else {
        echo toast("error", "Data gagal diubah", "Description : $description  ID : $id");
        redirect('ketentuan');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'hapusUmum') {
    $data = filteration($_POST);
    $id = $data['hapus_id'];

    $sql = "DELETE FROM rule WHERE id =?";
    $res = update($sql, [$id], 'i');

    if ($res) {
        echo toast("success", "Data berhasil dihapus", "Data berhasil dihapus");
        redirect('ketentuan');
    } else {
        echo toast("error", "Data gagal dihapus", "Data gagal dihapus");
        redirect('ketentuan');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'loadKamar') {
    $sql = "SELECT * FROM ruleonroom";
    $res = select($sql, [], '');
    echo json_encode($res);
}

?>