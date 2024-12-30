$(document).ready(function () {
    const containerComment = $("#container_comment");

    // Hiển thị hoặc ẩn container_comment khi nhấn nút "btn_get_comment"
    $(".btn_get_comment").click(function (e) {
        e.preventDefault();

        const button = $(this);
        const containerRow = button.closest(".row_product");

        // Chuyển đổi trạng thái hiển thị container_comment
        if (containerComment.css("display") === "none") {
            containerComment.css("display", "flex");
        } else {
            containerComment.css("display", "none");
            return;
        }

        checkCustomerStatus((response) => {
            if (response.status === "logged_in") {
                getInfo(response.idKhachHang, containerRow);
            } else {
                alert("Bạn cần đăng nhập để xem bình luận!");
                containerComment.css("display", "none");
            }
        });
    });

    // Ẩn container_comment khi nhấn nút hủy
    $("#cancel_comment").click(function (e) {
        e.preventDefault();
        containerComment.css("display", "none");
    });

    // Kiểm tra trạng thái đăng nhập của khách hàng
    function checkCustomerStatus(callback) {
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/check_customer_status.php",
            dataType: "json",
            success: callback,
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi kiểm tra trạng thái khách hàng:", textStatus, errorThrown);
            }
        });
    }

    // Lấy thông tin sản phẩm và hiển thị
    function getInfo(idKhachHang, containerRow) {
        const ProductId = containerRow.find(".idSanPham").text().trim();
        const ProductName = containerRow.find(".tensanpham").text().trim();

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/get_product_comment.php",
            data: {
                action: "getProductComment",
                idKhachHang: idKhachHang,
                ProductId: ProductId,
                ProductName: ProductName
            },
            success: function (response) {
                const data = JSON.parse(response);

                if (data.status === 'success') {
                    $("#product_img").attr('src', data.hinhanh);
                    $("#product_name").text(data.tenSanPham);
                    $("#product_id").text(data.idSanPham);
                } else {
                    console.error(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi gửi yêu cầu lấy bình luận:", textStatus, errorThrown);
            }
        });
    }

    // Gửi bình luận
    function sendComment(idKhachHang) {
        const productId = $("#product_id").text().trim();
        const comment = $("#floatingTextarea2").val().trim();
        const billId = $("#idHoaDon_ct").text().trim();

        if (!comment) {
            alert("Bình luận không được để trống!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/send_comment.php",
            data: {
                action: 'sendComment',
                productId: productId,
                billId: billId,
                comment: comment,
                idKhachHang: idKhachHang
            },
            success: function (response) {
                const data = JSON.parse(response);
                if (data.status === 'success') {
                    alert(data.message);
                    $("#floatingTextarea2").val(""); // Xóa nội dung sau khi gửi
                    $("#container_comment").css('display', 'none');
                    location.reload();
                } else {
                    console.error(data.message);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi gửi bình luận:", textStatus, errorThrown);
            }
        });
    }

    // Xử lý gửi bình luận
    $("#send_comment").click(function (e) {
        e.preventDefault();

        checkCustomerStatus((response) => {
            if (response.status === 'logged_in') {
                sendComment(response.idKhachHang);
            } else {
                alert("Bạn cần đăng nhập để gửi bình luận!");
            }
        });
    });
});
