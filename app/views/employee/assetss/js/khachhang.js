$(document).ready(function () {
    $("#add_Customer_New").click(function (e) { 
        e.preventDefault();
    
        const container = $(".container_right");
        const ten = container.find("#name").val().trim();
        const sdt = container.find("#phone").val().trim();
        const diachi = container.find("#address").val().trim();
        const email = container.find("#email").val().trim();
    
        // Kiểm tra dữ liệu đầu vào
        if (!ten || !sdt || !diachi || !email) {
            alert("Vui lòng nhập đầy đủ thông tin.");
            return;
        }
    
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert("Vui lòng nhập email hợp lệ.");
            return;
        }
    
        // Gửi yêu cầu AJAX
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/employee/add_new_customer.php",
            data: {
                action: "add_customer",
                ten: ten,
                sdt: sdt,
                diachi: diachi,
                email: email
            },
            before: function () {
                $("#add_Customer_New").text("...");
            },
            success: function (response) {
                try {
                    const data = JSON.parse(response);
    
                    if (data.status === "success") {
                        alert(data.message);
                    } 
                } catch (error) {
                    alert("Phản hồi không hợp lệ từ server.");
                    console.error("Response parse error: ", error);
                }
            },
            error: function (xhr, status, error) {
                console.error("Lỗi: ", error);
                alert("Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại.");
            }
        });
    });
    
});