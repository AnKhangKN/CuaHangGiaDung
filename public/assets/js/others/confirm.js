$(document).ready(function () {
    
    $("#Confirm").click(function (e) { 
        e.preventDefault();
        
        const container = $(this).closest('.main');

        const code = container.find('#code').val();


        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/vendor/confirmmail.php",
            data: {
                code: code,
            },
            success: function (response) {
                if(response === 'Xác thực thành công. Bạn đã được đăng ký tài khoản!'){
                    setTimeout(function(){
                        window.location.href = "http://localhost/CuaHangDungCu/public/login.php";
                    },500)
                }else{
                    alert(response);
                }
            },error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            }
            
        });
    });
});
