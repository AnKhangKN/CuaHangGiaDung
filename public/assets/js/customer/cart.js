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

        if (sl >= 1 && unitPrice >= 1) {
            var total = sl * unitPrice;
        } else {
            var total = unitPrice;
        }

        row.find(".total_price").text(total);
    }

    // Hàm cập nhật tổng giá trị tất cả các sản phẩm
    function updateTotalAllPrice() {
        var totalPrice = 0;
        // Duyệt qua tất cả các hàng trong giỏ hàng
        $(".cart_contents_table").each(function () {
            var totalUnit = parseFloat($(this).find(".total_price").text());
            totalPrice += totalUnit;  // Cộng dồn vào tổng
        });
        // Cập nhật giá trị tổng cho toàn bộ giỏ hàng
        $(".total_all_price").text(totalPrice);
    }

    function checkValue(inputField) {
        const soluong = parseInt(inputField.val());
        const productInfo = inputField.closest(".cart_contents_table");
        let amount = parseInt(productInfo.find("#productAmount").text()); 

        if(soluong > amount){
            inputField.val(amount);
        }else if(soluong <= 0){
            productInfo.remove();
            updateProductCount();
            updateTotalAllPrice();
        }
    }

    // Cập nhật giá trị totalPrice khi trang tải
    $(".cart_contents_table").each(function () {
        updateTotalPrice($(this));
    });

    // Cập nhật số lượng khi người dùng thay đổi
    $(".cart-table-number").on("input", function () {
        var rowProduct = $(this).closest(".cart_contents_table");
        updateTotalPrice(rowProduct);
        updateTotalAllPrice();
        checkValue($(this));

        var currentValue = parseInt(this.value);

        // Cập nhật giỏ hàng qua AJAX
        var quantity = currentValue;
        var productId = rowProduct.find("#idSanPham_item").text();
        var size = rowProduct.find(".cart-table-size").text();
        var color = rowProduct.find(".cart-table-color").text();

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/update_cart.php", // Đảm bảo URL đúng
            data: {
                action: 'update',
                productId: productId,
                size: size,
                color: color,
                quantity: quantity
            },
            success: function(response) {
                console.log(response); // Hiển thị thông báo từ PHP
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " - " + errorThrown);
                alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
            }
        });
    });

    // Xóa sản phẩm khỏi giỏ hàng
    $(".cart-table-remove").click(function (e) {
        e.preventDefault();

        // Lấy thông tin sản phẩm cần xóa
        var rowProduct = $(this).closest(".cart_contents_table");
        var productId = rowProduct.find("#idSanPham_item").text();
        var size = rowProduct.find(".cart-table-size").text();
        var color = rowProduct.find(".cart-table-color").text();

        rowProduct.remove();

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
                console.log(response); // Hiển thị thông báo từ PHP
                alert("Sản phẩm đã được xóa khỏi giỏ hàng!");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " - " + errorThrown);
                alert("Có lỗi xảy ra khi xóa sản phẩm!");
            }
        });
    });

    
    // duyệt từng dòng để lấy tổng số lượng còn lại trong cơ sở dữ liệu
    $(".cart_contents_table").each(function () {
        const rowProduct = $(this); // Trỏ đến từng dòng
        const size = rowProduct.find(".cart-table-size").text();
        const color = rowProduct.find(".cart-table-color").text();
        const productId = rowProduct.find("#idSanPham_item").text();

        // Gửi AJAX cho từng sản phẩm (nếu cần)
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/ProductAmount_cart.php",
            data: {
                size: size,
                color: color,
                productId: productId
            },
            success: function (response) {
                rowProduct.find('#productAmount').html(response); // Cập nhật số lượng từng dòng
                console.log(response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                rowProduct.find('#ProductAmount').html("Có lỗi xảy ra");
            }
        });
    });

    $(".cart-table-plus").click(function (e) {
        e.preventDefault();
    
        var rowProduct = $(this).closest(".cart_contents_table");
    
        var inputField = rowProduct.find(".cart-table-number");
        var currentCount = parseInt(inputField.val()) || 0;
    
        var amuontElement = rowProduct.find("#productAmount");
        var maxAmount;
    
        if (amuontElement.length > 0) {
            maxAmount = parseInt(amuontElement.text());
        } else {
            maxAmount = Infinity; // Nếu không có phần tử `#productAmount`, đặt maxAmount là vô hạn
        }
    
        let newCount = currentCount + 1;
        if (newCount > maxAmount) {
            newCount = maxAmount;
            
        }
    
        inputField.val(newCount);
    
        // Cập nhật tổng giá trị cho sản phẩm này
        updateTotalPrice(rowProduct);
        updateTotalAllPrice();
    
        // Lấy thông tin sản phẩm
        var quantity = newCount;
        var productId = rowProduct.find("#idSanPham_item").text(); // ID sản phẩm
        var size = rowProduct.find(".cart-table-size").text();     // Kích thước
        var color = rowProduct.find(".cart-table-color").text();   // Màu sắc
    
        if (!productId || !size || !color || isNaN(quantity)) {
            console.error("Dữ liệu không hợp lệ:", { productId, size, color, quantity });
            alert("Dữ liệu sản phẩm không hợp lệ!");
            return;
        }
    
        // Gửi yêu cầu AJAX để cập nhật giỏ hàng
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/update_cart.php",
            data: {
                action: 'update',
                productId: productId,
                size: size,
                color: color,
                quantity: quantity
            },
            success: function (response) {
                console.log("Phản hồi từ server:", response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Lỗi:", textStatus, errorThrown);
                alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
            }
        });
    });
    
    

    $(".cart-table-minus").click(function (e) {
        e.preventDefault();
        
        var rowProduct = $(this).closest(".cart_contents_table");
        var inputField = $(this).siblings(".cart-table-number");
        
        var currentCount = parseInt(inputField.val());
        var newCount = Math.max(0, currentCount - 1); 
    
        if (newCount <= 0) {
            rowProduct.remove(); 
            updateProductCount();
        }
    
        inputField.val(newCount);
    
        updateTotalPrice($(this).closest(".cart_contents_table"));
        updateTotalAllPrice();
    
        var productId = rowProduct.find("#idSanPham_item").text(); 
        var size = rowProduct.find(".cart-table-size").text(); 
        var color = rowProduct.find(".cart-table-color").text(); 
    
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/update_cart.php", 
            data: {
                action: 'update',
                productId: productId,
                size: size,
                color: color,
                quantity: newCount
            },
            success: function(response) {
                console.log(response); 
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Lỗi: " + textStatus + " - " + errorThrown);
                alert("Có lỗi xảy ra khi cập nhật giỏ hàng!");
            }
        });
    });
    

    updateProductCount();
    updateTotalAllPrice();
});
