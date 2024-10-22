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

// --------------------------------------------------------------------

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


// Mảng ảnh được truyền từ PHP sang JavaScript (sẽ lấy từ HTML)
let images = [];
let currentIndex = 0;

// Khởi tạo mảng ảnh từ HTML
function initImageUrls(imageUrlsFromPhp) {
    images = imageUrlsFromPhp;
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



