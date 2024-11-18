$(document).ready(function () {

    function checkInfo() {
        // Lấy giá trị và loại bỏ khoảng trắng thừa
        const name = $('#name').val().trim();
        const email = $('#email').val().trim();
        const phone = $('#phone').val().trim();
        const address = $('#address').val().trim();
        
        // Lấy các phần tử hiển thị lỗi
        const errorName = $('.error_name');
        const errorEmail = $('.error_email');
        const errorPhone = $('.error_phone');
        const errorAddress = $('.error_address');
        
        // Xóa thông báo lỗi cũ mỗi lần kiểm tra
        errorName.text('');
        errorEmail.text('');
        errorPhone.text('');
        errorAddress.text('');
        
        // Biến xác định tính hợp lệ của form
        let isValid = true;
        
        // Kiểm tra các trường thông tin bắt buộc
        if (name == '') {
            $('#name').css('border-color', 'red');
            errorName.text("Hãy nhập họ và tên!");
            isValid = false;
        } else {
            $('#name').css('border-color', '');
        }
    
        if (email == '') {
            $('#email').css('border-color', 'red');
            errorEmail.text("Hãy nhập email của bạn!");
            isValid = false;
        } else {
            $('#email').css('border-color', '');
        }
    
        if (phone == '') {
            $('#phone').css('border-color', 'red');
            errorPhone.text("Hãy nhập số điện thoại của bạn!");
            isValid = false;
        } else {
            $('#phone').css('border-color', '');
        }
    
        if (address == '') {
            $('#address').css('border-color', 'red');
            errorAddress.text("Hãy nhập địa chỉ của bạn!");
            isValid = false;
        } else {
            $('#address').css('border-color', '');
        }
    
        // Kiểm tra phương thức thanh toán sau khi tất cả các trường đã hợp lệ
        if (isValid) {
            const cod = $('#payment_by_cod');
            const card = $('#payment_by_card');
            if (!cod.is(':checked') && !card.is(':checked')) {
                // Nếu phương thức thanh toán chưa được chọn, hiển thị modal lỗi
                $('#modalErrorMessage').text("Bạn hãy chọn phương thức thanh toán!");
                $('#errorModal').modal('show');  // Hiển thị modal
                return false;  // Ngừng quá trình kiểm tra form
            }
        }
    
        // Nếu tất cả kiểm tra đều hợp lệ
        return true;
    }
    
    
    
    
    
    let allPrice = 0; // Khởi tạo bên ngoài vòng lặp

    $(".list_infor_products_payment_item").each(function () {
        let lstItem = $(this);

        // Lấy số lượng sản phẩm từ span#soluong_item
        let amountProduct = parseInt(lstItem.find("#soluong_item").text().trim()) || 0;

        // Lấy giá sản phẩm từ span#price_item và làm sạch chuỗi
        let priceItemText = lstItem.find("#price_item").text().trim();
        let cleanPrice = parseFloat(priceItemText.replace(/\./g, '').replace(',', '.')) || 0;

        // Tính tổng giá cho sản phẩm hiện tại
        let totalPrice = amountProduct * cleanPrice;

        // Cộng dồn vào allPrice
        allPrice += totalPrice;
    });

    // Hiển thị tổng giá của tất cả sản phẩm vào phần tử #expense_item_price
    $("#expense_item_price").text(allPrice.toLocaleString("vi-VN"));

    // Tiền gồm vận chuyển
    const express = $("#expense_item_express").text();
    let cleanPrice = parseFloat(express.replace(/\./g, '').replace(',', '.')) || 0;

    $(".total_bill_due_price").text((cleanPrice + allPrice).toLocaleString("vi-VN"));
    
    // Xử lý sự kiện khi checkbox thay đổi
    $('.infor_payment_method_content_choose input[type="checkbox"]').change(function () {
        const payContainer = $(this).closest('.infor_payment_method_content_choose');
        const infoPayment = payContainer.find('.content_transfer');

        // Bỏ chọn các checkbox khác và ẩn nội dung liên quan
        $('.infor_payment_method_content_choose input[type="checkbox"]').not(this).prop('checked', false);
        $('.content_transfer').hide();

        // Hiển thị nội dung liên quan nếu checkbox được chọn
        if ($(this).is(':checked') && infoPayment.length) {
            infoPayment.show();
        }
    });

    // Xử lý sự kiện khi bấm nút tiếp tục
    $(".infor_payment_btn_continue").click(function (e) {
        e.preventDefault();  // Ngừng hành động mặc định của nút (nếu có)
    
    
        // Kiểm tra thông tin thanh toán
        if (checkInfo()) {
            // Nếu thông tin hợp lệ, tiếp tục với hành động tiếp theo
            console.log("Thông tin hợp lệ, tiếp tục thanh toán...");
            // Tiến hành tiếp tục với các bước tiếp theo, ví dụ: gửi form, thực hiện Ajax,...
        } else {
            // Nếu thông tin không hợp lệ, không làm gì thêm
            console.log("Thông tin không hợp lệ, vui lòng kiểm tra lại.");
        }
    });
    


    $(".list_infor_products_payment_item").each(function () {
        const listProduct = $(this);
        const size = listProduct.find("#size_product").text().trim();
        const color = listProduct.find("#color_product").text().trim();
        const productId = listProduct.find("#idSanPham_item").text().trim();

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/ProductAmount_cart.php",
            data: {
                size: size,
                color: color,
                productId: productId
            },
            success: function (response) {

                if (response.includes('|')) {
                    const [amount, id] = response.split('|');
                    listProduct.find('#idChiTietSanPham').html(id);
                    listProduct.find('#SoLuongConLai').html(amount);
                    
                } else {
                    console.log("Hãy chung cấp đủ thông tin!");
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                rowProduct.find('#ProductAmount').html("Có lỗi xảy ra");
            }
        });
    });
    
});
