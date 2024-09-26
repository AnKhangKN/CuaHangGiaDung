function checkSignup() {
    var email = document.getElementById('input_email');
    var password = document.getElementById('input_password');
    var emailError = document.getElementById('email_error');
    var passwordError = document.getElementById('password_error');

    emailError.textContent = ""
    passwordError.textContent = ""

    if(email.value == ""){

        emailError.textContent = "Hãy nhập email"
        
        return false
    }
    if (password.value == ""){
        passwordError.textContent = "Hãy nhập mật khẩu"

        return false
    }    
    emailError.textContent = ""
    passwordError.textContent = ""

    return true
}

// Gán sự kiện blur cho các trường nhập liệu
document.getElementById('input_email').addEventListener('blur', checkSignup);
document.getElementById('input_password').addEventListener('blur', checkSignup);