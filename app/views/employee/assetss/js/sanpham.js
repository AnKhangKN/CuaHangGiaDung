$(document).ready(function () {
    // Lấy tất cả các dòng sản phẩm
    const allRowProduct = $(".cell_product");
    const close = $("#close");

    // Lấy modal chi tiết sản phẩm
    const ChiTietSanPham = $("#modal_product_detail");

    $(close).click(function (e) {
        e.preventDefault();
        ChiTietSanPham.css({
            display: 'none'
            
        });
        $('#late_amount').html(0);
        $('#idchitietsanpham').html(0);
        
    });

    // Thêm sự kiện click cho từng dòng sản phẩm
    allRowProduct.on('click', function () {
        // Hiển thị modal chi tiết sản phẩm
        ChiTietSanPham.css({ display: 'flex' });

        // Lấy thông tin từ dòng được click
        const idSanPham = $(this).find(".idSanPham").text();
        const tenSanPham = $(this).find(".tenSanPham").text();
        const giaSanPham = $(this).find(".giaSanPham").text();
        const imgSanPham = $(this).find(".imgSanPham").attr("src");

        // Gửi thông tin chi tiết sản phẩm qua AJAX
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
                        // Hiển thị thông tin chi tiết trong modal
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

         // Gửi yêu cầu AJAX tới server
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/employee/size_color_show.php", // Đường dẫn tới file PHP
            data: { idSanPham: idSanPham },
            success: function(response) {
                // Gán nội dung trả về vào phần tử #sizeContainer
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

        // Lấy giá trị của checkbox được chọn
        const size_product = container.find(".size_input:checked").val();

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
});



