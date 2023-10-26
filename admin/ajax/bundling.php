<?php
require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['action'])) {
    $type = substr($_REQUEST['action'], 4);
    $sql = "SELECT * FROM bundling WHERE type='$type'";
    $res = mysqli_query($conn, $sql);
    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }

    $facility = [];
    $rule = [];
    $picture = [];

    foreach ($data as $key => $value) {
        $sql = "SELECT * FROM facilityonbundling WHERE bundlingId = ?";
        $res = select($sql, [$value['id']], 'i');
        while ($row = mysqli_fetch_assoc($res)) {
            $facility[] = $row;
        }
        $data[$key]['facility'] = $facility;
        $facility = [];

        $sql = "SELECT * FROM ruleonbundling WHERE bundlingId = ?";
        $res = select($sql, [$value['id']], 'i');
        while ($row = mysqli_fetch_assoc($res)) {
            $rule[] = $row;
        }
        $data[$key]['rule'] = $rule;
        $rule = [];
    }
    foreach ($data as $key => $value) {
        foreach ($value['facility'] as $k => $v) {
            $sql = "SELECT * FROM facility WHERE id = ?";
            $res = select($sql, [$v['facilityId']], 'i');
            while ($row = mysqli_fetch_assoc($res)) {
                $facility[] = $row;
            }
        }
        $data[$key]['facility'] = $facility;
        $facility = [];
    }

    foreach ($data as $key => $value) {
        foreach ($value['rule'] as $k => $v) {
            $sql = "SELECT * FROM rule WHERE id = ?";
            $res = select($sql, [$v['ruleId']], 'i');
            while ($row = mysqli_fetch_assoc($res)) {
                $rule[] = $row;
            }
        }
        $data[$key]['rule'] = $rule;
        $rule = [];
    }

    foreach ($data as $key => $value) {
        $sql = "SELECT * FROM pictureonbundling WHERE bundlingId = ?";
        $res = select($sql, [$value['id']], 'i');
        while ($row = mysqli_fetch_assoc($res)) {
            $picture[] = $row;
        }
        $data[$key]['picture'] = $picture;
        $picture = [];
    }

    foreach ($data as $key => $value) {
        foreach ($value['picture'] as $k => $v) {
            $sql = "SELECT * FROM picture WHERE id = ?";
            $res = select($sql, [$v['pictureId']], 'i');
            while ($row = mysqli_fetch_assoc($res)) {
                $picture[] = $row;
            }
        }
        $data[$key]['picture'] = $picture;
        $picture = [];
    }
    echo json_encode($data);
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) &&
    substr($_REQUEST['action'], 0, 14) === 'tambahBundling'
) {

    $type = substr($_REQUEST['action'], 14);
    $data = $_POST;
    $name = $data['bundling_name'];
    $harga = $data['bundling_price'];
    $isReady = 0;
    $picture = [];
    if (isset($data['isReady']) && $data['isReady'] == 'on') {
        $isReady = 1;
    } else {
        $isReady = 0;
    }
    if (isset($_FILES['bundling_gambar'])) {

        $target_dir = './../../assets/images/bundling/';
        foreach ($_FILES['bundling_gambar']['name'] as $key => $value) {
            $target_file = $target_dir . basename($_FILES["bundling_gambar"]["name"][$key]);
            $check = getimagesize($_FILES["bundling_gambar"]["tmp_name"][$key]);

            if ($check !== false) {
                if (move_uploaded_file($_FILES["bundling_gambar"]["tmp_name"][$key], $target_file)) {
                    $sql = "INSERT INTO picture (name) VALUES (?)";
                    $res = update($sql, [$value], 's');
                    $picture[] = $value;
                }
            }
        }
    }

    $sql = "INSERT INTO bundling (name, price, isReady,type) VALUES (?, ?, ?, ?)";
    $res = update($sql, [$name, $harga, $isReady, $type], 'siis');
    $sql = "SELECT * FROM bundling ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $bundling = $row['id'];


    foreach ($picture as $key => $value) {
        $sql = "SELECT * FROM picture WHERE name = ?";
        $res = select($sql, [$value], 's');
        $row = mysqli_fetch_assoc($res);
        $picture[$key] = $row['id'];
    }

    $sql = "INSERT INTO pictureonbundling (bundlingId, pictureId) VALUES (?, ?)";
    foreach ($picture as $key => $value) {
        $res = update($sql, [$bundling, $value], 'ii');
    }

    if (isset($data['selected_fasilitas']) && !empty($data['selected_fasilitas'])) {
        echo "F set";
        $facility = $data['selected_fasilitas'];
        if ($facility != '' || $facility != 'undefined') {
            $facility = explode(',', $facility);
            if (count($facility) > 0) {
                foreach ($facility as $key => $value) {
                    $sql = "INSERT INTO facilityonbundling (bundlingId, facilityId) VALUES (?, ?)";
                    $res = update($sql, [$bundling, $value], 'ii');
                }
            }
        }
    }
    if (isset($data['selected_ketentuan']) && !empty($data['selected_ketentuan'])) {
        $rule = $data['selected_ketentuan'];
        if ($rule != '' || $rule != 'undefined') {
            $rule = explode(',', $rule);
            if (count($rule) > 0) {
                foreach ($rule as $key => $value) {
                    $sql = "INSERT INTO ruleonbundling (bundlingId, ruleId) VALUES (?, ?)";
                    $res = update($sql, [$bundling, $value], 'ii');
                }
            }
        }
    }
}


