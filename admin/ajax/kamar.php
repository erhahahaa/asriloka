<?php
require './../../lib/db.php';
require './../../lib/controller/token.php';
require './../../lib/essentials.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'tambahKamar') {
    $data = $_POST;
    $name = $data['room_name'];
    $price = $data['room_price'];
    $isReady = 0;
    $picture = [];
    if (isset($data['isReady']) && $data['isReady'] == 'on') {
        $isReady = 1;
    } else {
        $isReady = 0;
    }
    if (isset($_FILES['room_gambar'])) {

        $target_dir = "./../../assets/images/room/";
        foreach ($_FILES['room_gambar']['name'] as $key => $value) {
            $target_file = $target_dir . basename($_FILES["room_gambar"]["name"][$key]);
            $check = getimagesize($_FILES["room_gambar"]["tmp_name"][$key]);
            if ($check !== false) {
                if (move_uploaded_file($_FILES["room_gambar"]["tmp_name"][$key], $target_file)) {
                    $sql = "INSERT INTO picture (name) VALUES (?)";
                    $res = update($sql, [$value], 's');
                    $picture[] = $value;
                }
            }
        }
    }




    $sql = "INSERT INTO room (name, price, isReady) VALUES (?, ?, ?)";
    $res = update($sql, [$name, $price, $isReady], 'sii');
    $sql = "SELECT * FROM room ORDER BY id DESC LIMIT 1";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $room = $row['id'];
    foreach ($picture as $key => $value) {
        $sql = "SELECT * FROM picture WHERE name = ?";
        $res = select($sql, [$value], 's');
        $row = mysqli_fetch_assoc($res);
        $picture[$key] = $row['id'];
    }
    $sql = "INSERT INTO pictureonroom (roomId, pictureId) VALUES (?, ?)";
    foreach ($picture as $key => $value) {
        $res = update($sql, [$room, $value], 'ii');
    }




    if (isset($data['selected_fasilitas']) && !empty($data['selected_fasilitas'])) {
        echo "F set";
        $facility = $data['selected_fasilitas'];
        if ($facility != '' || $facility != 'undefined') {
            $facility = explode(',', $facility);
            if (count($facility) > 0) {
                foreach ($facility as $key => $value) {
                    $sql = "INSERT INTO facilityonroom (roomId, facilityId) VALUES (?, ?)";
                    $res = update($sql, [$room, $value], 'ii');
                }
            }
        }
    }
    if (isset($data['selected_capacity']) && !empty($data['selected_capacity'])) {
        $capacity = $data['selected_capacity'];
        if ($capacity != '' || $capacity != 'undefined') {
            $capacity = explode(',', $capacity);
            if (count($capacity) > 0) {
                foreach ($capacity as $key => $value) {
                    $sql = "INSERT INTO capacityonroom (roomId, capacityId) VALUES (?, ?)";
                    $res = update($sql, [$room, $value], 'ii');
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
                    $sql = "INSERT INTO ruleonroom (roomId, ruleId) VALUES (?, ?)";
                    $res = update($sql, [$room, $value], 'ii');
                }
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'loadCapacity') {

    $sql = "SELECT * FROM capacity";
    $res = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }

    echo json_encode($data);

}




if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'loadKamar') {
    $sql = "SELECT * FROM room";
    $room = mysqli_query($conn, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($room)) {
        $data[] = $row;
    }

    $facility = [];
    $capacity = [];
    $rule = [];
    $picture = [];

    foreach ($data as $key => $value) {
        $sql = "SELECT * FROM facilityonroom WHERE roomId = ?";
        $res = select($sql, [$value['id']], 'i');
        while ($row = mysqli_fetch_assoc($res)) {
            $facility[] = $row;
        }
        $data[$key]['facility'] = $facility;
        $facility = [];

        $sql = "SELECT * FROM capacityonroom WHERE roomId = ?";
        $res = select($sql, [$value['id']], 'i');
        while ($row = mysqli_fetch_assoc($res)) {
            $capacity[] = $row;
        }
        $data[$key]['capacity'] = $capacity;
        $capacity = [];

        $sql = "SELECT * FROM ruleonroom WHERE roomId = ?";
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
        foreach ($value['capacity'] as $k => $v) {
            $sql = "SELECT * FROM capacity WHERE id = ?";
            $res = select($sql, [$v['capacityId']], 'i');
            while ($row = mysqli_fetch_assoc($res)) {
                $capacity[] = $row;
            }
        }
        $data[$key]['capacity'] = $capacity;
        $capacity = [];
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
        $sql = "SELECT * FROM pictureonroom WHERE roomId = ?";
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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'editKamar') {
    $data = $_POST;
    $id = $data['edit_id'];
    $name = $data['edit_nama'];
    $price = $data['edit_price'];
    $isReady = 0;
    $picture = [];
    if (isset($data['edit_isReady']) && $data['edit_isReady'] == 'on') {
        $isReady = 1;
    }

    $sql = "UPDATE room SET name = ?, price = ?, isReady = ? WHERE id = ?";
    $res = update($sql, [$name, $price, $isReady, $id], 'siii');

    if ($res) {
        echo "Kamar Berhasil Diubah\n";
    } else {
        echo "Kamar Gagal Diubah";
    }

    $sql = "DELETE FROM pictureonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM facilityonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM capacityonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM ruleonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    if (isset($data['selected_fasilitas']) && !empty($data['selected_fasilitas'])) {
        echo "F set";
        $facility = $data['selected_fasilitas'];
        if ($facility != '' || $facility != 'undefined') {
            $facility = explode(',', $facility);
            if (count($facility) > 0) {
                foreach ($facility as $key => $value) {
                    $sql = "INSERT INTO facilityonroom (roomId, facilityId) VALUES (?, ?)";
                    $res = update($sql, [$id, $value], 'ii');
                }
            }
        }
    }

    if (isset($data['selected_capacity']) && !empty($data['selected_capacity'])) {
        $capacity = $data['selected_capacity'];
        if ($capacity != '' || $capacity != 'undefined') {
            $capacity = explode(',', $capacity);
            if (count($capacity) > 0) {
                foreach ($capacity as $key => $value) {
                    $sql = "INSERT INTO capacityonroom (roomId, capacityId) VALUES (?, ?)";
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
                    $sql = "INSERT INTO ruleonroom (roomId, ruleId) VALUES (?, ?)";
                    $res = update($sql, [$id, $value], 'ii');
                }
            }
        }
    }

    if (isset($_FILES['edit_image']) && !empty($_FILES['edit_image'])) {
        $target_dir = "./../../assets/images/room/";
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

        $sql = "INSERT INTO pictureonroom (roomId, pictureId) VALUES (?, ?)";
        foreach ($picture as $key => $value) {
            $res = update($sql, [$id, $value], 'ii');
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['action']) && $_REQUEST['action'] === 'hapusKamar') {
    $data = $_POST;
    $id = $data['hapus_id'];

    $sql = "DELETE FROM pictureonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM facilityonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM capacityonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM ruleonroom WHERE roomId = ?";
    $res = update($sql, [$id], 'i');

    $sql = "DELETE FROM room WHERE id = ?";
    $res = update($sql, [$id], 'i');

    if ($res) {
        echo "Kamar Berhasil Dihapus\n";
    } else {
        echo "Kamar Gagal Dihapus";
    }
}



?>