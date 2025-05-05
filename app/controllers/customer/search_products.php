<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/CuaHangGiaDung/app/controllers/customer/customerController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/CuaHangGiaDung/config/connectdb.php';


if(isset($_GET['query'])){
    $product = $_GET['query'];
    
    $product_search = searchProductByName($product);
    
    if(!empty($product_search)){
        foreach($product_search as $row){
            ?>
            <a href="index.php?page=details&id=<?php echo htmlentities($row['idSanPham'])?>" style="text-decoration: none; color: #333;">
                    
            <div class="product_card_search">
                <div class="card_search_left">
                        <div class="card_search_img">
                            <img src="../public/assets/images/products/<?php echo htmlentities($row['urlhinhanh'])?>" alt="">
                        </div>
                        <p><?php echo htmlentities($row['tensanpham'])?></p>
                    </div>
                    <div class="card_search_right">
                        <p><?php echo number_format($row['dongia'], 0, ',', '.') ?> đ</p>

                    </div>
                
            </div>
            </a>
            <?php
        }
    }else {
        // Nếu không có sản phẩm nào
        echo '<p>Không tìm thấy sản phẩm nào.</p>';
    }
    

}
?>