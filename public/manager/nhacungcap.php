<?php

include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/config/connect.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["product__sumit"])) {
    $tennhacungcap = test_input($_POST["tennhacungcap"]);
    $email = test_input($_POST["email"]);
    $sdt = test_input($_POST["sdt"]);
    $diachi = test_input($_POST["diachi"]);
    $trangthai = test_input($_POST["trangthai"]);
    $ghichu = test_input($_POST["ghichu"]);

    $stmt = $conn->prepare("INSERT INTO nhacungcap (tennhacungcap, email, sdt, diachi, ngaytao, trangthai, ghichu) VALUES (?, ?, ?, ?, current_timestamp(), ?, ?)");
    $stmt->bind_param("ssssis", $tennhacungcap, $email, $sdt, $diachi, $trangthai, $ghichu);
    $stmt->execute();

    echo "<script>
            alert('Thêm nhà cung cấp thành công.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=nhacungcap';
            </script>";
}

$search_nhacungcap = isset($_GET["search_nhacungcap"]) ? $_GET["search_nhacungcap"] : "";

$item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 4;
$current_page = !empty($_GET["pages"]) ? $_GET["pages"] : 1;
$offset = ($current_page - 1) * $item_per_page;

if ($search_nhacungcap) {
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/header.php");
    $sql_nhacungcap = "SELECT * FROM nhacungcap WHERE tennhacungcap LIKE '%" . $search_nhacungcap . "%' ORDER BY idNhaCungCap ASC LIMIT $item_per_page OFFSET $offset";
    $result_nhacungcap = mysqli_query($conn, $sql_nhacungcap);
    $totalRecords = mysqli_query($conn, "SELECT * FROM nhacungcap WHERE tennhacungcap LIKE '%" . $search_nhacungcap . "%'");
} else {
    $sql_nhacungcap = "SELECT * FROM nhacungcap ORDER BY idNhaCungCap ASC LIMIT $item_per_page OFFSET $offset";
    $result_nhacungcap = mysqli_query($conn, $sql_nhacungcap);
    $totalRecords = mysqli_query($conn, "SELECT * FROM nhacungcap");
}

$totalNumber = $totalRecords->num_rows;
$totalPages = ceil($totalNumber / $item_per_page);



?>
<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Quản lý nhà cung cấp
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>

            <button class="content__header-btn js-product__header-btn">
                Thêm nhà cung cấp
            </button>

            <form action="/CuaHangGiaDung/public/manager/nhacungcap.php" class="content__header-form-search">
                <input type="text" name="search_nhacungcap" required class="content__header-form-search-text" placeholder="Tìm kiếm nhà cung cấp">

                <button type="submit" class="content__header-form-search-submit">
                    Tìm kiếm
                    <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                </button>
            </form>
        </div>

        <div class="content__body">
            <h2 class="content__body-heading-text">Danh sách nhà cung cấp</h2>


            <table class="content__body-table" cellspacing="0">
                <thead class="content__body-thead">
                    <tr class="content__body-tr">
                        <th class="content__body-th">ID</th>
                        <th class="content__body-th">Tên nhà cung cấp</th>
                        <th class="content__body-th">Email</th>
                        <th class="content__body-th">SDT</th>
                        <th class="content__body-th">Địa chỉ</th>
                        <th class="content__body-th">Trạng thái</th>
                        <th class="content__body-th">Ghi chú</th>
                        <th class="content__body-th">Chức năng</th>
                    </tr>
                </thead>

                <tbody class="content__body-tbody">

                    <?php

                    if ($result_nhacungcap->num_rows > 0) {
                        while ($row_nhacungcap = mysqli_fetch_assoc($result_nhacungcap)) {

                    ?>

                            <tr class="content__body-tr">
                                <td class="content__body-td"><?php echo $row_nhacungcap["idNhaCungCap"] ?></td>
                                <td class="content__body-td"><?php echo $row_nhacungcap["tennhacungcap"] ?></td>
                                <td class="content__body-td"><?php echo $row_nhacungcap["email"] ?></td>
                                <td class="content__body-td"><?php echo $row_nhacungcap["sdt"] ?></td>
                                <td class="content__body-td"><?php echo $row_nhacungcap["diachi"] ?></td>
                                <td class="content__body-td">
                                    <?php
                                        if ($row_nhacungcap["trangthai"] == 1) {
                                            echo "Còn hợp tác";
                                        } else if ($row_nhacungcap["trangthai"] == 0) {
                                            echo "Không còn hợp tác";
                                        }
                                    ?>
                                </td>
                                <td class="content__body-td"><?php echo $row_nhacungcap["ghichu"] ?></td>
                                <td class="content__body-td">
                                    <form action='/CuaHangGiaDung/app/controllers/manager/deleteNhaCungCap.php' class="content__body-td-form" method='POST'>
                                        <input type='hidden' name='idNhaCungCap' value="<?php echo $row_nhacungcap["idNhaCungCap"] ?>">
                                        <input type='submit' class="content__body-td__btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa nhà cung cấp này không?')" value="xóa">
                                    </form>

                                    <form action="/CuaHangGiaDung/app/controllers/manager/editNhaCungCap.php" class="content__body-td-form" method="POST">
                                        <input type="hidden" name="idNhaCungCap" value="<?php echo $row_nhacungcap["idNhaCungCap"] ?>">
                                        <input type="submit" class="content__body-td__btn-edit" value="sửa">
                                    </form>
                                </td>
                            </tr>

                    <?php }
                    } else {
                        echo "  <tr class='content__body-tr'>
                        <td class='content__body-td' colspan='3'>Không có danh mục nào.</td>
                    </tr>";
                    } ?>

                </tbody>
            </table>

            <?php include $_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/controllers/manager/paginationNhaCungCap.php" ?>

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
                <i class="fa-solid fa-house content__modal-header-text-heading-icon"></i>
                Thêm nhà cung cấp
            </h2>
        </div>

        <div class="content__modal-body">
            <form action="/CuaHangGiaDung/public/manager/nhacungcap.php" class="content__modal-body-form" method="POST">
                <label for="" class="content__modal-body-label">Tên nhà cung cấp: </label>
                <input required type="text" name="tennhacungcap" id="" class="content__modal-body-input" placeholder="Nhập tên nhà cung cấp">

                <label for="" class="content__modal-body-label">Email: </label>
                <input required type="email" name="email" id="" class="content__modal-body-input" placeholder="Nhập email">

                <label for="" class="content__modal-body-label">Số điện thoại: </label>
                <input required type="text" name="sdt" id="" class="content__modal-body-input" placeholder="Nhập số điện thoại">

                <label for="" class="content__modal-body-label">Địa chỉ: </label>
                <input required type="text" name="diachi" id="" class="content__modal-body-input" placeholder="Nhập địa chỉ">

                <label for="" class="content__modal-body-label">Trạng thái: </label>
                <select class="content__modal-body-select" name="trangthai" id="">
                    <option value="1">còn hợp tác</option>
                    <option value="0">không còn hợp tác</option>
                </select>

                <label for="" class="content__modal-body-label">Ghi chu: </label>
                <textarea name="ghichu" class="content__modal-body-input" id=""></textarea>
                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Thêm nhà cung cấp">
            </form>
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/footer.php");
?>