$(document).ready(function () {
    // Lấy tất cả các dòng sản phẩm
    const allRowProduct = $(".cell_product");
    const close = $("#close");

    // Lấy modal chi tiết sản phẩm
    const ChiTietSanPham = $("#modal_product_detail");

    $(close).click(function (e) {
        e.preventDefault();
        ChiTietSanPham.css({ display: 'none' });
        $('#late_amount').html(0);
        $('#idchitietsanpham').html(0);
    });

    // Thêm sự kiện click cho từng dòng sản phẩm
    allRowProduct.on('click', function () {
        ChiTietSanPham.css({ display: 'flex' });

        const idSanPham = $(this).find(".idSanPham").text();
        const tenSanPham = $(this).find(".tenSanPham").text();
        const giaSanPham = $(this).find(".giaSanPham").text();
        const imgSanPham = $(this).find(".imgSanPham").attr("src");

        $.ajax({
            type: "POST",
            url: "/CuaHangGiaDung/app/controllers/employee/add_product_detail.php",
            data: {
                action: 'InfoSanPham',
                idSanPham: idSanPham,
                tenSanPham: tenSanPham,
                imgSanPham: imgSanPham,
                giaSanPham: giaSanPham
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        $("#idSanPham").text(data.idSanPham);
                        $("#ProductName").text(data.tenSanPham);
                        $("#ProductPrice").text(data.giaSanPham);
                        $("#imgProduct").attr("src", data.imgSanPham);
                    } else {
                        console.error("Không thể lấy thông tin sản phẩm:", data.message);
                    }
                } catch (error) {
                    console.error("Lỗi khi xử lý JSON:", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });

        $.ajax({
            type: "POST",
            url: "/CuaHangGiaDung/app/controllers/employee/size_color_show.php",
            data: { idSanPham: idSanPham },
            success: function(response) {
                $("#product_detail_body").html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                alert("Lỗi khi kết nối tới server.");
            }
        });
    });
});

$(document).ready(function () {
    $(document).on("change", ".size_input, .color_input", function (e) {
        e.preventDefault();

        const container = $(this).closest("#modal_product_detail");

        // Đảm bảo chỉ một checkbox được chọn trong nhóm size_input
        if ($(this).hasClass("size_input")) {
            container.find(".size_input").not(this).prop("checked", false);
        }

        // Đảm bảo chỉ một checkbox được chọn trong nhóm color_input
        if ($(this).hasClass("color_input")) {
            container.find(".color_input").not(this).prop("checked", false);
        }

        let size_product = container.find(".size_input:checked").val();
        if (!size_product) {
            size_product = "Không có kích thước";
        }

        const color_product = container.find(".color_input:checked").val();
        const idProduct = container.find("#idSanPham").text();

        $.ajax({
            type: "POST",
            url: "/CuaHangGiaDung/app/controllers/employee/get_product_detail.php",
            data: {
                action: "select",
                size: size_product,
                color: color_product,
                productId: idProduct
            },
            success: function (response) {
                if (response.includes('|')) {
                    const [amount, id] = response.split('|');
                    $('#late_amount').html(amount);
                    $('#idchitietsanpham').html(id);
                }
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#late_amount').html("Có lỗi xảy ra");
                
            }
        });
    });

    $(document).on("click", "#up_product", function (e) {
        e.preventDefault();

        const container = $(this).closest("#modal_product_detail");

        const amount = parseInt(container.find("#late_amount").text()) || 0;

        if (amount === 0) {
            alert("Sản phẩm này đã hết hàng!");
        } else {
            let soluong = parseInt(container.find("#amount_product").val()) || 0;

            let newCount = soluong + 1;

            if (soluong >= amount) {
                newCount = amount;
            }

            container.find("#amount_product").val(newCount);
        }
    });

    $(document).on("click", "#down_product", function (e) {
        e.preventDefault();

        const container = $(this).closest("#modal_product_detail");

        let soluong = parseInt(container.find("#amount_product").val()) || 0;

        if (soluong > 0) {
            soluong--;
            container.find("#amount_product").val(soluong);
        }
    });

    $(document).on("change", "#amount_product", function (e) {
        e.preventDefault();

        const container = $(this).closest("#modal_product_detail");
        const amount = parseInt(container.find("#late_amount").text()) || 0;

        let soluong = parseInt(container.find("#amount_product").val()) || 0;

        if (soluong > amount) {
            soluong = amount;
        }

        container.find("#amount_product").val(soluong);
    });

    $(document).on("click", "#add", function (e) {
        e.preventDefault();
    
        const container = $(this).closest("#modal_product_detail");
    
        const idSanPham = container.find("#idSanPham").text();
        const tenSanPham = container.find("#ProductName").text();
        let soluong = container.find("#amount_product").val();
        const dongia = container.find("#ProductPrice").text();
        const idChiTietSanPham = container.find("#idchitietsanpham").text();
        const mau = container.find(".color_input:checked").val();
        let kichthuoc = container.find(".size_input:checked").val();

        if(!kichthuoc){
            kichthuoc = "Không có kích thước";
        }
    
        $.ajax({
            type: "POST",
            url: "/CuaHangGiaDung/app/controllers/employee/add_to_cart.php",
            data: {
                action: 'add_cart',
                idSanPham: idSanPham,
                tenSanPham: tenSanPham,
                soluong: soluong,
                dongia: dongia,
                idChiTietSanPham: idChiTietSanPham,
                mau: mau,
                kichthuoc: kichthuoc
            },
            success: function (response) {
                console.log(response);
                container.css('display', 'none');  
                location.reload();
            }
        });
    });


    $(document).on("click", ".remove_cart", function () {
        const container_cart = $(this).closest(".SanPham_buy");
    
        const idSanPham = container_cart.find(".idSanPham_buy").text();
        const idChiTietSanPham = container_cart.find(".idChiTietSanPham_buy").text();
        const tenSanPham = container_cart.find(".tenSanPham_buy").text();
        const mau = container_cart.find(".mau_buy").text();
        const kichthuoc = container_cart.find(".kichthuoc_buy").text();
    
        // Send AJAX request to delete the item
        $.ajax({
            type: "POST",
            url: "/CuaHangGiaDung/app/controllers/employee/delete_item_cart.php",
            data: {
                action: "remove_cart",
                idSanPham: idSanPham,
                idChiTietSanPham: idChiTietSanPham,
                tenSanPham: tenSanPham,
                mau: mau,
                kichthuoc: kichthuoc
            },
            success: function (response) {
                container_cart.remove();
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("Failed to remove item:", error);
                alert("Error removing item. Please try again.");
            }
        });
    });
    
    
    
});

$(document).ready(function () {
    $('#search').on('input', function () {
        const query = $(this).val(); // Lấy giá trị input
    
        $.ajax({
            url: '/CuaHangGiaDung/app/controllers/employee/search_product.php',
            method: 'POST',
            data: { query: query },  // Gửi cả khi là chuỗi trống
            success: function (data) {
                $('#product_container').html(data);
            },
            error: function () {
                console.error('Lỗi xảy ra khi tìm kiếm.');
            }
        });
    });

    $("#myInput").on("input", function () {
        const phone = $(this).val().trim();
    
        // Kiểm tra nếu ô input không trống
        if (phone.length > 0) {
            // Gửi yêu cầu AJAX nếu có giá trị trong input
            $.ajax({
                url: '/CuaHangGiaDung/app/controllers/employee/search_customer.php',
                method: 'POST',
                data: { phone: phone },
                success: function (data) {
                    $('#myList').html(data); 
                },
                error: function () {
                    console.error('Lỗi xảy ra khi tìm kiếm.');
                }
            });
        } else {
            // Nếu ô input trống, có thể xóa kết quả hiển thị
            $('#myList').html('');
        }
    });
    
    // Tổng tiền
    let tongTien = 0; 

    $(".SanPham_buy").each(function () {
        const container = $(this);
        const giaText = container.find(".don_gia").text().trim(); 
        const giaSo = parseFloat(giaText.replace(/[^\d.-]/g, "")); 

        if (!isNaN(giaSo)) {
            tongTien += giaSo; 
        } else {
            console.warn("Không thể chuyển đổi giá trị thành số:", giaText);
        }
    });

    $("#tong_don_gia").text(tongTien);

// -----------------------------------------------------------------------

$(document).on("click", ".list-group-item", function () {
    const container = $(this);
    const idKhach = container.find(".idKhach").text().trim();
    const ten = container.find(".tenKhach").text().trim();
    const sdt = container.find(".Sdt").text().trim();
    
    $("#idKhach").text(idKhach);
    $("#tenKhach").text(ten);
    $("#sdtKhach").text(sdt);

    
});

// Function for processing orders with Customer ID
function dsDonHangCoIdKH() {
    const container_payment = $('#Payment_send');

    const idKhachHang = container_payment.find('#idKhach').text().trim();
    const idNhanVien = container_payment.find('#idNhanVien').text().trim();
    const tongtien = parseFloat(container_payment.find('#tong_don_gia').text().trim()); // Convert to number

    if (!idKhachHang || !idNhanVien || isNaN(tongtien)) {
        alert("Vui lòng kiểm tra lại giá trị của 'idKhachHang', 'idNhanVien', và 'tongtien'.");
        return;
    }

    let products = [];
    $('.SanPham_buy').each(function () {
        const lstProduct = $(this);
        const soluong = parseInt(lstProduct.find('.soluongSP').text().trim());
        const idChiTietSanPham = lstProduct.find('.idChiTietSanPham_buy').text().trim();

        if (soluong && idChiTietSanPham) {
            products.push({ soluong, idChiTietSanPham });
        }
    });

    if (products.length === 0) {
        alert("Danh sách sản phẩm không được để trống!");
        return;
    }

    console.log("Danh sách sản phẩm:", products);

    $.ajax({
        type: "POST",
        url: "/CuaHangGiaDung/app/controllers/employee/payment_customer.php",
        data: {
            action: "CustomerId",
            idKhachHang: idKhachHang,
            idNhanVien: idNhanVien,
            tongtien: tongtien,
            products: JSON.stringify(products),
        },
        success: function (response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert(`Yêu cầu thành công! Mã hóa đơn: ${data.idHoaDon}`);
                location.reload();
            } else {
                alert("Đã xảy ra lỗi: " + data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Yêu cầu không thành công:", error);
            alert("Đã có lỗi xảy ra. Vui lòng thử lại.");
        }
    });
}

// Trigger payment process
$("#ThanhToan").click(function (e) {
    e.preventDefault();

    const status = $("#status_customer:checked").val();
    if (status === "0") {  // Ensuring string check here
        dsDonHangKhongCoThongTin();
        console.log("Chưa có thông tin khách hàng:", status);
    } else {
        dsDonHangCoIdKH();
    }
});

// Function for processing orders without Customer ID
function dsDonHangKhongCoThongTin() {
    const container_payment = $('#Payment_send');

    const idNhanVien = container_payment.find('#idNhanVien').text().trim();
    const tongtien = parseFloat(container_payment.find('#tong_don_gia').text().trim()); // Convert to number

    if (isNaN(tongtien) || !idNhanVien) {
        alert("Vui lòng kiểm tra lại thông tin nhân viên hoặc tổng tiền.");
        return;
    }

    let products = [];
    $('.SanPham_buy').each(function () {
        const lstProduct = $(this);
        const soluong = parseInt(lstProduct.find('.soluongSP').text().trim());
        const idChiTietSanPham = lstProduct.find('.idChiTietSanPham_buy').text().trim();

        if (soluong && idChiTietSanPham) {
            products.push({ soluong, idChiTietSanPham });
        }
    });

    if (products.length === 0) {
        alert("Danh sách sản phẩm không được để trống!");
        return;
    }

    console.log("Danh sách sản phẩm:", products);

    $.ajax({
        type: "POST",
        url: "/CuaHangGiaDung/app/controllers/employee/payment_no_acc.php",
        data: {
            action: "NoAcc",
            idNhanVien: idNhanVien,
            tongtien: tongtien,
            products: JSON.stringify(products),
        },
        success: function (response) {
            const data = JSON.parse(response);
            if (data.status === "success") {
                alert(`Yêu cầu thành công! Mã hóa đơn: ${data.idHoaDon}`);
                location.reload();
            } else {
                alert("Đã xảy ra lỗi: " + data.message);
            }
        },
        error: function (xhr, status, error) {
            console.error("Yêu cầu không thành công:", error);
            alert("Đã có lỗi xảy ra. Vui lòng thử lại.");
        }
    });
}


});
