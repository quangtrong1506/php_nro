<html lang='vi'>

<head>
    <meta charset='UTF-8' />
    <meta name='viewport' content='width=device-width, initial-scale=1.0' />
    <title>Trang chủ - Ngọc Rồng Sa Đoạ</title>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM' crossorigin='anonymous' />
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz' crossorigin='anonymous'>
    </script>
    <link rel='stylesheet' href='public/css/style.css' />
    <link rel="shortcut icon" href="public/images/favicon.jpg" type="image/x-icon">
</head>

<body>
    <div class='main'>
        <div class='header'>
            <ul class='container'>
                <li><a href='/'>Trang chủ</a></li>
                <li><a href='#'>Tải về</a></li>
                <li><a href='#'>Facebook</a></li>
                <li><a href='#'>Box chat</a></li>
                <!-- <li><a href='#'>Tài khoản</a></li> -->
            </ul>
        </div>
        <?php
            session_start();
            if (isset($_SESSION["isLogin"])) {
                $isLogin = true;
            } else {
                $isLogin = false;
            }
            $conn = new mysqli("localhost", "root", "", "nro_acc");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                echo "Lỗi kết nối đến cơ sở dữ liệu";
            }
            

        ?>
        <div class='body text-center'>
            <div class="pt-5"></div>
            <?php
                if($isLogin){
                    // Tìm tài khoản
                    $sql = "SELECT *  FROM `user` WHERE `id`=".$_SESSION["userId"];
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $username = $row["username"];
                            $online =  $row["online"] ==1 ? "<span style='color: var(--bs-info);'>Online</span>":"<span style='color: var(--bs-red);'>Offline</span>";
                            $sql = "SELECT *  FROM `character` WHERE `id`=".$row["character"];
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $name = $row["Name"];
                                    $InfoChar = json_decode($row["InfoChar"],true);
                                    if($InfoChar["Gender"] == 0)
                                    $gender =  "Trái đất";
                                    elseif($InfoChar["Gender"] == 1)
                                    $gender = "Namếc" ;
                                    else $gender= "Xayda";

                                    $haveChar = true;
                                }
                            } else {
                                $haveChar = false;
                            }
                        }
                    } else {
                        $username = "Lỗi không tìm thấy tài khoản";
                    }
                    echo "<div class='p-1'></div>
                    <h3>
                        Chào mừng
                        <span style='color: var(--bs-info);'>$username </span>quay chở lại
                    </h3>";
                    if ($haveChar) {
                        echo "<p style='color: var(--bs-gray-600);'>Tên nhân vật:
                                <span style='color: var(--bs-info);'>
                                    ".$name."
                                </span>
                                <span class='w-400-100'>
                                <span class='w-400-100-x'>- </span>Hành tinh:
                                <span style='color: var(--bs-info);'>
                                    ".$gender."
                                </span>
                                - Trạng thái:".$online."
                                </span>
                                </p>";
                    }else echo "<p>Chưa tạo nhân vật <a class='link-info' href='javascript:' onclick='TaoNhanVat()'>tạo ngay</a></p>";
                    echo '<div>
                            <button type="button" class="btn btn-outline-primary mb-1" onclick="ChangePassword()">Đổi mật khẩu</button>
                            <button type="button" class="btn btn-outline-dark mb-1" onclick="ChangeName()">Đổi tên nhân vật</button>
                            <button type="button" class="btn btn-outline-info mb-1" onclick="ChangeInfo()">Cập nhật thông tin</button>
                            <button type="button" class="btn btn-outline-danger mb-1" onclick="logout()">Đăng xuất</button>
                        </div>';
                }else{
                    echo "<div class='p-5'></div>
                        <h1>Ngọc Rồng SaDoa</h1>
                        <p>Đăng ký tài khoản và nhận quà tân thủ vô cùng hấp dẫn</p>
                        <button type='button' class='btn btn-outline-primary' onclick='DangKy()'>Đăng ký</button>
                        <button type='button' class='btn btn-outline-info' onclick='DangNhap()'>Đăng nhập</button>";
                }
                $conn->close();
            ?>
        </div>
        <div class='background'></div>
    </div>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js'
        integrity='sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=='
        crossorigin='anonymous' referrerpolicy='no-referrer'></script>
    <script src='public/js/main.js'></script>
</body>

</html>