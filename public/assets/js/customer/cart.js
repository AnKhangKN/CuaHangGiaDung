$(document).ready(function () {
    // Hàm cập nhật số lượng sản phẩm
    function updateProductCount() {
        var count_product = $("#cart").children(".cart_contents_table").length;
        $("#count_product").text(count_product);
    }

    // Hàm cập nhật giá trị totalPrice cho một sản phẩm
    function updateTotalPrice(row) {
        var sl = parseInt(row.find(".cart-table-number").val()) || 1;
        var unitPrice = parseFloat(row.find(".unit_price").text());

        var nameProduct = row.find(".cart-table-name").text();
        // console.log(nameProduct);

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
            var totalUnit = parseFloat($(this).find(".total_price").text()) || 0;  // Lấy giá trị tổng cho sản phẩm
            totalPrice += totalUnit;  // Cộng dồn vào tổng
        });

        // Cập nhật giá trị tổng cho toàn bộ giỏ hàng
        $(".total_all_price").text(totalPrice);  // Hiển thị giá trị với 2 chữ số thập phân
    }

    // Cập nhật giá trị totalPrice khi trang tải
    $(".cart_contents_table").each(function () {
        updateTotalPrice($(this));  // Gọi hàm cập nhật totalPrice khi trang tải
    });

    $(".cart-table-remove").click(function (e) { 
        e.preventDefault();
        var rowProduct = $(this).closest(".cart_contents_table");
        var name = rowProduct.find(".cart-table-name").text();
        rowProduct.remove();
        console.log(name);
        updateProductCount();
        updateTotalAllPrice();  
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
