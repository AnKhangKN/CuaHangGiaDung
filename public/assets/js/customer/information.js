// Hàm để hiển thị nội dung và thêm class highlight
function showContent(sectionId, element) {
  // Ẩn tất cả các phần nội dung
  var sections = document.getElementsByClassName("content-section");
  for (var i = 0; i < sections.length; i++) {
    sections[i].style.display = "none";
  }

  // Hiển thị phần nội dung được chọn
  document.getElementById(sectionId).style.display = "block";

  // Xóa class highlight khỏi tất cả các mục trong sidebar
  var items = document.getElementsByClassName("view_infor");
  for (var i = 0; i < items.length; i++) {
    items[i].classList.remove("highlight");
  }

  // Thêm class highlight vào mục được nhấp
  element.classList.add("highlight");
}

// Hiển thị mặc định phần "overview" và thêm highlight vào mục đầu tiên
document.addEventListener("DOMContentLoaded", function () {
  showContent("overview", document.querySelector(".sidebar_list li"));
});

// --------------------------------------------------------------------

function showHistory(btn_history, show_history) {
  const btn = document.getElementById(btn_history);
  const show = document.getElementById(show_history);

  btn.addEventListener("click", () => {
    show.style.display = show.style.display === "none" ? "block" : "none";
  });
}

showHistory("purchase_history_btn", "purchase_history_show_hidden");

// ----------------------------------------------------------------------
// Hàm hiển thị modal
function showChangeInfo(btnId, modalId) {
  const btn = document.getElementById(btnId); // Nút bấm chỉnh sửa
  const modal = document.getElementById(modalId); // Modal cần hiển thị
  const modalBackground = document.querySelector(".modal_change"); // Nền chứa modal

  if (btn && modal && modalBackground) {
    // Hiển thị modal khi nhấn nút
    btn.addEventListener("click", () => {
      // Ẩn tất cả các modal container trước
      const allModals = modalBackground.querySelectorAll(".modal_container");
      allModals.forEach((m) => (m.style.display = "none"));

      // Hiển thị modal tương ứng
      modalBackground.style.display = "flex"; // Hiển thị nền
      modal.style.display = "block"; // Hiển thị modal đúng
    });

    // Ẩn modal khi nhấn nút "x"
    const closeBtn = modal.querySelector(".modal_header_remove"); // Nút đóng
    if (closeBtn) {
      closeBtn.addEventListener("click", () => {
        modalBackground.style.display = "none"; // Ẩn nền
        modal.style.display = "none"; // Ẩn modal container
      });
    }
  } else {
    console.error("Không tìm thấy button, modal, hoặc nền:", btnId, modalId);
  }
}

// Gọi hàm cho từng nút chỉnh sửa và modal tương ứng
showChangeInfo("clickChangeName", "changeName");
showChangeInfo("clickChangePhone", "changePhone");
showChangeInfo("clickChangeAddress", "changeAddress");
showChangeInfo("clickChangeEmail", "changeEmail");
showChangeInfo("clickChangePass", "changePassword");

// show pass
function showPassWord(btnIcon, showPass) {
  const btn = document.getElementById(btnIcon);
  const show = document.getElementById(showPass);

  if (btn && show) {
    btn.addEventListener("click", () => {
      if (show.type === "password") {
        btn.classList.remove("fa-eye-slash");
        btn.classList.add("fa-eye");
        show.type = "text";
      } else {
        btn.classList.remove("fa-eye");
        btn.classList.add("fa-eye-slash");
        show.type = "password";
      }
    });
  } else {
    console.error("Element not found for IDs:", btnIcon, showPass);
  }
}

showPassWord("showPassLate", "PassLate");
showPassWord("showPassNew", "PassNew");
showPassWord("showPassConfirm", "PassConfirm");

// change info

