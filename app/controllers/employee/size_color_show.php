<?php

require_once "../../../config/connectdb.php";
require_once "../../../app/controllers/employee/all_function.php";

if (isset($_POST['idSanPham']) && is_numeric($_POST['idSanPham']) && $_POST['idSanPham'] > 0) {
    $conn = connectBD();
    $idSanPham = $_POST['idSanPham'];

    // Lấy danh sách kích thước sản phẩm
    $size = getSizeByProductId($idSanPham);

    // Kiểm tra nếu không có kích thước
    if (!$size || count($size) === 0) {
        echo "<p>Không có kích thước nào cho sản phẩm này.</p>";
        exit;
    }

    ?>
    
    <div class="detail_size d-flex align-content-center" >
        <p style="font-weight: 500; margin-top: 10px; width: 155px">Kích thước:</p>
        <div id="sizeContainer" style="margin-top: 10px;">
        <?php
        foreach ($size as $row) {
            ?>
            <input type="checkbox" class="size_input" value="<?php echo htmlentities($row['kichthuoc']); ?>" name="size[]" id="size_<?php echo htmlentities($row['kichthuoc']); ?>">
            <label for="size_<?php echo htmlentities($row['kichthuoc']); ?>"><?php echo htmlentities($row['kichthuoc']); ?></label>
            <?php
        }
        ?>
        </div>
    </div>

    <?php

    // Lấy danh sách màu sắc sản phẩm
    $color = getColorByProductId($idSanPham);

    // Kiểm tra nếu không có màu sắc
    if (!$color || count($color) === 0) {
        echo "<p>Không có màu sắc nào cho sản phẩm này.</p>";
        exit;
    }

    ?>
    
    <div class="detail_color d-flex align-content-center">
        <p style="font-weight: 500; width: 155px">Màu sắc:</p>
        <div class="colorContainer d-flex">
        <?php
        foreach ($color as $row_color) {
            ?>


            <div class="content d-flex align-items-center me-2">
              <label class="checkBox" style="margin-bottom: 20px; box-shadow: 0px 0px 0px 2px <?php echo htmlentities($row_color['mausac']);?>;">
                <input name="color[]" id="color_<?php echo htmlentities($row_color['mausac']); ?>" type="checkbox" class="color_input" value="<?php echo htmlentities($row_color['mausac']);?>">
                <div class="transition" style="background-color: <?php echo htmlentities($row_color['mausac']);?>;"></div>
              </label>
            </div>


            
            <?php
        }
        ?>
        </div>
    </div>

    <?php

} else {
    echo "<p>Yêu cầu không hợp lệ. Vui lòng cung cấp ID sản phẩm hợp lệ.</p>";
}

?>
