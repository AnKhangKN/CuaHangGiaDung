
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



// lấy dữ liệu
$(document).ready(function () {

    function checkValue(inputField) {
        const soluong = parseInt(inputField.val());
        const productInfo = inputField.closest(".product_info_to_cart");
        let amount = parseInt(productInfo.find("#ProductAmount").text()); 

        if (soluong < 1) {
            inputField.val(0); 
        }
        else if(soluong > amount){
            inputField.val(amount);
        }
        
    }

    $(".products_details_info_add_products_input").on('input', function () {
        checkValue($(this));
    });

    $().change(function (e) { 
        e.preventDefault();
        
    });

    // Event listener for decreasing quantity
    $(".products_details_info_add_products_minus").click(function (e) { 
        e.preventDefault();

        const productInfo = $(this).closest(".product_info_to_cart");
        const inputField = productInfo.find(".products_details_info_add_products_input");
        const soluong = parseInt(inputField.val()) || 1;
        const newCount = Math.max(0, soluong - 1);
        
        inputField.val(newCount);
    });

    // Event listener for increasing quantity
    $(".products_details_info_add_products_plus").click(function (e) { 
        e.preventDefault();
    
        const productInfo = $(this).closest(".product_info_to_cart");
        const inputField = productInfo.find(".products_details_info_add_products_input");
        let amount = parseInt(productInfo.find("#ProductAmount").text()) || 0;
    
        // Sửa điều kiện kiểm tra giá trị amount
        if (amount === 0) {
            alert("Sản phẩm này đã hết hàng!");
        }
        else {
            let soluong = parseInt(inputField.val()) || 0;
            
    
            let newCount = soluong + 1; 
            
            // Kiểm tra nếu số lượng nhập vào lớn hơn hoặc bằng số lượng còn lại
            if (soluong >= amount) {
                newCount = amount;  
            }
    
            inputField.val(newCount); 
        }
    });
    
    $('.products_details_info_size_group_item input[type="checkbox"]').change(function() {
        if ($(this).is(':checked')) {
            $('.products_details_info_size_group_item input[type="checkbox"]').not(this).prop('checked', false);
        }
    });

    $('.products_details_info_color_item input[type="checkbox"]').change(function() {
        if ($(this).is(':checked')) {
            $('.products_details_info_color_item input[type="checkbox"]').not(this).prop('checked', false);
        }
    });
    

    $(".products_details_info_size_group_item_input, .products_details_info_color_item_input").change(function() {
        const productInfo = $(this).closest(".product_info_to_cart");
        
        let size = productInfo.find(".products_details_info_size_group_item_input:checked").val();
        if (!size) {
            size = "Không có kích thước";
        }

        let color = productInfo.find(".products_details_info_color_item_input:checked").val();
        

        const productId = productInfo.find("#ProductId").text();

        // Lấy số lượng còn lại của sản phẩm dựa trên size và color đã chọn
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/customer/ProductAmount.php",
            data: {
                action: "select",
                size: size,
                color: color,
                productId: productId
            },
            success: function (response) {

                if (response.includes('|')) {
                    const [amount, id] = response.split('|');
                    $('#ProductAmount').html(amount);
                } else {
                    console.log("Hãy chung cấp đủ thông tin!");
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#ProductAmount').html("Có lỗi xảy ra");
            }
        });
    });

    $(".add_cart").click(function (e) {
        e.preventDefault();
    
        const productInfo = $(this).closest(".product_info_to_cart");
    
        const urlHinhAnh = productInfo.find("#largeImg").attr("src");
        const tenSP = productInfo.find(".products_details_info_title_name").text();
        const gia = productInfo.find(".products_details_info_price_new").text();
    
        let size = productInfo.find(".products_details_info_size_group_item_input:checked").val();
        if (!size) {
            size = "Không có kích thước";
        }
    
        let color = productInfo.find(".products_details_info_color_item_input:checked").val();
    
        let soluong = parseInt(productInfo.find(".products_details_info_add_products_input").val());

        // Lấy ID sản phẩm
        const productId = productInfo.find("#ProductId").text();

        let amount = parseInt(productInfo.find("#ProductAmount").text()); // Chuyển đổi `amount` thành số
    
        if (soluong > 0 && amount > 0) {
            // Thực hiện gửi dữ liệu thêm vào giỏ hàng
            $.ajax({
                type: "POST",
                url: "/CuaHangDungCu/app/controllers/customer/add_to_cart.php",
                data: {
                    urlHinhAnh: urlHinhAnh,
                    tenSP: tenSP,
                    gia: gia,
                    size: size,
                    color: color,
                    soluong: soluong,
                    productId: productId
                },
                success: function (response) {
                    console.log(response);
                    $(".add_product_item").addClass("block_product"); 
                    setTimeout(() => {
                        $(".add_product_item").removeClass("block_product");
                    }, 500);
                    
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Lỗi: " + textStatus + " - " + errorThrown);
                }
            });
        } else if (amount === 0) {
            alert("Sản phẩm đã hết hàng!");
            
        } else {
            alert("Hãy thêm số lượng!");
        }
    });
    
});
