function createScrollDetails(listProductsDetails, btnPrev, btnNext) {
    const btnPrevTo = document.getElementById(btnPrev);
    const btnNextTo = document.getElementById(btnNext);
    const listProducts = document.getElementById(listProductsDetails);

    const totalImg = listProducts.children.length;
    let visibleProducts = totalVisibleProducts(); // Số sản phẩm hiển thị mỗi lần (luôn là 1)
    let productWidth = listProducts.clientWidth / visibleProducts; // Chiều rộng của mỗi sản phẩm
    let currentIndex = 0;

    function totalVisibleProducts() {
        return 1; // Hiển thị 1 sản phẩm mỗi lần cho bất kỳ kích thước màn hình nào
    }

    function updateButtons() {
        // Kiểm tra và cập nhật trạng thái của nút 'Prev'
        if (currentIndex === 0) {
            btnPrevTo.style.display = 'none'; // Ẩn nút 'Prev' khi ở sản phẩm đầu tiên
            btnNextTo.style.display = 'block'; // Hiển thị nút 'Next'
        } else {
            btnPrevTo.style.display = 'block'; // Hiển thị nút 'Prev'
        }

        // Kiểm tra và cập nhật trạng thái của nút 'Next'
        if (currentIndex >= totalImg - visibleProducts) {
            btnNextTo.style.display = 'none'; // Ẩn nút 'Next' khi đến sản phẩm cuối
            btnPrevTo.style.display = 'block'; // Hiển thị nút 'Prev'
        } else {
            btnNextTo.style.display = 'block'; // Hiển thị nút 'Next' nếu chưa đến sản phẩm cuối
        }
    }

    function scrollToIndex(index) {
        listProducts.scrollTo({
            left: index * productWidth, // Dịch chuyển đúng vị trí sản phẩm
            behavior: 'smooth'
        });
    }

    btnNextTo.addEventListener('click', () => {
        if (currentIndex < totalImg - visibleProducts) { // Chỉ cuộn nếu chưa đến sản phẩm cuối
            currentIndex++;
            scrollToIndex(currentIndex);
            updateButtons();
        }
    });

    btnPrevTo.addEventListener('click', () => {
        if (currentIndex > 0) { // Chỉ cuộn nếu chưa đến sản phẩm đầu
            currentIndex--;
            scrollToIndex(currentIndex);
            updateButtons();
        }
    });

    // Cập nhật trạng thái nút ban đầu
    updateButtons();
}

// Khởi tạo carousel
createScrollDetails('main_img_show_list_id', 'main_img_show_btn_left_id', 'main_img_show_btn_right_id');
