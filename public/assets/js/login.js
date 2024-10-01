$(document).ready(function() {
    $('#btn_continue').click(function(e) {
        e.preventDefault(); // Ngăn chặn submit form truyền thống

        // Thực hiện kiểm tra trước khi gửi form
        if (checkSignup()) {
            var email = $('#input_email').val();
            var password = $('#input_password').val();

            // Gửi dữ liệu qua Ajax
            $.ajax({
                url: 'http://localhost/CuaHangDungCu/app/controllers/controllerLogin.php', // Đường dẫn đến file PHP xử lý
                type: 'post',
                dataType: 'html', // Kiểu dữ liệu trả về
                data: {
                    email: email,
                    password: password 
                }
            }).done(function(result) {
                // Hiển thị kết quả trả về từ server trong .result
                $('.result').html(result);
            }).fail(function() {
                // Xử lý nếu có lỗi khi gửi yêu cầu
                $('.result').html('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        }
    });

    // Hàm kiểm tra input
    function checkSignup() {
        var email = document.getElementById('input_email');
        var password = document.getElementById('input_password');
        var emailError = document.getElementById('email_error');
        var passwordError = document.getElementById('password_error');

        emailError.textContent = "";
        passwordError.textContent = "";

        // Kiểm tra nếu email trống
        if (email.value == "") {
            emailError.textContent = "Hãy nhập email";
            return false;
        }

        // Kiểm tra định dạng email
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailPattern.test(email.value)) {
            emailError.textContent = "Email không hợp lệ";
            return false;
        }

        // Kiểm tra nếu mật khẩu trống
        if (password.value == "") {
            passwordError.textContent = "Hãy nhập mật khẩu";
            return false;
        }

        // Nếu tất cả hợp lệ
        emailError.textContent = "";
        passwordError.textContent = "";
        return true;
    }
});
