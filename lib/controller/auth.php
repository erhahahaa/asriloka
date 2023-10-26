<?php
// require('././inc/db.php');
// require '../../lib/db.php'; 
class AuthController
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }


    public function login($data)
    {
        $q = 'SELECT * FROM user WHERE phone = ?';
        $this->db->query($q);
        $this->db->bind(1, $data['phone']);
        $res = $this->db->resultSet();

        if (count($res) > 0) {
            $row = $res[0];
            $hash = $row['password'];
            if (password_verify($data['password'], $hash)) {
                unset($row['password']);
                require_once('token.php');

                $res = json_decode(TokenController::generate($data['phone'], $row['name'], ), true);
                if ($res['success']) {
                    setcookie('token', $res['token'], time() + (86400 * 30), "/");
                    $_SESSION['token'] = $res['token'];
                    $_SESSION['data'] = $row;
                    return json_encode(["success" => true, "message" => "Login Successful", "data" => $row]);
                } else {
                    return json_encode(["success" => false, "message" => "Token Generation Failed"]);
                }
            } else {
                return json_encode(["success" => false, "message" => "Invalid Password"]);
            }
        } else {
            return json_encode(["success" => false, "message" => "Invalid phone"]);
        }
    }

    public function register($data, $picture)
    {

        $q = 'SELECT * FROM user WHERE phone = ?';
        $this->db->query($q);
        $this->db->bind(1, $data['phone']);
        $res = $this->db->resultSet();

        if (count($res) > 0) {
            return json_encode(["success" => false, "message" => "phone Already Registered"]);
        } else {
            $picture_name = null;
            if (!empty($picture['name']) || $picture['name'] != '') {
                $ext = strtolower(pathinfo($picture['name'], PATHINFO_EXTENSION));
                $prob_ext = ['jpg', 'jpeg', 'png'];

                if (in_array($ext, $prob_ext)) {
                    $picture_name = time() . "-" . uniqid() . ".$ext";
                    $target_path = "./assets/images/user/$picture_name";

                    if (!move_uploaded_file($picture['tmp_name'], $target_path)) {
                        return json_encode(["success" => false, "message" => "Failed to upload image"]);
                    }
                } else {
                    return json_encode(["success" => false, "message" => "Invalid Image Format"]);
                }
            }

            $q = 'INSERT INTO user (name, phone, password, picture, dob, address) VALUES (?,  ?, ?, ?, ?, ?)';
            $this->db->query($q);
            $this->db->bind(1, $data['name']);
            $this->db->bind(2, $data['phone']);
            $this->db->bind(3, password_hash($data['password'], PASSWORD_DEFAULT));
            $this->db->bind(4, $picture_name);
            $this->db->bind(5, $data['dob']);
            $this->db->bind(6, $data['address']);
            $this->db->execute();

            return json_encode(["success" => true, "message" => "Registration Successful"]);
        }
    }
    public function logout()
    {
        session_destroy();
        header('location: ../index.php');
    }

}
?>