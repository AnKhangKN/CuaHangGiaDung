$(document).ready(function () {
  $(".button").click(function (e) {
    e.preventDefault(); // Ngăn chặn hành động mặc định của nút

    // Lấy giá trị email và password, loại bỏ khoảng trắng
    var $email = $(".email").val().trim();
    var $password = $(".password").val().trim();

    // Kiểm tra xem email và password có trống không
    if ($email === "") {
      $(".errorPassword").html("");
      $(".errorEmail").html("*Hãy nhập email.");
      return; // Dừng thực hiện nếu email trống
    }

    if ($password === "") {
      $(".errorEmail").html("");
      $(".errorPassword").html("*Hãy nhập mật khẩu.");
      return; // Dừng thực hiện nếu mật khẩu trống
    }

    // Gửi yêu cầu AJAX
    $.ajax({
      url: "/CuaHangGiaDung/app/controllers/others/controllerLogin.php",
      type: "POST",
      dataType: "json",
      data: {
        email: $email,
        password: $password,
      },
    })
      .done(function (response) {
        if (response.success) {
          // Hiển thị thông báo thành công
          $(".result").html(
            '<span style="color: green;">Đăng nhập thành công!</span>'
          );

          $(".btn_login").addClass("loading-circle");

          setTimeout(() => {
            $(".btn_login").removeClass("loading-circle");

            window.location.href = response.redirect;
          }, 500);
        } else {
          // Hiển thị thông báo lỗi
          $(".result").html(response.message);
        }
      })

      .fail(function (jqXHR, textStatus, errorThrown) {
        console.error("AJAX error: ", textStatus, errorThrown);
        $(".result").html("*Có lỗi xảy ra. Vui lòng thử lại.");
      });
  });
});

document.querySelectorAll(".input_group input").forEach((input) => {
  input.addEventListener("input", function () {
    const label = this.nextElementSibling;
    if (this.value) {
      label.style.top = "-5px";
      label.style.fontSize = "11px";
      label.style.color = "#333";
    } else {
      label.style.top = "16px";
      label.style.fontSize = "13px";
      label.style.color = "#999";
    }
  });
});
