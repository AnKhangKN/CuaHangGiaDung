<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/config/connect.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// search đơn hàng
$search_donhang = isset($_GET["search_donhang"]) ? $_GET["search_donhang"] : "";
// search ngày
$start_date = isset($_GET["start_date"]) ? $_GET["start_date"] : "";
$end_date = isset($_GET["end_date"]) ? $_GET["end_date"] : "";

$item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 4;
$current_page = !empty($_GET["pages"]) ? $_GET["pages"] : 1;
$offset = ($current_page - 1) * $item_per_page;

if ($search_donhang) {
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/header.php");
    $sql = "SELECT hd.idHoaDon, kh.tenkhachhang, sp.tensanpham, cthd.soluong, hd.tongtien, hd.ngayxuathoadon, hd.trangthai, nv.tennhanvien FROM hoadon hd, chitiethoadon cthd, nhanvien nv, khachhang kh, chitietsanpham ctsp, sanpham sp
        WHERE hd.idHoaDon = cthd.idHoaDon 
        AND hd.idNhanVien = nv.idNhanVien 
        AND hd.idKhachHang = kh.idKhachHang
        AND cthd.idChiTietSanPham = ctsp.idChiTietSanPham
        AND ctsp.idSanPham = sp.idSanPham
        AND (sp.tensanpham LIKE '%" . $search_donhang . "%' 
        OR nv.tennhanvien LIKE '%" . $search_donhang . "%' 
        OR kh.tenkhachhang LIKE '%" . $search_donhang . "%')
        ORDER BY hd.idHoaDon ASC LIMIT $item_per_page OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    $totalRecords = mysqli_query($conn, "SELECT * FROM hoadon hd, chitiethoadon cthd, nhanvien nv, khachhang kh, chitietsanpham ctsp, sanpham sp
        WHERE hd.idHoaDon = cthd.idHoaDon 
        AND hd.idNhanVien = nv.idNhanVien 
        AND hd.idKhachHang = kh.idKhachHang
        AND cthd.idChiTietSanPham = ctsp.idChiTietSanPham
        AND ctsp.idSanPham = sp.idSanPham
        AND (sp.tensanpham LIKE '%" . $search_donhang . "%' 
        OR nv.tennhanvien LIKE '%" . $search_donhang . "%' 
        OR hd.ngayxuathoadon LIKE '%" . $search_donhang . "%' 
        OR kh.tenkhachhang LIKE '%" . $search_donhang . "%')
        ORDER BY hd.idHoaDon ASC LIMIT $item_per_page OFFSET $offset");
} else if ($start_date && $end_date) {
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/header.php");
    $sql = "SELECT hd.idHoaDon, kh.tenkhachhang, sp.tensanpham, cthd.soluong, hd.tongtien, hd.ngayxuathoadon, hd.trangthai, nv.tennhanvien FROM hoadon hd, chitiethoadon cthd, nhanvien nv, khachhang kh, chitietsanpham ctsp, sanpham sp
        WHERE hd.idHoaDon = cthd.idHoaDon
        AND hd.idNhanVien = nv.idNhanVien 
        AND hd.idKhachHang = kh.idKhachHang
        AND cthd.idChiTietSanPham = ctsp.idChiTietSanPham
        AND ctsp.idSanPham = sp.idSanPham
        AND (hd.ngayxuathoadon BETWEEN '$start_date' AND '$end_date') OR (hd.ngayxuathoadon = '' AND hd.ngayxuathoadon = '')
        ORDER BY hd.idHoaDon ASC LIMIT $item_per_page OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    $totalRecords = mysqli_query($conn, "SELECT * FROM hoadon hd, chitiethoadon cthd, nhanvien nv, khachhang kh, chitietsanpham ctsp, sanpham sp
        WHERE hd.idHoaDon = cthd.idHoaDon 
        AND hd.idNhanVien = nv.idNhanVien 
        AND hd.idKhachHang = kh.idKhachHang
        AND cthd.idChiTietSanPham = ctsp.idChiTietSanPham
        AND ctsp.idSanPham = sp.idSanPham
        AND (hd.ngayxuathoadon BETWEEN '$start_date' AND '$end_date') OR (hd.ngayxuathoadon = '' AND hd.ngayxuathoadon = '')
        ORDER BY hd.idHoaDon ASC LIMIT $item_per_page OFFSET $offset");
} else {
    $sql = "SELECT hd.idHoaDon, kh.tenkhachhang, sp.tensanpham, cthd.soluong, hd.tongtien, hd.ngayxuathoadon, hd.trangthai, nv.tennhanvien FROM hoadon hd, chitiethoadon cthd, nhanvien nv, khachhang kh, chitietsanpham ctsp, sanpham sp
        WHERE hd.idHoaDon = cthd.idHoaDon 
        AND hd.idNhanVien = nv.idNhanVien 
        AND hd.idKhachHang = kh.idKhachHang
        AND cthd.idChiTietSanPham = ctsp.idChiTietSanPham
        AND ctsp.idSanPham = sp.idSanPham ORDER BY hd.idHoaDon ASC LIMIT $item_per_page OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    $totalRecords = mysqli_query($conn, "SELECT * FROM hoadon");
}

$totalNumber = $totalRecords->num_rows;
$totalPages = ceil($totalNumber / $item_per_page);


?>

<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Quản lý đơn hàng
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>

            <!-- <button class="content__header-btn js-product__header-btn">
                        Thêm khách hàng
                    </button> -->

            <div class="content__header-form">
                <form action="/CuaHangDungCu/public/manager/donhang.php" class="content__header-form-search">
                    <input type="text" name="search_donhang" required class="content__header-form-search-text" placeholder="Tìm kiếm tên sp, kh, nv">

                    <button type="submit" class="content__header-form-search-submit">
                        Tìm kiếm
                        <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                    </button>
                </form>

                <form action="/CuaHangDungCu/public/manager/donhang.php" class="content__header-form-search-cost" method="GET">
                    <label for="" class="content__header-form-search-cost-label">từ ngày: </label>
                    <input type="date" class="content__header-form-search-cost-input" name="start_date" required id="">
                    <label for="" class="content__header-form-search-cost-label">đến ngày: </label>
                    <input type="date" class="content__header-form-search-cost-input" name="end_date" required id="">
                    <button type="submit" class="content__header-form-search-submit-cost">
                        Tìm kiếm
                        <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                    </button>
                </form>
            </div>

            <div class="content__body">
                <h2 class="content__body-heading-text">Danh sách đơn hàng</h2>


                <table class="content__body-table" cellspacing="0">
                    <thead class="content__body-thead">
                        <tr class="content__body-tr">
                            <th class="content__body-th">ID</th>
                            <th class="content__body-th">Khách hàng</th>
                            <th class="content__body-th">Tên sản phẩm</th>
                            <th class="content__body-th">Số lượng</th>
                            <th class="content__body-th">Tổng tiền</th>
                            <th class="content__body-th">Ngày xuất hóa đơn</th>
                            <th class="content__body-th">Trạng thái</th>
                            <th class="content__body-th">Nhân viên</th>
                        </tr>
                    </thead>

                    <tbody class="content__body-tbody">

                        <?php

                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                                <tr class="content__body-tr">
                                    <td class="content__body-td"><?php echo $row["idHoaDon"] ?></td>
                                    <td class="content__body-td"><?php echo $row["tenkhachhang"] ?></td>
                                    <td class="content__body-td"><?php echo $row["tensanpham"] ?></td>
                                    <td class="content__body-td"><?php echo $row["soluong"] ?></td>
                                    <td class="content__body-td"><?php echo number_format($row["tongtien"], 0, ',', '.') ?></td>
                                    <td class="content__body-td"><?php echo date("d/m/Y H:i:s", strtotime($row["ngayxuathoadon"])) ?></td>
                                    <td class="content__body-td">
                                        <?php
                                        if ($row["trangthai"] == 0) {
                                            echo "đang chờ xử lý";
                                        } else if ($row["trangthai"] == 1) {
                                            echo "đang giao hàng";
                                        } else if ($row["trangthai"] == 2) {
                                            echo "hoàn thành";
                                        }

                                        ?>
                                    </td>
                                    <td class="content__body-td"><?php echo $row["tennhanvien"] ?></td>
                                </tr>

                        <?php }
                        } else {
                            echo "  <tr class='content__body-tr'>
                        <td class='content__body-td' colspan='8'>Không có hóa đơn nào.</td>
                    </tr>";
                        } ?>
                    </tbody>
                </table>

                <?php include $_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/controllers/manager/paginationDonHang.php" ?>

            </div>
        </div>
    </div>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangDungCu/app/views/manager/includes/footer.php");
?>