<?php


$hname = 'localhost';
$uname = 'root';
$pass = '';
$db = 'asriloka';
$port = 3306;


$conn = mysqli_connect($hname, $uname, $pass, $db, $port);
$admin_seed = [
    "name" => "Admin",
    "phone" => "012345678",
    "password" => password_hash("admin123", PASSWORD_DEFAULT),
    "role" => "ADMIN"
];
$user_seed = [
    "name" => "User",
    "phone" => "01234456789",
    "password" => password_hash("user123", PASSWORD_DEFAULT),
    "dob" => "2000-01-01",
    "address" => "User Address",
    "role" => "USER"
];

if (!$conn) {
    die("Cannot Connect to Database" . mysqli_connect_error());
}
$check = "SELECT * FROM user WHERE phone = ?";
$res = select($check, [$admin_seed['phone']], 's');
if (mysqli_num_rows($res) == 0) {
    $q = "INSERT INTO user (name, phone, password, role) VALUES (?, ?, ?, ?)";
    $res = update($q, [
        $admin_seed['name'],
        $admin_seed['phone'],
        $admin_seed['password'],
        $admin_seed['role']
    ], 'ssss');
    if ($res) {
        echo "Admin Created Successfully";
    } else {
        echo "Admin Creation Failed";
    }
}
$check = "SELECT * FROM user WHERE phone = ?";
$res = select($check, [$user_seed['phone']], 's');

if (mysqli_num_rows($res) == 0) {
    $q = "INSERT INTO user (name, phone, password,  dob, address, role) VALUES (?,  ?, ?, ?, ?, ?)";
    $res = update($q, [
        $user_seed['name'],
        $user_seed['phone'],
        $user_seed['password'],
        $user_seed['dob'],
        $user_seed['address'],
        $user_seed['role']
    ], 'ssssss');
    if ($res) {
        echo "User Created Successfully";
    } else {
        echo "User Creation Failed";
    }
}

function filteration($data)
{
    foreach ($data as $key => $value) {
        $data[$key] = trim($value);
        $data[$key] = stripcslashes($value);
        $data[$key] = htmlspecialchars($value);
        $data[$key] = strip_tags($value);
    }
    return $data;
}
// select used for get, show, read
function select($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    $auth['success'] = true;

    if ($auth['success']) {
        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
            if (mysqli_stmt_execute($stmt)) {
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            } else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Select");
            }
        } else {
            die("Query cannot be prepared - Select");
        }
    } else {
        die("Unauthorized User");
    }
}
function update($sql, $values, $datatypes)
{
    $conn = $GLOBALS['conn'];
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $res;
        } else {
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Update");
        }
    } else {
        die("Query cannot be prepared - Update");
    }
}


?>