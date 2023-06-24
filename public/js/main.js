let temp = {};
//#region đăng ký
async function DangKy() {
    const { value: formValues } = await Swal.fire({
        title: 'Đăng ký tài khoản',
        html: `
        <form>
            <div class="mb-3">
                <label for="swal-username" class="form-label">Tài khoản</label>
                <input type="text" class="form-control" id="swal-username"
                value="${temp.username || ''}">
            </div>
            <div class="mb-3">
                <label for="swal-password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="swal-password"
                    value="${temp.password || ''}">
            </div>
            <div class="mb-3">
            <label for="swal-password" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="swal-c-password" 
                value="${temp.cPassword || ''}">
        </div>
        </form>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đăng ký',
        cancelButtonText: 'Hủy',
        preConfirm: () => {
            return [
                document.getElementById('swal-username').value,
                document.getElementById('swal-password').value,
                document.getElementById('swal-c-password').value,
            ];
        },
    });
    if (formValues) {
        var [username, password, cPassword] = formValues;
        temp.username = username || '';
        temp.password = password || '';
        temp.cPassword = cPassword || '';
        var settings = {
            url: `/user/register.php?username=${username}&password=${password}&cPassword=${cPassword}`,
            method: 'GET',
            timeout: 0,
        };

        $.ajax(settings).done(function (result) {
            console.log(result);
            var icon = result.code == 1 ? 'success' : result.code == 0 ? 'error' : 'warning';
            var title = result.code == 1 ? 'Thành công' : result.code == 0 ? 'Lỗi' : 'Cảnh báo';
            Swal.fire(title, result.message, icon).then((result2) => {
                if (result2.isConfirmed) {
                    if (result.code != 1) DangKy();
                    if (result.code == 1)
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                }
            });
        });
    }
}
//#endregion
//#region Đăng nhập
async function DangNhap() {
    const { value: formValues } = await Swal.fire({
        title: 'Đăng nhập',
        html: `
        <form>
            <div class="mb-3">
                <label for="swal-username" class="form-label">Tài khoản</label>
                <input type="text" class="form-control" id="swal-username"
                value="${temp.username || ''}">
            </div>
            <div class="mb-3">
                <label for="swal-password" class="form-label">Mật khẩu</label>
                <input type="password" class="form-control" id="swal-password"
                    value="${temp.password || ''}">
            </div>
        </div>
        </form>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đăng nhập',
        cancelButtonText: 'Hủy',
        preConfirm: () => {
            return [
                document.getElementById('swal-username').value,
                document.getElementById('swal-password').value,
            ];
        },
    });
    if (formValues) {
        var [username, password] = formValues;
        temp.username = username || '';
        temp.password = password || '';
        var form = new FormData();
        form.append('username', username);
        form.append('password', password);

        var settings = {
            url: `/user/login.php?username=${username}&password=${password}`,
            method: 'GET',
            timeout: 0,
        };

        $.ajax(settings).done(function (result) {
            console.log(result);
            var icon = result.code == 1 ? 'success' : result.code == 0 ? 'error' : 'warning';
            var title = result.code == 1 ? 'Thành công' : result.code == 0 ? 'Lỗi' : 'Cảnh báo';
            Swal.fire(title, result.message, icon).then((result2) => {
                if (result2.isConfirmed) {
                    if (result.code != 1) DangNhap();
                }
            });
            if (result.code == 1) {
                if (temp.isTaoNhanVat) TaoNhanVat();
                else {
                    setTimeout(() => {
                        location.reload();
                    }, 300);
                }
            }
        });
    }
}
//#endregion
async function TaoNhanVat() {
    const { value: formValues } = await Swal.fire({
        title: 'Tạo nhân vật mới',
        html: `
        <form>
            <div class="mb-3">
                <label for="swal-username" class="form-label">Tên nhân vật trong game</label>
                <input type="text" class="form-control" id="swal-username"
                value="${temp.Name || ''}">
            </div>
            <div class="mb-3">
            <label for="swal-hanhtinh" class="form-label">Chọn hành tinh</label>
            <select class="form-control" id="swal-hanhtinh">
                <option value="-1">Chọn hành tinh</option>
                <option value="0">Trái đất</option>
                <option value="1">Namec</option>
                <option value="2">Xayda</option>

            </select>
        </div>
        </form>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Tạo nhân vật',
        cancelButtonText: 'Hủy',
        preConfirm: () => {
            return [
                document.getElementById('swal-username').value,
                document.getElementById('swal-hanhtinh').value,
            ];
        },
    });
    if (formValues) {
        var [username, hanhtinh] = formValues;
        temp.Name = username || '';
        var settings = {
            url: '/api/user-create-character',
            method: 'POST',
            timeout: 0,
            headers: {
                'Content-Type': 'application/json',
            },
            data: JSON.stringify({
                name: username,
                gender: hanhtinh,
            }),
        };

        $.ajax(settings).done(function (result) {
            var icon = result.code == 1 ? 'success' : result.code == 0 ? 'error' : 'warning';
            var title = result.code == 1 ? 'Thành công' : result.code == 0 ? 'Lỗi' : 'Cảnh báo';
            Swal.fire(title, result.message, icon).then((result2) => {
                if (result2.isConfirmed) {
                    if (result.code == -1) {
                        DangNhap();
                        temp.isTaoNhanVat = true;
                    } else if (result.code != 1) TaoNhanVat();
                    else if (result.code == 1) location.reload();
                }
            });
        });
    }
}
function logout() {
    var settings = {
        url: '/user/logout.php',
        method: 'POST',
        timeout: 0,
    };
    $.ajax(settings).done(() => {
        location.href = '/';
    });
}
function ChangeName() {
    comicSoon();
}
function ChangeInfo(params) {
    comicSoon();
}
function ChangePassword() {
    comicSoon();
}
function comicSoon() {
    Swal.fire('Thông báo', 'Hệ thống sẽ được cập nhật vào tuần tới', 'info');
}
