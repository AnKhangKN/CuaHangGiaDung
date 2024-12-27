<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/config/connect.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// tennhanvien sdt cccd luong thuong trangthai
if (isset($_POST["product__sumit"])) {
    $tennhanvien = test_input($_POST["tennhanvien"]);
    $sdt = test_input($_POST["sdt"]);
    $cccd = test_input($_POST["cccd"]);
    $luong = test_input($_POST["luong"]);
    $thuong = test_input($_POST["thuong"]);

    $trangthai = $_POST["trangthai"];

    // email matkhau quyen
    $email = test_input($_POST["email"]);
    $matkhau = password_hash($_POST["matkhau"], PASSWORD_DEFAULT);

    $quyen = $_POST["quyen"];

    // Kiểm tra cccd
    $stmt_check_cccd = $conn->prepare("SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan 
                                    WHERE nv.cccd = ?");
    $stmt_check_cccd->bind_param("s", $cccd);
    $stmt_check_cccd->execute();
    $result_check_cccd = $stmt_check_cccd->get_result();

    // Kiểm tra email
    $stmt_check_email = $conn->prepare("SELECT * FROM  taikhoan WHERE email = ?");
    $stmt_check_email->bind_param("s", $email);
    $stmt_check_email->execute();
    $result_check_email = $stmt_check_email->get_result();

    // Kiểm tra sdt
    $stmt_check_sdt = $conn->prepare("SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan 
                                    WHERE nv.sdt = ?");
    $stmt_check_sdt->bind_param("s", $cccd);
    $stmt_check_sdt->execute();
    $result_check_sdt = $stmt_check_sdt->get_result();

    // test

    if ($result_check_cccd->num_rows > 0) {
        echo "<script>
        alert('Số căn cước công dân đã tồn tại.');
        window.location.href = '/CuaHangDungCu/public/manager/index.php?page=nhanvien';
        </script>";
    } else if ($result_check_email->num_rows > 0) {
        echo "<script>
        alert('Email đã tồn tại.');
        window.location.href = '/CuaHangDungCu/public/manager/index.php?page=nhanvien';
        </script>";
    } else if ($result_check_sdt->num_rows > 0) {
        echo "<script>
        alert('Số điện thoại đã tồn tại.');
        window.location.href = '/CuaHangDungCu/public/manager/index.php?page=nhanvien';
        </script>";
    } else {
        // Bắt đầu giao dịch
        $conn->begin_transaction();
        try {
            // Thêm tài khoản vào bảng taikhoan
            $sqlTaiKhoan = "INSERT INTO taikhoan (email, matkhau, quyen, ngaytao) VALUES (?, ?, ?, NOW())";
            $stmtTaiKhoan = $conn->prepare($sqlTaiKhoan);
            $stmtTaiKhoan->bind_param("ssi", $email, $matkhau, $quyen);
            $stmtTaiKhoan->execute();

            // Lấy idTaiKhoan vừa được tạo
            $idTaiKhoan = $conn->insert_id;

            // Thêm thông tin vào bảng nhanvien
            $sqlNhanVien = "INSERT INTO nhanvien (tennhanvien, sdt, cccd, luong, thuong, trangthai, idTaiKhoan) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtNhanVien = $conn->prepare($sqlNhanVien);
            $stmtNhanVien->bind_param("sisdiii", $tennhanvien, $sdt, $cccd, $luong, $thuong, $trangthai, $idTaiKhoan);
            $stmtNhanVien->execute();

            // Xác nhận giao dịch
            $conn->commit();

            echo "<script>
            alert('Thêm nhân viên thành công.');
            window.location.href = '/CuaHangDungCu/public/manager/index.php?page=nhanvien';
            </script>";
        } catch (Exception $e) {
            // Hủy giao dịch nếu có lỗi
            $conn->rollback();
            echo "<script>
            alert('Lỗi thêm nhân viên.');
            window.location.href = '/CuaHangDungCu/public/manager/index.php?page=nhanvien';
            </script>";
        }
    }
}

$search_nhanvien = isset($_GET["search_nhanvien"]) ? $_GET["search_nhanvien"] : "";

$item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 4;
$current_page = !empty($_GET["pages"]) ? $_GET["pages"] : 1;
$offset = ($current_page - 1) * $item_per_page;

if ($search_nhanvien) {
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/header.php");
    $sql_nv_tk = "SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan
                WHERE nv.tennhanvien LIKE '%" . $search_nhanvien . "%'
                OR nv.sdt LIKE '%" . $search_nhanvien . "%' 
                OR nv.cccd LIKE '%" . $search_nhanvien . "%'
                OR tk.email LIKE '%" . $search_nhanvien . "%'
                ORDER BY nv.idNhanVien ASC LIMIT $item_per_page OFFSET $offset";
    $result_nv_tk = mysqli_query($conn, $sql_nv_tk);
    $totalRecords = mysqli_query($conn, "SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan WHERE nv.tennhanvien LIKE '%" . $search_nhanvien . "%'
                                        OR nv.sdt LIKE '%" . $search_nhanvien . "%' 
                                        OR nv.cccd LIKE '%" . $search_nhanvien . "%'
                                        OR tk.email LIKE '%" . $search_nhanvien . "%'");
} else {
    $sql_nv_tk = "SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan ORDER BY nv.idNhanVien ASC LIMIT $item_per_page OFFSET $offset";
    $result_nv_tk = mysqli_query($conn, $sql_nv_tk);
    $totalRecords = mysqli_query($conn, "SELECT * FROM nhanvien nv JOIN taikhoan tk ON nv.idTaiKhoan = tk.idTaiKhoan");
}


$totalNumber = $totalRecords->num_rows;
$totalPages = ceil($totalNumber / $item_per_page);


?>

<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Quản lý nhân viên
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>

            <button class="content__header-btn js-product__header-btn">
                Thêm nhân viên
            </button>

            <form action="/CuaHangDungCu/public/manager/nhanvien.php" class="content__header-form-search">
                <input type="text" name="search_nhanvien" required class="content__header-form-search-text" placeholder="Tìm kiếm tên, sdt, cccd, email nhân viên">

                <button type="submit" class="content__header-form-search-submit">
                    Tìm kiếm
                    <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                </button>
            </form>
        </div>

        <div class="content__body">
            <h2 class="content__body-heading-text">Danh sách nhân viên</h2>


            <table class="content__body-table" cellspacing="0">
                <thead class="content__body-thead">
                    <tr class="content__body-tr">
                        <th class="content__body-th">ID</th>
                        <th class="content__body-th">Tên nhân viên</th>
                        <th class="content__body-th">SDT</th>
                        <th class="content__body-th">CCCD</th>
                        <th class="content__body-th">Lương</th>
                        <th class="content__body-th">Thưởng</th>
                        <th class="content__body-th">Tổng tiền</th>
                        <th class="content__body-th">Trạng thái</th>
                        <th class="content__body-th">Email</th>
                        <th class="content__body-th">Chức năng</th>
                    </tr>
                </thead>

                <tbody class="content__body-tbody">

                    <?php

                    if ($result_nv_tk->num_rows > 0) {
                        while ($row_nv_tk = mysqli_fetch_assoc($result_nv_tk)) {

                    ?>

                            <tr class="content__body-tr">
                                <td class="content__body-td"><?php echo $row_nv_tk["idNhanVien"] ?></td>
                                <td class="content__body-td"><?php echo $row_nv_tk["tennhanvien"] ?></td>
                                <td class="content__body-td"><?php echo $row_nv_tk["sdt"] ?></td>
                                <td class="content__body-td"><?php echo $row_nv_tk["cccd"] ?></td>
                                <td class="content__body-td"><?php echo number_format($row_nv_tk["luong"], 0, ',', '.') ?></td>
                                <td class="content__body-td"><?php echo number_format($row_nv_tk["thuong"], 0, ',', '.') ?></td>
                                <td class="content__body-td"><?php echo number_format($row_nv_tk["luong"] + $row_nv_tk["thuong"], 0, ',', '.') ?></td>
                                <td class="content__body-td">
                                    <?php
                                    if ($row_nv_tk["trangthai"] == 1) {
                                        echo "Còn làm việc";
                                    } else if ($row_nv_tk["trangthai"] == 0) {
                                        echo "Ngừng làm việc";
                                    }
                                    ?>
                                </td>
                                <td class="content__body-td"><?php echo $row_nv_tk["email"] ?></td>

                                <td class="content__body-td">
                                    <!-- <button class="content__body-td__btn-see view-nhanvien js_content__body-td__btn-see" data-id="<?php echo $row_nv_tk['idNhanVien'] ?>">xem</button> -->

                                    <form action="/CuaHangDungCu/app/controllers/manager/editNhanVien.php" class="content__body-td-form" method="POST">
                                        <input type="hidden" name="idNhanVien" value="<?php echo $row_nv_tk["idNhanVien"] ?>">
                                        <input type="hidden" name="idTaiKhoan" value="<?php echo $row_nv_tk["idTaiKhoan"] ?>">
                                        <input type="submit" class="content__body-td__btn-edit" value="sửa">
                                    </form>
                                </td>
                            </tr>

                    <?php }
                    } else {
                        echo "  <tr class='content__body-tr'>
                        <td class='content__body-td' colspan='10'>Không có nhân viên nào.</td>
                    </tr>";
                    } ?>
                </tbody>
            </table>

            <?php include $_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/controllers/manager/paginationNhanVien.php" ?>
        </div>
    </div>
</div>
</div>

<!-- Modal Add -->
<div class="content__modal js-product__modal">
    <div class="content__modal-container js-product__modal-container">

        <div class="content__modal-close js-product__modal-close">
            <i class="fa-solid fa-xmark product__modal-icon-close"></i>
        </div>

        <div class="content__modal-header">
            <h2 class="content__modal-header-text-heading">
                <i class="fa-regular fa-user content__modal-header-text-heading-icon"></i>
                Thêm nhân viên
            </h2>
        </div>

        <div class="content__modal-body">
            <form action="nhanvien.php" class="content__modal-body-form" method="POST">

                <div class="content__body-container">

                    <div class="content__modal-body-form-1">

                        <label for="" class="content__modal-body-label">Tên nhân viên: </label>
                        <input type="text" name="tennhanvien" id="" class="content__modal-body-input" placeholder="Nhập tên nhân viên">

                        <label for="" class="content__modal-body-label">Số điện thoại: </label>
                        <input type="text" name="sdt" id="" class="content__modal-body-input" placeholder="Nhập số điện thoại">

                        <label for="" class="content__modal-body-label">Căn cước công dân: </label>
                        <input type="text" name="cccd" id="" class="content__modal-body-input" placeholder="Nhập căn cước công dân">

                        <label for="" class="content__modal-body-label">Lương: </label>
                        <input type="number" name="luong" id="" class="content__modal-body-input" placeholder="Nhập lương">

                        <label for="" class="content__modal-body-label">Thưởng: </label>
                        <input type="number" name="thuong" id="" class="content__modal-body-input" placeholder="Nhập thưởng">
                        <br>

                        <label for="" class="content__modal-body-label">Trạng thái: </label>
                        <select class="content__modal-body-select" name="trangthai" id="">
                            <option value="1">Còn làm việc</option>
                            <option value="0">Ngừng làm việc</option>
                        </select>

                    </div>

                    <div class="content__modal-body-form-2">
                        <label for="" class="content__modal-body-label">Email: </label>
                        <input type="email" name="email" id="" class="content__modal-body-input" placeholder="Nhập email">

                        <label for="" class="content__modal-body-label">Mật khẩu: </label>
                        <input type="password" name="matkhau" id="" class="content__modal-body-input" placeholder="Nhập mật khẩu">

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>

                        <label for="" class="content__modal-body-label">Quyền: </label>
                        <select class="content__modal-body-select" name="quyen" id="">
                            <option value="1">Quản lý</option>
                            <option value="2">Nhân viên</option>
                        </select>

                    </div>
                </div>

                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Thêm nhân viên">
            </form>
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div>

<!-- Modal xem -->
<div id="productDetailsModal" class="content__modal js-product__modal-watch">
    <div class="content__modal-container js-product__modal-container-watch">

        <div class="content__modal-close js-product__modal-close-watch">
            <i class="fa-solid fa-xmark product__modal-icon-close"></i>
        </div>

        <div class="content__modal-header">
            <h2 class="content__modal-header-text-heading">
                <i class="fa-solid fa-basketball content__modal-header-text-heading-icon"></i>
                Thông tin chi tiết của nhân viên
            </h2>
        </div>

        <div class="content__modal-body" id="product-details">
            // Hiện thông tin
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/footer.php");
?>