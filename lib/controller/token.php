<?php
class TokenController
{
    public static function generate(string $email, string $name)
    {
        $user = new User();
        $check = "SELECT * FROM user WHERE email = ?";
        $res = select($check, [$email], 's');
        if (mysqli_num_rows($res) > 0) {
            $token = md5($email . $name . time());
            $update = "UPDATE user SET token = ? WHERE email = ?";
            $res = update($update, [$token, $email], 'ss');
            return json_encode([
                "success" => true,
                "token" => $token
            ]);
        } else {
            return json_encode([
                "success" => false,
                "message" => "User not found"
            ]);
        }
    }

    public static function verify(string $token, string $role)
    {
        $conn = $GLOBALS['conn'];
        $check = "SELECT * FROM user WHERE token = ? AND role = ?";
        if ($stmt = mysqli_prepare($conn, $check)) {
            mysqli_stmt_bind_param($stmt, 'ss', $token, $role);
            if (mysqli_stmt_execute($stmt)) {
                $res = mysqli_stmt_get_result($stmt);
            } else {
                die("Query cannot be executed - Verify");
            }
        } else {
            die("Query cannot be prepared - Verify");
        }
        if (mysqli_num_rows($res) > 0) {
            return json_encode([
                "success" => true,
                "message" => "Authorized User",
            ]);
        } else {
            return json_encode([
                "success" => false,
                "message" => "Unauthorized User"
            ]);
        }
    }
}