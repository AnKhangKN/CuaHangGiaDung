$(document).ready(function () {
  const allRowProduct = $(".cell_product");
  const close = $("#close");
  const ChiTietSanPham = $("#modal_product_detail");

  // Đóng modal
  close.click(function (e) {
    e.preventDefault();
    ChiTietSanPham.css({ display: "none" });
    $("#late_amount").html(0);
    $("#idchitietsanpham").html(0);
  });

  // Mở modal khi click vào sản phẩm
  allRowProduct.on("click", function () {
    ChiTietSanPham.css({ display: "flex" });

    const idSanPham = $(this).find(".idSanPham").text();
    const tenSanPham = $(this).find(".tenSanPham").text();
    const giaSanPham = $(this).find(".giaSanPham").text();
    const imgSanPham = $(this).find(".imgSanPham").attr("src");

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/employee/add_product_detail.php",
      data: {
        action: "InfoSanPham",
        idSanPham,
        tenSanPham,
        imgSanPham,
        giaSanPham,
      },
      success: function (response) {
        try {
          const data = JSON.parse(response);
          if (data.status === "success") {
            $("#idSanPham").text(data.idSanPham);
            $("#ProductName").text(data.tenSanPham);
            $("#ProductPrice").text(data.giaSanPham);
            $("#imgProduct").attr("src", data.imgSanPham);
          } else {
            console.error("Không thể lấy thông tin sản phẩm:", data.message);
          }
        } catch (error) {
          console.error("Lỗi khi xử lý JSON:", error);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
      },
    });
  });

  // Chọn size hoặc màu
  $(document).on("change", ".size_input, .color_input", function (e) {
    e.preventDefault();

    const container = $(this).closest("#modal_product_detail");

    if ($(this).hasClass("size_input")) {
      container.find(".size_input").not(this).prop("checked", false);
    }
    if ($(this).hasClass("color_input")) {
      container.find(".color_input").not(this).prop("checked", false);
    }

    let size =
      container.find(".size_input:checked").val() || "Không có kích thước";
    let color = container.find(".color_input:checked").val();
    let productId = container.find("#idSanPham").text();

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/employee/get_product_detail.php",
      data: {
        action: "select",
        size,
        color,
        productId,
      },
      success: function (response) {
        if (response.includes("|")) {
          const [amount, id] = response.split("|");
          $("#late_amount").html(amount);
          $("#idchitietsanpham").html(id);
        }
      },
      error: function () {
        $("#late_amount").html("Có lỗi xảy ra");
      },
    });
  });

  // Tăng sản phẩm
  $(document).on("click", "#up_product", function (e) {
    e.preventDefault();
    const container = $(this).closest("#modal_product_detail");
    const max = parseInt(container.find("#late_amount").text()) || 0;
    let current = parseInt(container.find("#amount_product").val()) || 0;

    container.find("#amount_product").val(Math.min(current + 1, max));
  });

  // Giảm sản phẩm
  $(document).on("click", "#down_product", function (e) {
    e.preventDefault();
    const container = $(this).closest("#modal_product_detail");
    let current = parseInt(container.find("#amount_product").val()) || 0;
    if (current > 0) {
      container.find("#amount_product").val(current - 1);
    }
  });

  // Thay đổi số lượng thủ công
  $(document).on("change", "#amount_product", function () {
    const container = $(this).closest("#modal_product_detail");
    const max = parseInt(container.find("#late_amount").text()) || 0;
    let val = parseInt($(this).val()) || 0;

    $(this).val(Math.min(val, max));
  });

  // Thêm vào giỏ hàng
  $(document).on("click", "#add", function (e) {
    e.preventDefault();
    const container = $(this).closest("#modal_product_detail");

    const idSanPham = container.find("#idSanPham").text();
    const tenSanPham = container.find("#ProductName").text();
    const soluong = container.find("#amount_product").val();
    const dongia = container.find("#ProductPrice").text();
    const idChiTietSanPham = container.find("#idchitietsanpham").text();
    const mau = container.find(".color_input:checked").val();
    const kichthuoc =
      container.find(".size_input:checked").val() || "Không có kích thước";

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/employee/add_to_cart.php",
      data: {
        action: "add_cart",
        idSanPham,
        tenSanPham,
        soluong,
        dongia,
        idChiTietSanPham,
        mau,
        kichthuoc,
      },
      success: function (response) {
        console.log(response);
        container.css("display", "none");
        location.reload();
      },
    });
  });

  // Xóa sản phẩm khỏi giỏ
  $(document).on("click", ".remove_cart", function () {
    const cartItem = $(this).closest(".SanPham_buy");

    const idSanPham = cartItem.find(".idSanPham_buy").text();
    const idChiTietSanPham = cartItem.find(".idChiTietSanPham_buy").text();
    const tenSanPham = cartItem.find(".tenSanPham_buy").text();
    const mau = cartItem.find(".mau_buy").text();
    const kichthuoc = cartItem.find(".kichthuoc_buy").text();

    $.ajax({
      type: "POST",
      url: "/CuaHangGiaDung/app/controllers/employee/delete_item_cart.php",
      data: {
        action: "remove_cart",
        idSanPham,
        idChiTietSanPham,
        tenSanPham,
        mau,
        kichthuoc,
      },
      success: function (response) {
        cartItem.remove();
        console.log(response);
      },
      error: function () {
        alert("Lỗi khi xóa sản phẩm.");
      },
    });
  });
});
