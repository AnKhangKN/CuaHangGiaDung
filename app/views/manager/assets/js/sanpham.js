// Hàm mở modal
function openModalSanPham() {
  const modal = document.getElementById("productDetailsModal");
  modal.style.display = "flex"; // Hiển thị modal

  // Thêm sự kiện để đóng modal khi nhấn bên ngoài
  document.addEventListener("click", closeModalOutside);
}

// Hàm đóng modal
function closeModalSanPham() {
  const modal = document.getElementById("productDetailsModal");
  modal.style.display = "none"; // Ẩn modal

  // Xóa sự kiện đóng modal bên ngoài
  document.removeEventListener("click", closeModalOutside);
}

// Hàm xử lý sự kiện đóng modal khi nhấn bên ngoài
function closeModalOutside(event) {
  const modal = document.getElementById("productDetailsModal");
  const container = document.querySelector(
    ".js-product__modal-container-watch"
  );

  // Nếu click không nằm trong container modal, đóng modal
  if (event.target === modal || !container.contains(event.target)) {
    closeModalSanPham();
  }
}

// Gán sự kiện cho nút close
const closeButton = document.querySelector(".js-product__modal-close-watch");
closeButton.addEventListener("click", closeModalSanPham);

// Lấy tất cả các nút "Xem Chi Tiết"
const buttons = document.querySelectorAll(".view-details");

buttons.forEach((button) => {
  button.addEventListener("click", function () {
    const idSanPham = this.getAttribute("data-idsp"); // Lấy ID sản phẩm từ thuộc tính data-idsp
    const idChiTietSanPham = this.getAttribute("data-idctsp"); // Lấy ID chi tiết sản phẩm từ thuộc tính data-idctsp

    // Gửi yêu cầu AJAX tới server để lấy thông tin chi tiết sản phẩm
    fetch(
      `/CuaHangGiaDung/app/controllers/manager/viewSanPham.php?idSanPham=${idSanPham}&idChiTietSanPham=${idChiTietSanPham}`
    )
      .then((response) => response.text()) // Chuyển phản hồi từ server thành text
      .then((data) => {
        document.getElementById("product-details").innerHTML = data; // Chèn dữ liệu vào modal
        openModalSanPham(); // Mở modal
      })
      .catch((error) => {
        console.error("Lỗi khi lấy chi tiết sản phẩm:", error);
        alert("Có lỗi xảy ra. Vui lòng thử lại!");
      });
  });
});

// Xem trước hình ảnh đơn
const singleImageInput = document.getElementById("singleImage");
const singleImagePreview = document.getElementById("singleImagePreview");

singleImageInput.addEventListener("change", function () {
  // Xóa ảnh xem trước cũ
  singleImagePreview.innerHTML = "";

  // Lấy file được chọn
  const file = this.files[0];
  if (file) {
    const reader = new FileReader();

    reader.onload = function (e) {
      // Tạo thẻ img để hiển thị ảnh
      const img = document.createElement("img");
      img.src = e.target.result;
      singleImagePreview.appendChild(img);
    };

    reader.readAsDataURL(file);
  }
});

// Xem trước nhiều hình ảnh
const multipleImagesInput = document.getElementById("multipleImages");
const multipleImagesPreview = document.getElementById("multipleImagesPreview");

multipleImagesInput.addEventListener("change", function () {
  // Xóa ảnh xem trước cũ
  multipleImagesPreview.innerHTML = "";

  // Lặp qua tất cả các file được chọn
  const files = this.files;
  Array.from(files).forEach((file) => {
    if (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        // Tạo thẻ img để hiển thị ảnh
        const img = document.createElement("img");
        img.src = e.target.result;
        multipleImagesPreview.appendChild(img);
      };

      reader.readAsDataURL(file);
    }
  });
});
