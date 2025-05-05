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

$(document).ready(function () {
  $("#getCode").click(function (e) {
    e.preventDefault();

    const container = $(".main");

    const inputEmail = container.find("#input_email").val();

    if (inputEmail) {
      $.ajax({
        type: "POST",
        url: "/CuaHangGiaDung/app/controllers/customer/forgot_sendEmail.php",
        data: {
          inputEmail: inputEmail,
        },
        beforeSend: function () {
          // Hiển thị hiệu ứng tải trước khi gửi
          $(".btn_code").addClass("loading-circle");
        },
        success: function (response) {
          try {
            const data = JSON.parse(response);

            if (data.status === "error") {
              alert(data.message);
            } else if (data.status === "success") {
              alert(data.message);
            } else {
              console.error("Unknown response:", data);
            }

            $(".btn_code").removeClass("loading-circle");
          } catch (error) {
            console.error("Invalid JSON response:", response);
            alert("Đã xảy ra lỗi. Vui lòng thử lại sau!");
          }
        },
      });
    }
  });

  $("#btn_changePass").click(function (e) {
    e.preventDefault();

    const container = $(".main");

    const email = container.find("#input_email").val();
    const code = container.find("#input_code").val();
    const newPass = container.find("#input_password").val();

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/forgot_changePassword.php",
      data: {
        action: "forgotPass",
        email: email,
        code: code,
        newPass: newPass,
      },
      beforeSend: function () {
        // Hiển thị hiệu ứng tải trước khi gửi
        $(".btn_login").addClass("loading-circle");
      },
      success: function (response) {
        // Hiển thị thông báo
        alert(response);

        // Loại bỏ hiệu ứng tải trước khi chuyển hướng
        $(".btn_login").removeClass("loading-circle");

        // Chuyển hướng sau khi xử lý xong
        window.location.href = "/CuaHangGiaDung/public/login.php";
      },
      error: function (xhr, status, error) {
        console.error("Có lỗi xảy ra: ", error);

        // Loại bỏ hiệu ứng tải nếu xảy ra lỗi
        $(".btn_login").removeClass("loading-circle");
      },
    });
  });
});
