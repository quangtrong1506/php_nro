<?php 
    $conn = new mysqli("localhost", "root", "", "nro_acc");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Lỗi kết nối đến cơ sở dữ liệu";
    }
    $username = $_GET["username"];
    $password = $_GET["password"];
    //
    $back = array("code" => "0", "message" => "");
    if (empty($username) || empty($password)) {
        $back["code"] = -1;
        $back["message"] = "Vui lòng nhập đầy đủ thông tin";
    }
    $sql = "SELECT * FROM `user` WHERE `username`='".$username."' AND `password`='".$password."'";
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            session_start();
            $_SESSION["isLogin"] = true;
            $_SESSION["userId"] = $row["id"];
            $back["code"] = 1;
            $back["message"] = "Đăng nhập thành công";
        }
    } else {
        $back["code"] = -1;
        $back["message"] = "Thông tin tài khoản mật khẩu không chính xác";
    }
    $conn->close();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($back);
?>