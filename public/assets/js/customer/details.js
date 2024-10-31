
// --------------------------------------------------------------------
// list products best seller
function createProductRecommend(productsListIdRecommend, prevBtnIdRecommend, nextBtnIdRecommend) {
    const productsDetailsListRecommend = document.getElementById(productsListIdRecommend);
    const nextBtnDetailsRecommend = document.getElementById(nextBtnIdRecommend);
    const prevBtnDetailsRecommend = document.getElementById(prevBtnIdRecommend);
    
    const totalProductsRecommend = productsDetailsListRecommend.children.length; // Tổng số sản phẩm
    if (totalProductsRecommend === 0) {
        console.warn("Không có sản phẩm nào để hiển thị.");
        return; // Thoát hàm nếu không có sản phẩm
    }

    let visibleProducts = calculateVisibleProducts(); // Số sản phẩm hiển thị mỗi lần
    let productWidth = productsDetailsListRecommend.clientWidth / visibleProducts; // Chiều rộng của mỗi sản phẩm
    let currentIndex = 0;

    function calculateVisibleProducts() {
        const screenWidth = window.innerWidth;
        if (screenWidth >= 1024) {
            return 4; // Hiển thị 4 sản phẩm trên màn hình lớn
        } else if (screenWidth >= 768) {
            return 3; // Hiển thị 3 sản phẩm trên màn hình vừa
        } else {
            return 2; // Hiển thị 2 sản phẩm trên màn hình nhỏ
        }
    }

    function updateButtons() {
        prevBtnDetailsRecommend.disabled = currentIndex === 0; // Vô hiệu hóa nút 'Trước' nếu ở sản phẩm đầu
        nextBtnDetailsRecommend.disabled = currentIndex >= totalProductsRecommend - visibleProducts; // Vô hiệu hóa nút 'Tiếp theo' nếu không còn sản phẩm để hiển thị
    }

    function scrollToIndex(index) {
        productsDetailsListRecommend.scrollTo({
            left: index * productWidth,
            behavior: 'smooth'
        });
    }

    nextBtnDetailsRecommend.addEventListener('click', () => {
        if (currentIndex < totalProductsRecommend - visibleProducts) { // Chỉ cuộn nếu không ở sản phẩm cuối
            currentIndex++;
            scrollToIndex(currentIndex);
            updateButtons();
        }
    });

    prevBtnDetailsRecommend.addEventListener('click', () => {
        if (currentIndex > 0) { // Chỉ cuộn nếu không ở sản phẩm đầu
            currentIndex--;
            scrollToIndex(currentIndex);
            updateButtons();
        }
    });

    // Cập nhật số sản phẩm hiển thị và chiều rộng sản phẩm khi thay đổi kích thước cửa sổ
    window.addEventListener('resize', () => {
        visibleProducts = calculateVisibleProducts();
        productWidth = productsDetailsListRecommend.clientWidth / visibleProducts;
        scrollToIndex(currentIndex); // Điều chỉnh vị trí sau khi thay đổi kích thước
        updateButtons();
    });

    // Cập nhật trạng thái nút ban đầu
    updateButtons();
}

// Khởi tạo carousel
createProductRecommend('productsListRecommend', 'prevBtnRecommend', 'nextBtnRecommend');


// --------------------------------------------------------------------


// Mảng ảnh được truyền từ PHP sang JavaScript
let images = [];
let currentIndex = 0;

// Khởi tạo mảng ảnh từ biến toàn cục
function initImageUrls() {
    images = window.imageUrlsFromPhp; // Lấy từ biến toàn cục
    updateImage(); // Cập nhật ảnh lớn ngay sau khi khởi tạo
}

// Cập nhật ảnh lớn
function updateImage() {
    var largeImage = document.getElementById("largeImg");
    largeImage.src = images[currentIndex];
}

// Chuyển sang ảnh trước
function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage();
}

// Chuyển sang ảnh kế tiếp
function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
}

// Thay đổi ảnh lớn khi nhấn vào ảnh nhỏ
function changeImage(thumbnail) {
    var largeImage = document.getElementById("largeImg");
    largeImage.src = thumbnail.src;
    currentIndex = images.indexOf(thumbnail.src);
}

// Gọi hàm khởi tạo khi trang được tải
window.onload = initImageUrls;




