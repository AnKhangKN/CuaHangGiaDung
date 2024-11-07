$(document).ready(function() {
    $('.button').click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút

        // Lấy giá trị email và password, loại bỏ khoảng trắng
        var $email = $('.email').val().trim();
        var $password = $('.password').val().trim();

        // Kiểm tra xem email và password có trống không
        if ($email === "") {
            $('.errorPassword').html('');
            $('.errorEmail').html('*Hãy nhập email.');
            return; // Dừng thực hiện nếu email trống
        }
        
        if ($password === "") {
            $('.errorEmail').html('');
            $('.errorPassword').html('*Hãy nhập mật khẩu.');
            return; // Dừng thực hiện nếu mật khẩu trống
        }

        

        // Gửi yêu cầu AJAX
        $.ajax({
            url: '/CuaHangDungCu/app/controllers/others/controllerLogin.php',
            type: 'POST',
            dataType: 'json', // Đảm bảo phản hồi là JSON
            data: {
                email: $email,
                password: $password
            }
        })
        .done(function(response) {
            if (response.success) {
                // Chuyển hướng nếu đăng nhập thành công
                window.location.href = response.redirect; // Sử dụng đường dẫn từ phản hồi
            } else {
                // Hiển thị thông báo lỗi
                $('.result').html(response.message);
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error: ", textStatus, errorThrown);
            $('.result').html('*Có lỗi xảy ra. Vui lòng thử lại.');
        });
    });
});


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