if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) &&
    substr($_REQUEST['action'], 0, 13) === 'hapusBundling'
) {
    $data = $_POST;
    $id = $data['hapus_id'];

    $sql = "DELETE FROM pictureonbundling WHERE bundlingId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM facilityonbundling WHERE bundlingId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM ruleonbundling WHERE bundlingId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM bundling WHERE id = ?";
    $res = update($sql, [$id], 'i');

    if ($res) {
        echo "Kamar Berhasil Dihapus\n";
    } else {
        echo "Kamar Gagal Dihapus";
    }
}

if (
    $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) &&
    substr($_REQUEST['action'], 0, 12) === 'editBundling'
) {
    $type = substr($_REQUEST['action'], 12);
    $data = $_POST;
    $id = $data['edit_id'];
    $name = $data['edit_nama'];
    $price = $data['edit_price'];
    $isReady = 0;
    $picture = [];
    if (isset($data['edit_isReady']) && $data['edit_isReady'] == 'on') {
        $isReady = 1;
    }

    $sql = "UPDATE bundling SET name = ?, price = ?, isReady = ?, type = ? WHERE id = ?";
    $res = update($sql, [$name, $price, $isReady, $type, $id], 'siisi');
    if ($res) {
        echo "Kamar Berhasil Diubah\n";
    } else {
        echo "Kamar Gagal Diubah";
    }

    $sql = "DELETE FROM pictureonbundling WHERE bundlingId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM facilityonbundling WHERE bundlingId = ?";
    $res = update($sql, [$id], 'i');


    $sql = "DELETE FROM ruleonbundling WHERE bundlingId = ?";
    $res = update($sql, [$id], 'i');

    if (isset($data['selected_fasilitas']) && !empty($data['selected_fasilitas'])) {
        echo "F set";
        $facility = $data['selected_fasilitas'];
        if ($facility != '' || $facility != 'undefined') {
            $facility = explode(',', $facility);
            if (count($facility) > 0) {
                foreach ($facility as $key => $value) {
                    $sql = "INSERT INTO facilityonbundling (bundlingId, facilityId) VALUES (?, ?)";
                    $res = update($sql, [$id, $value], 'ii');
                }
            }
        }
    }

    if (isset($data['selected_ketentuan']) && !empty($data['selected_ketentuan'])) {
        $rule = $data['selected_ketentuan'];
        if ($rule != '' || $rule != 'undefined') {
            $rule = explode(',', $rule);
            if (count($rule) > 0) {
                foreach ($rule as $key => $value) {
                    $sql = "INSERT INTO ruleonbundling (bundlingId, ruleId) VALUES (?, ?)";
                    $res = update($sql, [$id, $value], 'ii');
                }
            }
        }
    }
    if (isset($_FILES['edit_image']) && !empty($_FILES['edit_image'])) {
        $target_dir = './../../assets/images/bundling/';
        foreach ($_FILES['edit_image']['name'] as $key => $value) {
            $target_file = $target_dir . basename($_FILES["edit_image"]["name"][$key]);
            $check = getimagesize($_FILES["edit_image"]["tmp_name"][$key]);

            if ($check !== false) {
                if (move_uploaded_file($_FILES["edit_image"]["tmp_name"][$key], $target_file)) {
                    $sql = "INSERT INTO picture (name) VALUES (?)";
                    $res = update($sql, [$value], 's');
                    $picture[] = $value;
                }
            }
        }

        foreach ($picture as $key => $value) {
            $sql = "SELECT * FROM picture WHERE name = ?";
            $res = select($sql, [$value], 's');
            $row = mysqli_fetch_assoc($res);
            $picture[$key] = $row['id'];
        }

        $sql = "INSERT INTO pictureonbundling (bundlingId, pictureId) VALUES (?, ?)";
        foreach ($picture as $key => $value) {
            $res = update($sql, [$id, $value], 'ii');
        }
    }
}