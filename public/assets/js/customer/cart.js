$(document).ready(function () {
    // Hàm cập nhật số lượng sản phẩm
    function updateProductCount() {
        var count_product = $("#cart").children(".cart_contents_table").length;
        $("#count_product").text(count_product);
    }

    // Hàm cập nhật giá trị totalPrice cho một sản phẩm
    function updateTotalPrice(row) {
        var sl = parseFloat(row.find(".cart-table-number").val()) || 1;

        var formatPrice = row.find(".unit_price").text();
        var cleanPrice = formatPrice.replace(/\./g, '').replace(',', '.');

        var unitPrice = parseFloat(cleanPrice);

        var nameProduct = row.find(".cart-table-name").text();
        

        if(sl >= 1 && unitPrice >= 1){
            var total = sl * unitPrice;
        } else{
            var total = unitPrice; 
        }
        
        row.find(".total_price").text(total);  
    }

    // Hàm cập nhật tổng giá trị tất cả các sản phẩm
    function updateTotalAllPrice() {
        var totalPrice = 0;
        // Duyệt qua tất cả các hàng trong giỏ hàng
        $(".cart_contents_table").each(function () {
            var totalUnit = parseFloat($(this).find(".total_price").text()) || 0;  
            totalPrice += totalUnit;  // Cộng dồn vào tổng
        });
        // Cập nhật giá trị tổng cho toàn bộ giỏ hàng
        $(".total_all_price").text(totalPrice);  
    }

    // Cập nhật giá trị totalPrice khi trang tải
    $(".cart_contents_table").each(function () {
        updateTotalPrice($(this));  
    });

    $(".cart-table-remove").click(function (e) { 
        e.preventDefault();
        
        // Lấy thông tin sản phẩm cần xóa
        var rowProduct = $(this).closest(".cart_contents_table");
        var productId = rowProduct.find("#idSanPham_item").text(); // Lấy ID sản phẩm từ phần tử #idSanPham_item
        var size = rowProduct.find(".cart-table-size").text();
        var color = rowProduct.find(".cart-table-color").text();
        var name = rowProduct.find(".cart-table-name").text(); // Lấy tên sản phẩm (có thể sử dụng nếu cần)
    
        // Xóa sản phẩm khỏi giỏ hàng (hiển thị)
        rowProduct.remove();
        
        console.log("Sản phẩm ID cần xóa: " + productId);
    
        // Cập nhật số lượng sản phẩm và tổng giá sau khi xóa
        updateProductCount();
        updateTotalAllPrice();
        
        // Gửi yêu cầu AJAX để xóa sản phẩm khỏi giỏ hàng trong session
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/delete_cart_item.php", // Đảm bảo URL đúng
            data: {
                action: 'remove',
                productId: productId,
                size: size,
                color: color
            },
            success: function(response) {
                // Cập nhật giao diện giỏ hàng hoặc thông báo từ PHP
                console.log(response);
                alert(response); // Hiển thị thông báo thành công từ PHP
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " - " + errorThrown);
                alert("Có lỗi xảy ra khi xóa sản phẩm!");
            }
        });
    });
    

    $(".cart-table-minus").click(function (e) { 
        e.preventDefault();
        var inputField = $(this).siblings(".cart-table-number");
        var currentCount = parseInt(inputField.val()) || 1;
        var newCount = Math.max(1, currentCount - 1);
        inputField.val(newCount);
        updateTotalPrice($(this).closest(".cart_contents_table"));
        updateTotalAllPrice();  
    });

    $(".cart-table-plus").click(function (e) { 
        e.preventDefault();
        var inputField = $(this).siblings(".cart-table-number");
        var currentCount = parseInt(inputField.val()) || 1;
        var newCount = currentCount + 1;
        inputField.val(newCount);
        updateTotalPrice($(this).closest(".cart_contents_table"));
        updateTotalAllPrice();  
    });

    $(".cart-table-number").on("input", function () { 
        var rowProduct = $(this).closest(".cart_contents_table");
        updateTotalPrice(rowProduct);
        updateTotalAllPrice();  

        var currentValue = parseInt(this.value) || 1;
        if (currentValue < 1) {
            this.value = 1;
        }
    });

    updateProductCount();
    updateTotalAllPrice();  
});
