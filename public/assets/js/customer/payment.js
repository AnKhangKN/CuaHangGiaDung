$(document).ready(function () {
  function checkInfo() {
    // Lấy giá trị và loại bỏ khoảng trắng thừa
    const name = $("#name").val().trim();
    const email = $("#email").val().trim();
    const phone = $("#phone").val().trim();
    const address = $("#address").val().trim();
    const code = $("#code").val().trim();

    // Lấy các phần tử hiển thị lỗi
    const errorName = $(".error_name");
    const errorEmail = $(".error_email");
    const errorPhone = $(".error_phone");
    const errorAddress = $(".error_address");
    const errorCode = $(".error_code");

    // Xóa thông báo lỗi cũ mỗi lần kiểm tra
    errorName.text("");
    errorEmail.text("");
    errorPhone.text("");
    errorAddress.text("");
    errorCode.text("");

    // Biến xác định tính hợp lệ của form
    let isValid = true;

    // Kiểm tra các trường thông tin bắt buộc
    if (name == "") {
      $("#name").css("border-color", "red");
      errorName.text("Hãy nhập họ và tên!");
      isValid = false;
    } else {
      $("#name").css("border-color", "");
    }

    if (email == "") {
      $("#email").css("border-color", "red");
      errorEmail.text("Hãy nhập email của bạn!");
      isValid = false;
    } else {
      $("#email").css("border-color", "");
    }

    if (phone == "") {
      $("#phone").css("border-color", "red");
      errorPhone.text("Hãy nhập số điện thoại của bạn!");
      isValid = false;
    } else {
      $("#phone").css("border-color", "");
    }

    if (address == "") {
      $("#address").css("border-color", "red");
      errorAddress.text("Hãy nhập địa chỉ của bạn!");
      isValid = false;
    } else {
      $("#address").css("border-color", "");
    }

    if (code == "") {
      $("#code").css("border-color", "red");
      errorCode.text("Hãy nhập mail để nhận code!");
      isValid = false;
    } else {
      $("#code").css("border-color", "");
    }

    // Kiểm tra phương thức thanh toán sau khi tất cả các trường đã hợp lệ
    if (isValid) {
      const cod = $("#payment_by_cod");
      const card = $("#payment_by_card");
      if (!cod.is(":checked") && !card.is(":checked")) {
        // Nếu phương thức thanh toán chưa được chọn, hiển thị modal lỗi
        $("#modalErrorMessage").text("Bạn hãy chọn phương thức thanh toán!");
        $("#errorModal").modal("show"); // Hiển thị modal
        return false; // Ngừng quá trình kiểm tra form
      }
    }

    // Nếu tất cả kiểm tra đều hợp lệ
    return isValid;
  }

  function checkInfoHaveAcc() {
    // Lấy giá trị và loại bỏ khoảng trắng thừa
    const name = $("#name").val().trim();
    const email = $("#email").val().trim();
    const phone = $("#phone").val().trim();
    const address = $("#address").val().trim();

    // Lấy các phần tử hiển thị lỗi
    const errorName = $(".error_name");
    const errorEmail = $(".error_email");
    const errorPhone = $(".error_phone");
    const errorAddress = $(".error_address");

    // Xóa thông báo lỗi cũ mỗi lần kiểm tra
    errorName.text("");
    errorEmail.text("");
    errorPhone.text("");
    errorAddress.text("");

    // Biến xác định tính hợp lệ của form
    let isValid = true;

    // Kiểm tra các trường thông tin bắt buộc
    if (name == "") {
      $("#name").css("border-color", "red");
      errorName.text("Hãy nhập họ và tên!");
      isValid = false;
    } else {
      $("#name").css("border-color", "");
    }

    if (email == "") {
      $("#email").css("border-color", "red");
      errorEmail.text("Hãy nhập email của bạn!");
      isValid = false;
    } else {
      $("#email").css("border-color", "");
    }

    if (phone == "") {
      $("#phone").css("border-color", "red");
      errorPhone.text("Hãy nhập số điện thoại của bạn!");
      isValid = false;
    } else {
      $("#phone").css("border-color", "");
    }

    if (address == "") {
      $("#address").css("border-color", "red");
      errorAddress.text("Hãy nhập địa chỉ của bạn!");
      isValid = false;
    } else {
      $("#address").css("border-color", "");
    }

    // Kiểm tra phương thức thanh toán sau khi tất cả các trường đã hợp lệ
    if (isValid) {
      const cod = $("#payment_by_cod");
      const card = $("#payment_by_card");
      if (!cod.is(":checked") && !card.is(":checked")) {
        // Nếu phương thức thanh toán chưa được chọn, hiển thị modal lỗi
        $("#modalErrorMessage").text("Bạn hãy chọn phương thức thanh toán!");
        $("#errorModal").modal("show"); // Hiển thị modal
        return false; // Ngừng quá trình kiểm tra form
      }
    }

    // Nếu tất cả kiểm tra đều hợp lệ
    return isValid;
  }

  let allPrice = 0; // Khởi tạo bên ngoài vòng lặp

  $(".list_infor_products_payment_item").each(function () {
    let lstItem = $(this);

    // Lấy số lượng sản phẩm từ span#soluong_item
    let amountProduct =
      parseInt(lstItem.find("#soluong_item").text().trim()) || 0;

    // Lấy giá sản phẩm từ span#price_item và làm sạch chuỗi
    let priceItemText = lstItem.find("#price_item").text().trim();
    let cleanPrice =
      parseFloat(priceItemText.replace(/\./g, "").replace(",", ".")) || 0;

    // Tính tổng giá cho sản phẩm hiện tại
    let totalPrice = amountProduct * cleanPrice;

    // Cộng dồn vào allPrice
    allPrice += totalPrice;
  });

  // Hiển thị tổng giá của tất cả sản phẩm vào phần tử #expense_item_price
  $("#expense_item_price").text(allPrice.toLocaleString("vi-VN"));

  // Tiền gồm vận chuyển
  const express = $("#expense_item_express").text();
  let cleanPrice =
    parseFloat(express.replace(/\./g, "").replace(",", ".")) || 0;

  $(".total_bill_due_price").text(
    (cleanPrice + allPrice).toLocaleString("vi-VN")
  );

  // Xử lý sự kiện khi checkbox thay đổi
  $('.infor_payment_method_content_choose input[type="checkbox"]').change(
    function () {
      const payContainer = $(this).closest(
        ".infor_payment_method_content_choose"
      );
      const infoPayment = payContainer.find(".content_transfer");

      // Bỏ chọn các checkbox khác và ẩn nội dung liên quan
      $('.infor_payment_method_content_choose input[type="checkbox"]')
        .not(this)
        .prop("checked", false);
      $(".content_transfer").hide();

      // Hiển thị nội dung liên quan nếu checkbox được chọn
      if ($(this).is(":checked") && infoPayment.length) {
        infoPayment.show();
      }
    }
  );

  $(".list_infor_products_payment_item").each(function () {
    const listProduct = $(this);
    const size = listProduct.find("#size_product").text().trim();
    const color = listProduct.find("#color_product").text().trim();
    const productId = listProduct.find("#idSanPham_item").text().trim();

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/ProductAmount_cart.php",
      data: {
        size: size,
        color: color,
        productId: productId,
      },
      success: function (response) {
        if (response.includes("|")) {
          const [amount, id] = response.split("|");
          listProduct.find("#idChiTietSanPham").html(id);
          listProduct.find("#SoLuongConLai").html(amount);
        } else {
          console.log("Hãy chung cấp đủ thông tin!");
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        rowProduct.find("#ProductAmount").html("Có lỗi xảy ra");
      },
    });
  });

  // xử lý thanh toán------------------------------------------------------------

  // Kiểm tra id khách hàng
  function handleExistingCustomer(idKhachHang) {
    const container_payment = $("#container_payment_info");

    const tenkhachhang = container_payment.find("#name").val();
    const sodienthoai = container_payment.find("#phone").val();
    const diachi = container_payment.find("#address").val();
    const tongtien = container_payment.find(".total_bill_due_price").text();

    let method = $(".payment_method_chBox:checked").val();

    const cleanTotalPrice =
      parseFloat(tongtien.replace(/\./g, "").replace(",", ".")) || 0;
    const ghichu = container_payment.find("#exampleFormControlTextarea1").val();

    if (tenkhachhang === "Hãy thêm tên của bạn" || tenkhachhang === "") {
      alert("Hãy kiểm tra lại tên của bạn");
      return;
    }

    if (sodienthoai === "0" || sodienthoai === "") {
      alert("Hãy nhập đúng số điện thoại của bạn!");
      return;
    }

    if (!/^\d{10}$/.test(sodienthoai)) {
      alert("Số điện thoại phải là 10 chữ số!");
      return;
    }

    if (diachi === "Chưa nhập địa chỉ" || diachi === "") {
      alert("Hãy nhập đúng địa chỉ để giao hàng!");
      return;
    }

    let products = [];
    $(".list_infor_products_payment_item").each(function () {
      const lstProduct = $(this);
      const soluong = lstProduct.find("#soluong_item").text();
      const idChiTietSanPham = lstProduct.find("#idChiTietSanPham").text();
      const soluongconlai = lstProduct.find("#SoLuongConLai").text();

      products.push({ soluong, idChiTietSanPham, soluongconlai });
    });

    console.log(method);

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/add_bill_customer.php",
      data: {
        action: "CustomerId",
        tenkhachhang: tenkhachhang,
        sodienthoai: sodienthoai,
        diachi: diachi,
        tongtien: cleanTotalPrice,
        method: method,
        ghichu: ghichu,
        idKhachHang: idKhachHang,
        products: JSON.stringify(products),
      },
      beforeSend: function () {
        $(".loader").addClass("loading-circle");
      },
      success: function (response) {
        const data = JSON.parse(response);
        if (data.status === "success") {
          $(".loader").removeClass("loading-circle");
          const modal = $(".confirm_payment")[0]; // Truy cập phần tử DOM thực sự
          if (modal) {
            modal.style.display = "flex";
          } else {
            console.log("Modal không được tìm thấy");
          }
        } else {
          alert("Lỗi: " + data.message);
        }
      },
      error: function () {
        alert("Có lỗi xảy ra trong quá trình gửi dữ liệu!");
      },
    });
  }

  // tiến hành xử lý
  $(".infor_payment_btn_continue").click(function (e) {
    e.preventDefault();

    if (checkInfoHaveAcc()) {
      // Kiểm tra trạng thái khách hàng qua session
      $.ajax({
        type: "POST",
        url: "/CuaHangGiaDung/app/controllers/customer/check_customer_status.php",
        dataType: "json",
        success: function (response) {
          if (response.status === "logged_in") {
            // Khách hàng đã đăng nhập
            handleExistingCustomer(response.idKhachHang);
          } else {
            alert("Không thể xác định trạng thái khách hàng.");
            console.log(response.status);
          }
        },
        error: function () {
          alert("Lỗi khi kiểm tra trạng thái khách hàng.");
        },
      });
    } else {
      console.log("Thông tin không hợp lệ, kiểm tra lại!");
    }
  });
  // khách hàng mới -------------------------------------------------------------

  $("#btn_code").click(function (e) {
    e.preventDefault();

    const container_payment = $(this).closest("#container_payment_info");
    const emailField = container_payment.find("#email");
    const email = emailField.val();
    const errorEmail = container_payment.find(".error_email");

    if (!email) {
      emailField.css("border-color", "red");
      errorEmail.text("Hãy nhập email của bạn!").show();
      return;
    } else if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
      emailField.css("border-color", "red");
      errorEmail.text("Email không hợp lệ!").show();
      return;
    } else {
      emailField.css("border-color", "");
      errorEmail.text("").hide();
    }

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/get_code_confirm.php",
      data: { email: email },
      beforeSend: function () {
        // Hiển thị hiệu ứng tải trước khi gửi
        $(".sent_code").addClass("key_frame_spin");
      },
      success: function (response) {
        if (response === "Đã xảy ra lỗi: Email đã tồn tại trong hệ thống.") {
          $(".sent_code").removeClass("key_frame_spin");
          $("#modalErrorMessage").text("Email đã tồn tại!");
          $("#errorModal").modal("show");
        }
        $(".sent_code").removeClass("key_frame_spin"); // Corrected selector syntax
      },
      error: function (xhr, status, error) {
        console.error("An error occurred: " + error);
        $(".sent_code").removeClass("key_frame_spin"); // Corrected selector syntax
      },
    });
  });

  // kiểm tra khách hàng mới
  function handleGuestCustomer() {
    const container_payment = $("#container_payment_info");

    const tongtien = container_payment.find(".total_bill_due_price").text();

    let method = $(".payment_method_chBox:checked").val();

    const cleanTotalPrice =
      parseFloat(tongtien.replace(/\./g, "").replace(",", ".")) || 0;
    const ghichu = container_payment.find("#exampleFormControlTextarea1").val();

    const code = container_payment.find("#code").val();
    const email = container_payment.find("#email").val();
    const tenkhachhang = container_payment.find("#name").val();
    const sdt = container_payment.find("#phone").val();
    const diachi = container_payment.find("#address").val();

    let products = [];
    $(".list_infor_products_payment_item").each(function () {
      const lstProduct = $(this);
      const soluong = lstProduct.find("#soluong_item").text();
      const idChiTietSanPham = lstProduct.find("#idChiTietSanPham").text();
      const soluongconlai = lstProduct.find("#SoLuongConLai").text();

      products.push({ soluong, idChiTietSanPham, soluongconlai });
    });

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/customer/add_bill_guest.php",
      data: {
        action: "NoCustomerId",
        code: code,
        email: email,
        tenkhachhang: tenkhachhang,
        sdt: sdt,
        diachi: diachi,
        tongtien: cleanTotalPrice,
        method: method,
        ghichu: ghichu,
        products: JSON.stringify(products),
      },
      beforeSend: function () {
        // Hiển thị hiệu ứng tải trước khi gửi
        $(".loader").addClass("loading-circle");
      },
      success: function (response) {
        $(".loader").removeClass("loading-circle");
        const data = JSON.parse(response);
        if (data.status === "success") {
          const modal = $(".confirm_payment")[0]; // Truy cập phần tử DOM thực sự
          if (modal) {
            modal.style.display = "flex";
          } else {
            console.log("Modal không được tìm thấy");
          }
        } else {
          alert("Lỗi: " + data.message);
        }
      },
      error: function () {
        $("#modalErrorMessage").text(
          "Có lỗi xảy ra trong quá trình gửi dữ liệu!"
        );
        $("#errorModal").modal("show");
      },
    });
  }

  // khách hàng không có tài khoản
  $("#btn_confirm_account").click(function (e) {
    e.preventDefault();

    if (checkInfo()) {
      // Kiểm tra trạng thái khách hàng qua session
      $.ajax({
        type: "POST",
        url: "/CuaHangGiaDung/app/controllers/customer/check_customer_status.php",
        dataType: "json",
        success: function (response) {
          if (response.status === "guest") {
            // Khách hàng mới
            handleGuestCustomer();
          } else {
            $("#modalErrorMessage").text(
              "Không thể xác định trạng thái khách hàng."
            );
            $("#errorModal").modal("show");
            console.log(response.status);
          }
        },
        error: function () {
          alert("Lỗi khi kiểm tra trạng thái khách hàng.");
        },
      });
    } else {
      console.log("Thông tin không hợp lệ, kiểm tra lại!");
    }
  });

  $("#close_success").click(function (e) {
    e.preventDefault();

    const modal = $(".confirm_payment")[0]; // Truy cập phần tử DOM thực sự
    if (modal) {
      modal.style.display = "none";
      window.location.href = "/CuaHangGiaDung/public/index.php?page=products";
    } else {
      console.log("Modal không được tìm thấy");
    }
  });

  $("#check_bill").click(function (e) {
    e.preventDefault(); // Ngăn hành động mặc định của sự kiện

    const modal = $(".confirm_payment")[0];

    if (modal) {
      modal.style.display = "none"; // Ẩn modal
      window.location.href =
        "/CuaHangGiaDung/public/index.php?page=information";
    } else {
      console.error("Modal không được tìm thấy");
    }
  });
});
