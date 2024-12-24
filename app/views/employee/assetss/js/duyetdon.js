$(document).ready(function () {
    // Đóng modal xác nhận hóa đơn
    $("#close_confirm_bill").click(function (e) { 
        e.preventDefault();

        const model = $("#model_detail_confirm_bill");

        if (model.css('display') === "flex") {
            model.css('display', 'none');
        }
    });

    // Hiển thị chi tiết hóa đơn trong modal
    $(".show_confirm_bill").click(function (e) { 
        e.preventDefault();
    
        // Lấy phần tử gần nhất có class .cell_bill
        const model = $(this).closest(".cell_bill");
    
        // Lấy các giá trị từ các phần tử con trong model
        const BillId = model.find(".idHoaDon").text().trim();
        const CustomerName = model.find(".tenkhachhang").text().trim();
        const CustomerId = model.find(".idKhachHang").text().trim();
        const phone = model.find(".sdt").text().trim();
        const address = model.find(".diachi").text().trim();
        const status = model.find(".status").text().trim();
    
        // Kiểm tra nếu dữ liệu không trống
        if (!BillId || !CustomerName || !CustomerId || !phone || !address || !status) {
            alert("Some required fields are missing!");
            return; // Dừng lại nếu thiếu dữ liệu quan trọng
        }
    
        // Hiển thị modal
        $("#model_detail_confirm_bill").css('display', 'flex');
        
        // Điền dữ liệu vào các trường trong modal
        $("#idHoaDon_xn").text(BillId);
        $("#ten_xn").text(CustomerName);
        $("#sdt_xn").text(phone);
        $("#diachi_xn").text(address);
        $("#trangthai_xn").text(status);
    });
    
    // Xác nhận hóa đơn
    $("#confirm_bill").click(function (e) { 
        e.preventDefault();
        
        const idHoaDon = $("#idHoaDon_xn").text();
        
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/employee/confirm_bill.php",
            data: {
                action: 'confirm',
                idHoaDon: idHoaDon
            },
            success: function (response) {
                alert("Đã xác nhận đơn hàng!");
                console.log(response);
                location.reload();

                // Đóng modal
                $("#model_detail_confirm_bill").css('display', 'none');
            }
        });
    });

    // Hủy hóa đơn
    $("#cancel_bill").click(function (e) { 
        e.preventDefault();
        
        const idHoaDon = $("#idHoaDon_xn").text();

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/employee/confirm_bill.php",
            data: {
                action: 'cancel',
                idHoaDon: idHoaDon
            },
            success: function (response) {
                console.log(response);
                alert("Đã hủy đơn hàng!");
                location.reload();

                // Đóng modal
                $("#model_detail_confirm_bill").css('display', 'none');
            }
        });
    });
});
