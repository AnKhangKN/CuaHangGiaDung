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
                setTimeout(() => {
                    // Chuyển hướng trang sau 500ms
                    window.location.href = "http://localhost/CuaHangDungCu/public/login.php"; 
                }, 500);
                
                console.log(response);
            }
            
        });
    });
});
