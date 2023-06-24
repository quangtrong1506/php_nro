<?php 
    $conn = new mysqli("localhost", "root", "", "nro_acc");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        echo "Lỗi kết nối đến cơ sở dữ liệu";
    }
    $username = $_GET["username"];
    $password = $_GET["password"];
    $cPassword = $_GET["cPassword"];
    //
    $back = array("code" => "0", "message" => "");
    if (empty($username) || empty($password) || empty($cPassword)) {
        $back["code"] = -1;
        $back["message"] = "Vui lòng nhập đầy đủ thông tin";
    }else if(strlen($username) < 5 || strlen($username) > 20){
        $back["code"] = -1;
        $back["message"] = "Tên tài khoản chỉ được sử dụng từ 5 đến 20 ký tự";
    }
    else if(strlen($password) < 5 || strlen($password) > 20){
        $back["code"] = -1;
        $back["message"] = "Mật khẩu chỉ được sử dụng từ 5 đến 20 ký tự";
    }
    else if(preg_match("/[^a-z0-9]/",$username)){
        $back["code"] = -1;
        $back["message"] = "Tên tài khoản chỉ được sử dụng ký tự chữ cái thường [a-z] và số [0-9]";
    }
    else if(preg_match("/[^a-z0-9]/",$password)){
        $back["code"] = -1;
        $back["message"] = "Mật khẩu chỉ được sử dụng ký tự chữ cái thường [a-z] và số [0-9]";
    }
    else if ($password!= $cPassword) {
        $back["code"] = -2;
        $back["message"] = "Xác nhận mật khẩu không chính xác";
    }
    else{
        $sql = "SELECT * FROM `user` WHERE `username`='".$username."'";
        // echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $back["code"] = -1;
                $back["message"] = "Tên tài khoản đã có người đăng ký";
            }
        } else {
            session_start();
            $sql = "INSERT INTO `user` (username, password) VALUES ('".$username."','".$username."')";
            $result = $conn->query($sql);
            $sql = "SELECT * FROM `user` WHERE `username`='".$username."'";
        // echo $sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $back["code"] = 1;
                    $back["message"] = "Đăng ký thành công";
                    $_SESSION['userId'] = $row["id"];
                    $_SESSION['isLogin'] = true;
                }
            }else{
                $back["code"] = 0;
                $back["message"] = "Lỗi đăng ký";
                session_destroy();
            }
        }
    }
    $conn->close();
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($back);
?>