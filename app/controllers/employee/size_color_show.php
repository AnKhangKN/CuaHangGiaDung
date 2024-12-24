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
        <span style="font-weight: 500; margin-top: 10px;">Kích thước:</span>
        <div id="sizeContainer" style="margin-left: 30px; margin-top: 10px;">
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
        <span style="font-weight: 500; margin-top: 7px;">Màu sắc:</span>
        <div class="colorContainer d-flex" style="margin-left: 46px;">
        <?php
        foreach ($color as $row_color) {
            ?>


            <div class="content m-2 d-flex">
              <label class="checkBox" style="box-shadow: 0px 0px 0px 2px <?php echo htmlentities($row_color['mausac']);?>;">
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
