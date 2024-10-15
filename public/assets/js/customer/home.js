// --------------------------------------------------------------------
//slider
var sliderIndex = 0;
carousel();

function carousel() {
    var item;
    var slider = document.getElementsByClassName("home_slider_img");
    for (item = 0; item < slider.length; item++) {
    slider[item].style.display = "none";  
    }
    sliderIndex++;
    if (sliderIndex > slider.length) {sliderIndex = 1}    
    slider[sliderIndex-1].style.display = "block";  
  setTimeout(carousel, 3000); // Change image every 2 seconds
}
// --------------------------------------------------------------------

// chuyển sản phẩm best sellers
function createProductCarousel(productsListId, prevBtnId, nextBtnId) {
    const productsList = document.getElementById(productsListId);
    const nextBtn = document.getElementById(nextBtnId);
    const prevBtn = document.getElementById(prevBtnId);
    
    const totalProducts = productsList.children.length; // Tổng số sản phẩm
    let visibleProducts = calculateVisibleProducts(); // Số sản phẩm hiển thị mỗi lần
    let productWidth = productsList.clientWidth / visibleProducts; // Chiều rộng của mỗi sản phẩm
    let currentIndex = 0;

    function calculateVisibleProducts() {
        const screenWidth = window.innerWidth;
        if (screenWidth >= 1024) {
            return 4; // Hiển thị 4 sản phẩm trên màn hình lớn
        } else if (screenWidth >= 768) {
            return 3; // Hiển thị 3 sản phẩm trên màn hình trung bình
        } else {
            return 2; // Hiển thị 2 sản phẩm trên màn hình nhỏ
        }
    }

    function updateButtons() {
        prevBtn.disabled = currentIndex === 0; // Vô hiệu hóa nút 'Lui' khi ở sản phẩm đầu tiên
        nextBtn.disabled = currentIndex >= totalProducts - visibleProducts; // Vô hiệu hóa nút 'Tới' khi không còn sản phẩm để hiển thị
    }

    function scrollToIndex(index) {
        productsList.scrollTo({
            left: index * productWidth,
            behavior: 'smooth'
        });
    }

    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalProducts - visibleProducts) { // Chỉ cuộn nếu không đến sản phẩm cuối
            currentIndex++;
            scrollToIndex(currentIndex);
            updateButtons();
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            scrollToIndex(currentIndex);
            updateButtons();
        }
    });

    // Cập nhật lại visibleProducts và productWidth khi thay đổi kích thước màn hình
    window.addEventListener('resize', () => {
        visibleProducts = calculateVisibleProducts();
        productWidth = productsList.clientWidth / visibleProducts;
        scrollToIndex(currentIndex); // Điều chỉnh lại vị trí sau khi resize
        updateButtons();
    });

    // Cập nhật trạng thái nút ban đầu
    updateButtons();
}

// Khởi tạo carousel
createProductCarousel('productsList', 'prevBtn', 'nextBtn');

// --------------------------------------------------------------------

// chuyển sản phẩm mới
function createNewProductCarousel(productsListId, newPrevBtnId, newNextBtnId) {
    const productsList = document.getElementById(productsListId);
    const prevBtn = document.getElementById(newPrevBtnId);
    const nextBtn = document.getElementById(newNextBtnId);
    
    const totalProducts = productsList.children.length; // Tổng số sản phẩm
    let visibleProducts = calculateVisibleNewProducts(); // Số sản phẩm hiển thị mỗi lần
    let productWidth = productsList.clientWidth / visibleProducts; // Chiều rộng của mỗi sản phẩm
    let currentIndex = 0;

    function calculateVisibleNewProducts() {
        const screenWidth = window.innerWidth;
        if (screenWidth >= 1024) {
            return 3; // Hiển thị 3 sản phẩm trên màn hình lớn
        } else if (screenWidth >= 600) {
            return 2; // Hiển thị 2 sản phẩm trên màn hình trung bình
        } else{
            return 1;
        }
    }

    function updateNewButtons() {
        prevBtn.disabled = currentIndex === 0; // Vô hiệu hóa nút 'Lui' khi ở sản phẩm đầu tiên
        nextBtn.disabled = currentIndex >= totalProducts - visibleProducts; // Vô hiệu hóa nút 'Tới' khi không còn sản phẩm để hiển thị
    }

    function scrollToNewIndex(index) {
        productsList.scrollTo({
            left: index * productWidth,
            behavior: 'smooth'
        });
    }

    nextBtn.addEventListener('click', () => {
        if (currentIndex < totalProducts - visibleProducts) { // Chỉ cuộn nếu không đến sản phẩm cuối
            currentIndex++;
            scrollToNewIndex(currentIndex);
            updateNewButtons();
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentIndex > 0) {
            currentIndex--;
            scrollToNewIndex(currentIndex);
            updateNewButtons();
        }
    });

    // Cập nhật lại visibleProducts và productWidth khi thay đổi kích thước màn hình
    window.addEventListener('resize', () => {
        visibleProducts = calculateVisibleNewProducts();
        productWidth = productsList.clientWidth / visibleProducts;
        scrollToNewIndex(currentIndex); // Điều chỉnh lại vị trí sau khi resize
        updateNewButtons();
    });

    // Cập nhật trạng thái nút ban đầu
    updateNewButtons();
}

// Khởi tạo carousel
createNewProductCarousel('newProductsList', 'newPrevBtn', 'newNextBtn');
