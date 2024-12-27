// Hàm mở modal
function openModalSanPham() {
    const modal = document.getElementById('productDetailsModal');
    modal.style.display = 'flex'; // Hiển thị modal

    // Thêm sự kiện để đóng modal khi nhấn bên ngoài
    document.addEventListener('click', closeModalOutside);
}

// Hàm đóng modal
function closeModalSanPham() {
    const modal = document.getElementById('productDetailsModal');
    modal.style.display = 'none'; // Ẩn modal

    // Xóa sự kiện đóng modal bên ngoài
    document.removeEventListener('click', closeModalOutside);
}

// Hàm xử lý sự kiện đóng modal khi nhấn bên ngoài
function closeModalOutside(event) {
    const modal = document.getElementById('productDetailsModal');
    const container = document.querySelector('.js-product__modal-container-watch');
    
    // Nếu click không nằm trong container modal, đóng modal
    if (event.target === modal || !container.contains(event.target)) {
        closeModalSanPham();
    }
}

// Gán sự kiện cho nút close
const closeButton = document.querySelector('.js-product__modal-close-watch');
closeButton.addEventListener('click', closeModalSanPham);


// Lấy tất cả các nút "Xem Chi Tiết"
const buttons = document.querySelectorAll('.view-details');

buttons.forEach(button => {
    button.addEventListener('click', function () {
        const idSanPham = this.getAttribute('data-id'); // Lấy ID sản phẩm từ thuộc tính data-id

        // Gửi yêu cầu AJAX tới server để lấy thông tin chi tiết sản phẩm
        fetch(`/CHDDTTHKN/assets/controller/viewSanPham.php?idSanPham=${idSanPham}`)
            .then(response => response.text()) // Chuyển phản hồi từ server thành text
            .then(data => {
                document.getElementById('product-details').innerHTML = data; // Chèn dữ liệu vào modal
                openModalSanPham(); // Mở modal
            })
            .catch(error => {
                console.error('Lỗi khi lấy chi tiết sản phẩm:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.content__modal-body-form');
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Ngăn chặn load lại trang

        let errors = [];

        // Lấy các giá trị của các trường
        const tensanpham = form.querySelector('input[name="tensanpham"]');
        const dongia = form.querySelector('input[name="dongia"]');
        const mota = form.querySelector('input[name="mota"]');
        const soluongconlai = form.querySelector('input[name="soluongconlai"]');
        const urlhinhanh = form.querySelector('input[name="urlhinhanh"]');

        // Kiểm tra các trường
        if (!tensanpham.value.trim()) {
            errors.push('Tên sản phẩm không được để trống.');
        }
        if (!dongia.value || parseInt(dongia.value) <= 0) {
            errors.push('Đơn giá phải là số lớn hơn 0.');
        }
        if (!mota.value.trim()) {
            errors.push('Mô tả không được để trống.');
        }
        if (!soluongconlai.value || parseInt(soluongconlai.value) <= 0) {
            errors.push('Số lượng sản phẩm phải là số lớn hơn 0.');
        }
        if (!urlhinhanh.value) {
            errors.push('Hình ảnh sản phẩm không được để trống.');
        }

        // Nếu có lỗi, hiển thị lỗi và không gửi form
        if (errors.length > 0) {
            alert(errors.join('\n')); // Hiển thị lỗi
        } else {
            // Không có lỗi, gửi form
            form.submit();
            window.location.href = '/CHDDTTHKN/assets/view/QuanLy/index.php?page=sanpham';
        }

    });
});
