<?php
include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/connect.php");

if (isset($_GET['idSanPham'])) {
    $idSanPham = $_GET['idSanPham'];

    // Hình ảnh sản phẩm
    $sql_hinhanhsp = "SELECT * FROM sanpham sp JOIN hinhanhsanpham hasp ON sp.idSanPham = hasp.idSanPham WHERE sp.idSanPham = ?";
    $stmt_hinhanhsp = $conn->prepare($sql_hinhanhsp);
    $stmt_hinhanhsp->bind_param("i", $idSanPham);
    $stmt_hinhanhsp->execute();
    $result_hinhanhsp = $stmt_hinhanhsp->get_result();
    $row__hinhanhsp = $result_hinhanhsp->fetch_assoc();


    // Truy vấn chi tiết sản phẩm
    $sql_sanpham = "SELECT * FROM sanpham sp 
            JOIN chitietsanpham ctsp ON sp.idSanPham = ctsp.idSanPham
            WHERE sp.idSanPham = ?";
    $stmt_sanpham = $conn->prepare($sql_sanpham);
    $stmt_sanpham->bind_param("i", $idSanPham);
    $stmt_sanpham->execute();
    $result_sanpham = $stmt_sanpham->get_result();

    $row_sanpham = $result_sanpham->fetch_assoc();
    if ($result_sanpham->num_rows > 0) {
?>

        <table class="content__body-table-modal" cellspacing="0">
            <thead class="content__body-thead-modal">
                <tr class="content__body-tr-modal">
                    <th class="content__body-th-modal">Thông tin</th>
                    <th class="content__body-th-modal">Chi tiết</th>
                    <th class="content__body-th-modal">Hình ảnh sản phẩm</th>
                </tr>
            </thead>

            <tbody class="content__body-tbody-modal">

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Tên sản phẩm</td>
                    <td class="content__body-td-modal"><?php echo htmlspecialchars($row_sanpham["tensanpham"]) ?></td>
                    <td rowspan="8" class="image-cell content__body-td-modal">
                        <?php
                        // Lưu tất cả URL ảnh vào mảng
                        $images = [];
                        while ($row__hinhanhsp = $result_hinhanhsp->fetch_assoc()) {
                            $images[] = $row__hinhanhsp['urlhinhanh'];
                        }
                        ?>
                        <div class="content__body-td-modal-img">
                            <div class="image-container">
                                <?php foreach ($images as $image): ?>
                                    <img src="/CHDDTTHKN/assets/img/products/<?php echo htmlspecialchars($image); ?>" alt="Hình ảnh sản phẩm">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Giá</td>
                    <td class="content__body-td-modal"><?php echo number_format($row_sanpham["dongia"], 0, ',', '.') ?> VND</td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Mô tả</td>
                    <td class="content__body-td-modal"><?php echo htmlspecialchars($row_sanpham["mota"]) ?></td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Số lượng</td>
                    <td class="content__body-td-modal"><?php echo htmlspecialchars($row_sanpham["soluongconlai"]) ?></td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Kích thước</td>
                    <td class="content__body-td-modal">
                        <?php

                        $sql_kichthuoc = "SELECT kichthuoc FROM kichthuocsanpham WHERE idKichThuoc = " . $row_sanpham["idKichThuoc"];
                        $result_kichthuoc = mysqli_query($conn, $sql_kichthuoc);

                        while ($row_kichthuoc = mysqli_fetch_array($result_kichthuoc)) {
                            echo htmlspecialchars($row_kichthuoc["kichthuoc"]);
                            break;
                        }

                        ?>
                    </td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Màu sắc</td>
                    <td class="content__body-td-modal">
                        <?php
                        $sql_mausac = "SELECT * FROM mausacsanpham WHERE idMauSac = " . $row_sanpham["idMauSac"];
                        $result_mausac = mysqli_query($conn, $sql_mausac);

                        while ($row_mausac = mysqli_fetch_array($result_mausac)) {
                            echo htmlspecialchars($row_mausac["mausac"]);
                            break;
                        }
                        ?>
                    </td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Ngày tạo</td>
                    <td class="content__body-td-modal"><?php echo date("d/m/Y H:i:s", strtotime($row_sanpham["ngaytao"])) ?></td>
                </tr>

                <tr class="content__body-tr-modal">
                    <td class="content__body-td-modal">Trạng thái</td>
                    <td class="content__body-td-modal">
                        <?php
                        if ($row_sanpham["trangthai"] == 1) {
                            echo "Còn bán";
                        } else if ($row_sanpham["trangthai"] == 0) {
                            echo "Hết hàng";
                        }
                        ?>
                    </td>
                </tr>

            </tbody>
        </table>
<?php
        echo '</div>';
    } else {
        echo '<div style="text-align: center; font-family: Arial, sans-serif; color: #333;">Không tìm thấy chi tiết sản phẩm.</div>';
    }
} else {
    echo '<div style="text-align: center; font-family: Arial, sans-serif; color: #333;">ID sản phẩm không hợp lệ.</div>';
}

include($_SERVER['DOCUMENT_ROOT'] . "/CHDDTTHKN/assets/view/QuanLy/includes/footer.php");

?>