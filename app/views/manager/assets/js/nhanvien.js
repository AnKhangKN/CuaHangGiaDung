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
const buttons = document.querySelectorAll('.view-nhanvien');

buttons.forEach(button => {
    button.addEventListener('click', function () {
        const idSanPham = this.getAttribute('data-id'); // Lấy ID sản phẩm từ thuộc tính data-id

        // Gửi yêu cầu AJAX tới server để lấy thông tin chi tiết sản phẩm
        fetch(`/CHDDTTHKN/assets/controller/viewNhanVien.php?idNhanVien=${idNhanVien}`)
            .then(response => response.text()) // Chuyển phản hồi từ server thành text
            .then(data => {
                document.getElementById('product-details').innerHTML = data; // Chèn dữ liệu vào modal
                openModalSanPham(); // Mở modal
            })
            .catch(error => {
                console.error('Lỗi khi lấy chi tiết nhân viên:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            });
    });
});