$(document).ready(function () {
  // Hàm thay đổi thông tin của khách hàng
  function changeInfo(idKhachHang) {
    const container = $(".modal_container.active"); // Chỉ thao tác với modal hiện tại (đã có class active)

    if (container.length === 0) {
      console.error("Không tìm thấy modal_container.");
      return;
    }

    const inputElem = container.find(".change_input");
    if (inputElem.length === 0) {
      console.error("Không tìm thấy input.");
      return;
    }

    const inputValue = inputElem.val();
    const inputName = inputElem.attr("name");

    if (!inputName) {
      console.warn("Không tìm thấy thuộc tính name.");
      return;
    }

    if (inputValue === "") {
      alert("Thay đổi không được trống");
      return;
    }

    // Gửi yêu cầu AJAX để thay đổi thông tin khách hàng
    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/update_info.php",
      data: {
        action: "changeInfo",
        inputValue: inputValue,
        inputName: inputName,
        idKhachHang: idKhachHang,
      },
      beforeSend: function () {
        $(".btnChange").prop("disabled", true).text("Đang xử lý...");
      },
      success: function (response) {
        try {
          const data = JSON.parse(response);
          if (data.success) {
            alert("Cập nhật thông tin thành công!");

            // Lưu trạng thái modal vào localStorage để sau khi tải lại trang có thể mở modal lại
            localStorage.setItem("modalState", "open");

            // Tải lại trang
            location.reload();
          } else {
            alert("Cập nhật thất bại: " + data.message);
          }
        } catch (e) {
          console.error("Phản hồi không hợp lệ:", response);
        }
      },
      error: function (xhr, status, error) {
        console.error("Lỗi:", status, error);
        alert("Đã xảy ra lỗi khi gửi dữ liệu!");
      },
      complete: function () {
        $(".btnChange").prop("disabled", false).text("Lưu lại thay đổi");
      },
    });
  }

  // Khi người dùng click vào nút Lưu thay đổi
  $(".btnChange").click(function (e) {
    e.preventDefault();

    const currentModal = $(this).closest(".modal_container");

    $(".modal_container").removeClass("active");
    currentModal.addClass("active"); // Thêm class 'active' vào modal hiện tại

    // Kiểm tra trạng thái đăng nhập của khách hàng
    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/check_customer_status.php",
      dataType: "json",
      success: function (response) {
        if (response.status === "logged_in") {
          changeInfo(response.idKhachHang);
        } else {
          alert("Không thể xác định trạng thái khách hàng.");
          console.log(response.status);
        }
      },
      error: function () {
        alert("Lỗi khi kiểm tra trạng thái khách hàng.");
      },
    });
  });

  $("#send_code").click(function (e) {
    e.preventDefault();
    const container = $(this).closest("#changeEmail");

    const newEmail = container.find("#new_email").val();

    if (!newEmail) {
      alert("Hãy nhập email để nhận mã xác thực");
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(newEmail)) {
      alert("Định dạng email không hợp lệ. Vui lòng nhập lại!");
      return;
    }

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/updateEmail.php",
      data: {
        action: "sendCode",
        newEmail: newEmail,
      },
      success: function (response) {
        console.log(response);
      },
    });
  });

  function changeEmail(idKhachHang) {
    // Ensure that the container is correctly identified
    const container = $("#changeEmail");

    const newEmail = container.find("#new_email").val();
    const code = container.find("#codeNewEmail").val();

    // Validate inputs
    if (!newEmail || !code) {
      alert("Vui lòng nhập email và mã xác thực.");
      return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(newEmail)) {
      alert("Định dạng email không hợp lệ. Vui lòng nhập lại!");
      return;
    }

    // AJAX request to update email
    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/updateEmail.php",
      data: {
        action: "updateEmail",
        newEmail: newEmail,
        code: code,
        idKhachHang: idKhachHang,
      },
      success: function (response) {
        console.log(response);
        alert(response); // Notify the user about the result
        localStorage.setItem("modalState", "open");

        location.reload();
      },
      error: function () {
        alert("Đã xảy ra lỗi khi cập nhật email.");
      },
    });
  }

  $("#changeEmail_btn").click(function (e) {
    e.preventDefault();

    // Check customer status
    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/check_customer_status.php",
      dataType: "json",
      success: function (response) {
        if (response.status === "logged_in") {
          changeEmail(response.idKhachHang);
        } else {
          alert("Không thể xác định trạng thái khách hàng.");
          console.log(response.status);
        }
      },
      error: function () {
        alert("Lỗi khi kiểm tra trạng thái khách hàng.");
      },
    });
  });

  function changePassword(idKhachHang) {
    const container = $("#changePassword");

    const PassWordLate = container.find("#PassLate").val(); // Lấy giá trị từ input
    const PassWordNew = container.find("#PassNew").val(); // Lấy giá trị từ input
    const PassWordConfirm = container.find("#PassConfirm").val(); // Lấy giá trị từ input

    // Kiểm tra mật khẩu cũ và mới không được giống nhau
    if (PassWordLate === PassWordNew) {
      alert("Mật khẩu mới không được trùng với mật khẩu cũ!");
      return;
    }

    // Kiểm tra mật khẩu mới và mật khẩu xác nhận phải giống nhau
    if (PassWordNew !== PassWordConfirm) {
      alert("Mật khẩu xác nhận không đúng!");
      return;
    }

    if (!PassWordConfirm || !PassWordLate || !PassWordNew) {
      alert("Mật khẩu không được trống");
      return;
    }

    // Gửi yêu cầu AJAX để thay đổi mật khẩu
    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/updatePassword.php",
      data: {
        action: "ChangePassWord",
        idKhachHang: idKhachHang,
        PassWordLate: PassWordLate,
        PassWordNew: PassWordNew,
        PassWordConfirm: PassWordConfirm,
      },
      success: function (response) {
        const data = JSON.parse(response);
        alert(data.message);
        console.log(response);
      },
      error: function (xhr, status, error) {
        console.error("Lỗi:", error);
        alert("Đã có lỗi xảy ra khi thay đổi mật khẩu.");
      },
    });
  }

  $("#changePassword_btn").click(function (e) {
    e.preventDefault();

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/check_customer_status.php",
      dataType: "json",
      success: function (response) {
        if (response.status === "logged_in") {
          changePassword(response.idKhachHang);
        } else {
          alert("Không thể xác định trạng thái khách hàng.");
          console.log(response.status);
        }
      },
      error: function () {
        alert("Lỗi khi kiểm tra trạng thái khách hàng.");
      },
    });
  });
});

$(document).ready(function () {
  // Kiểm tra trạng thái modal sau khi tải lại trang
  if (localStorage.getItem("modalState") === "open") {
    const modal = $("#setting");
    const overviewModal = $("#overview");
    if (modal.length > 0) {
      modal.css("display", "block"); // Đảm bảo modal được hiển thị
      overviewModal.css("display", "none");
      window.location.hash = "#setting"; // Giữ vị trí phần tử modal trong URL

      // Sau khi mở modal, xóa trạng thái modal khỏi localStorage
      localStorage.removeItem("modalState");
    }
  }
});
