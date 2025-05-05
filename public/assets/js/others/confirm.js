$(document).ready(function () {
  $("#Confirm").click(function (e) {
    e.preventDefault();

    const container = $(this).closest(".main");

    const code = container.find("#code").val();

<<<<<<< HEAD
    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/vendor/confirmmail.php",
      data: {
        code: code,
      },
      success: function (response) {
        if (
          response === "Xác thực thành công. Bạn đã được đăng ký tài khoản!"
        ) {
          setTimeout(function () {
            window.location.href =
              "/CuaHangGiaDung/public/login.php";
          }, 500);
        } else {
          alert(response);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: ", status, error);
        alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
      },
=======
        $.ajax({
            type: "POST",
            url: "/CuaHangGiaDung/vendor/confirmmail.php",
            data: {
                code: code,
            },
            success: function (response) {
                if(response === 'Xác thực thành công. Bạn đã được đăng ký tài khoản!'){
                    setTimeout(function(){
                        window.location.href = "/CuaHangGiaDung/public/login.php";
                    },500)
                }else{
                    alert(response);
                }
            },error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alert("Có lỗi xảy ra. Vui lòng thử lại sau.");
            }
            
        });
>>>>>>> b2f6cfd84423ea88131c163e446690d8d38d2e96
    });
  });
});
