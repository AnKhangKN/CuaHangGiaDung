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
            url: "/CuaHangDungCu/app/controllers/employee/add_product_detail.php",
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
            url: "/CuaHangDungCu/app/controllers/employee/size_color_show.php",
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
            url: "/CuaHangDungCu/app/controllers/employee/get_product_detail.php",
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
            url: "/CuaHangDungCu/app/controllers/employee/add_to_cart.php",
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
            url: "/CuaHangDungCu/app/controllers/employee/delete_item_cart.php",
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
