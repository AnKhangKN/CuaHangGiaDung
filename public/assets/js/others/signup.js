document.querySelectorAll('.input_group input').forEach(input => {
    input.addEventListener('input', function() {
        const label = this.nextElementSibling;
        if (this.value) {
            label.style.top = '-5px';
            label.style.fontSize = '11px';
            label.style.color = '#333';
        } else {
            label.style.top = '16px';
            label.style.fontSize = '13px';
            label.style.color = '#999';
        }
    });
});

$(document).ready(function () {
    $("#confirm_acc").click(function (e) {
        e.preventDefault();

        const container = $(this).closest('.main');
        const email = container.find('#email').val();
        const pass = container.find('#password').val();

        // Kiểm tra email và mật khẩu trước khi gửi
        if (!email || !pass) {
            alert("Vui lòng nhập đầy đủ email và mật khẩu!");
            return;
        }

        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/vendor/sendmail.php",
            data: {
                email: email,
                pass: pass
            },
            beforeSend: function () {
                // Hiển thị hiệu ứng tải trước khi gửi
                $(".load_signup").addClass("loading-circle");
            },
            success: function (response) {
                if (response.includes("Email đã tồn tại, hãy đổi sang email khác")) {
                    alert("Email đã tồn tại, vui lòng chọn email khác!");
                } else if (response.includes("Email không hợp lệ!")) {
                    alert("Email bạn nhập không hợp lệ!");
                } else {
                    // Nếu không có lỗi, chuyển hướng trang
                    setTimeout(() => {
                        $(".load_signup").removeClass("loading-circle");
                        window.location.href = "http://localhost/CuaHangDungCu/public/confirm.php";
                    }, 0);
                }
                console.log(response); // Ghi phản hồi vào console để kiểm tra
            },
            error: function (xhr, status, error) {
                alert("Có lỗi xảy ra khi gửi yêu cầu.");
                console.error(error); // Ghi lỗi vào console
            },
            complete: function () {
                // Loại bỏ hiệu ứng tải bất kể thành công hay lỗi
                $(".load_signup").removeClass("loading-circle");
            }
        });
    });
});
