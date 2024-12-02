$(document).ready(function () {
    // Xử lý hiển thị container_comment khi nhấn nút "btn_get_comment"
    $(".btn_get_comment").click(function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút

        const button = $(this); // Nút vừa được nhấn
        const containerRow = button.closest(".row_product"); // Dòng sản phẩm chứa nút này
        const containerComment = $("#container_comment"); // Container của bình luận

        // Chuyển đổi trạng thái hiển thị của container_comment
        if (containerComment.css("display") === "none") {
            containerComment.css("display", "flex");
        } else {
            containerComment.css("display", "none");
            return; // Thoát khỏi xử lý nếu chỉ thay đổi trạng thái hiển thị
        }

        // Gửi AJAX để kiểm tra trạng thái khách hàng
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/check_customer_status.php",
            dataType: "json",
            success: function (response) {
                if (response.status === "logged_in") {
                    // Nếu khách hàng đã đăng nhập, gọi hàm gửi bình luận
                    getInfo(response.idKhachHang, containerRow);
                } else {
                    // Nếu chưa đăng nhập, hiển thị thông báo
                    alert("Bạn cần đăng nhập để xem bình luận!");
                    containerComment.css("display", "none"); // Ẩn container nếu không đăng nhập
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi kiểm tra trạng thái khách hàng:", textStatus, errorThrown);
            }
        });
    });

    // Xử lý nút hủy (cancel) để ẩn container_comment
    $("#cancel_comment").click(function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định
        const containerComment = $("#container_comment"); // Container của bình luận

        // Ẩn container nếu đang hiển thị
        if (containerComment.css("display") === "flex") {
            containerComment.css("display", "none");
        }
    });

    // Hàm gửi bình luận cho dòng sản phẩm cụ thể
    function getInfo(idKhachHang, containerRow) {
        // Lấy thông tin sản phẩm từ dòng hiện tại
        const ProductId = containerRow.find(".idSanPham").text().trim();
        const ProductName = containerRow.find(".tensanpham").text().trim();

        // Gửi AJAX để lấy bình luận của sản phẩm
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
                    const productId = $("#product_id");
                    const productName = $("#product_name");
                    const productImg = $("#product_img");
                
                    productImg.attr('src', data.hinhanh);  
                
                    productName.text(data.tenSanPham);
                    productId.text(data.idSanPham);
                } else {
                    console.log(data.message);
                }
                
                
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Lỗi khi gửi yêu cầu lấy bình luận:", textStatus, errorThrown);
            }
        });
    }

// xử lý comment
    function sendComment (idKhachHang){
        const container = $(".content_comment");
        const productId = container.find("#product_id").text();
        const comment = container.find("#floatingTextarea2").val();

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/send_comment.php",
            data: {
                action: 'sendComment',
                productId: productId,
                comment: comment,
                idKhachHang: idKhachHang
            },
            success: function (response) {
                const data = JSON.parse(response);
                const comment = $('#container_comment');
                if(data.status === 'success'){
                    alert(data.message);
                }else{
                    console.log(data.message);
                }

            }
        });
    }

    $("#send_comment").click(function (e) { 
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/check_customer_status.php",
            dataType: "json",  // No need to parse JSON manually
            success: function (response) {
                if (response.status === 'logged_in') {  
    
                    sendComment(response.idKhachHang);
                } else {
                    // Handle the case where the user is not logged in
                    console.log('User is not logged in');
                }
            },
            error: function (xhr, status, error) {
                // Handle AJAX error
                console.error('AJAX request failed: ' + status + ' - ' + error);
            }
        });
    });
    

});
