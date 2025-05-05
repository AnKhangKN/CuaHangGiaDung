<?php

include "../../config/connect.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["product__sumit"])) {
    $tendanhmuc = test_input($_POST["tendanhmuc"]);

    $stmt = $conn->prepare("INSERT INTO danhmucsanpham (tendanhmuc) VALUES (?)");
    $stmt->bind_param("s", $tendanhmuc);
    $stmt->execute();

    echo "<script>
            alert('Thêm danh mục thành công.');
            window.location.href = '/CuaHangGiaDung/public/manager/index.php?page=danhmuc';
            </script>";
}

$search_danhmuc = isset($_GET["search_danhmuc"]) ? $_GET["search_danhmuc"] : "";

$item_per_page = !empty($_GET["per_page"]) ? $_GET["per_page"] : 4;
$current_page = !empty($_GET["pages"]) ? $_GET["pages"] : 1;
$offset = ($current_page - 1) * $item_per_page;

if ($search_danhmuc) {
    include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/header.php");
    $sql_danhmuc = "SELECT * FROM danhmucsanpham WHERE tendanhmuc LIKE '%" . $search_danhmuc . "%' ORDER BY idDanhMuc ASC LIMIT $item_per_page OFFSET $offset";
    $result_danhmuc = mysqli_query($conn, $sql_danhmuc);
    $totalRecords = mysqli_query($conn, "SELECT * FROM danhmucsanpham WHERE tendanhmuc LIKE '%" . $search_danhmuc . "%'");
} else {
    $sql_danhmuc = "SELECT * FROM danhmucsanpham ORDER BY idDanhMuc ASC LIMIT $item_per_page OFFSET $offset";
    $result_danhmuc = mysqli_query($conn, $sql_danhmuc);
    $totalRecords = mysqli_query($conn, "SELECT * FROM danhmucsanpham");
}

$totalNumber = $totalRecords->num_rows;
$totalPages = ceil($totalNumber / $item_per_page);



?>
<div id="content">
    <div class="content__section">
        <div class="content__header">
            <div class="content__header-namepage">
                <h2 class="content__header-namepage-text">
                    Quản lý danh mục
                </h2>
                <hr class="content__header-namepage-bottom-line">
            </div>

            <button class="content__header-btn js-product__header-btn">
                Thêm danh mục
            </button>

            <form action="/CuaHangGiaDung/public/manager/danhmuc.php" class="content__header-form-search">
                <input type="text" name="search_danhmuc" required class="content__header-form-search-text" placeholder="Tìm kiếm tên danh mục">

                <button type="submit" class="content__header-form-search-submit">
                    Tìm kiếm
                    <i class="fa-solid fa-magnifying-glass product__header-form-search-submit-icon"></i>
                </button>
            </form>
        </div>

        <div class="content__body">
            <h2 class="content__body-heading-text">Danh sách danh mục</h2>


            <table class="content__body-table" cellspacing="0">
                <thead class="content__body-thead">
                    <tr class="content__body-tr">
                        <th class="content__body-th">ID</th>
                        <th class="content__body-th">Tên danh mục sản phẩm</th>
                        <th class="content__body-th">Chức năng</th>
                    </tr>
                </thead>

                <tbody class="content__body-tbody">

                    <?php

                    if ($result_danhmuc->num_rows > 0) {
                        while ($row_danhmuc = mysqli_fetch_assoc($result_danhmuc)) {

                    ?>

                            <tr class="content__body-tr">
                                <td class="content__body-td"><?php echo $row_danhmuc["idDanhMuc"] ?></td>
                                <td class="content__body-td"><?php echo $row_danhmuc["tendanhmuc"] ?></td>
                                <td class="content__body-td">
                                    <form action='/CuaHangGiaDung/app/controllers/manager/deleteDanhMuc.php' class="content__body-td-form" method='POST'>
                                        <input type='hidden' name='idDanhMuc' value="<?php echo $row_danhmuc["idDanhMuc"] ?>">
                                        <input type='submit' class="content__body-td__btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" value="xóa">
                                    </form>

                                    <form action="/CuaHangGiaDung/app/controllers/manager/editDanhMuc.php" class="content__body-td-form" method="POST">
                                        <input type="hidden" name="idDanhMuc" value="<?php echo $row_danhmuc["idDanhMuc"] ?>">
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

            <?php include $_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/controllers/manager/paginationDanhMuc.php" ?>

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
                <i class="fa-solid fa-list content__modal-header-text-heading-icon"></i>
                Thêm danh mục
            </h2>
        </div>

        <div class="content__modal-body">
            <form action="/CuaHangGiaDung/public/manager/danhmuc.php" class="content__modal-body-form" method="POST">
                <label for="" class="content__modal-body-label">Tên danh mục: </label>
                <input type="text" name="tendanhmuc" id="" class="content__modal-body-input" placeholder="Nhập tên danh mục">

                <input class="content__modal-body-submit" name="product__sumit" type="submit" value="Thêm danh mục">
            </form>
        </div>

        <div class="content__modal-footer">

        </div>
    </div>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CuaHangGiaDung/app/views/manager/includes/footer.php");
?>