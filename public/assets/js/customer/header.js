// Ẩn hiện menu chính
const iconMenu = document.getElementById('menu_icon'); // Không dùng '#'
const menu = document.getElementById('menu');

iconMenu.addEventListener('click', function(){
    // Kiểm tra trạng thái của menu
    if (menu.style.display === 'none' || menu.style.display === '') {
        menu.style.display = 'block';  // Hiển thị menu
        iconMenu.classList.remove('fa-bars'); // Ẩn biểu tượng bars
        iconMenu.classList.add('fa-times');  // Hiện biểu tượng X
    } else {
        menu.style.display = 'none';  // Ẩn menu
        iconMenu.classList.remove('fa-times'); // Ẩn biểu tượng X
        iconMenu.classList.add('fa-bars');  // Hiện lại biểu tượng bars
    }
});

// Lắng nghe sự kiện click cho biểu tượng
document.getElementById("nav_tool_search_icon").addEventListener("click", function() {
    document.getElementById("nav_tool_search_input").focus(); // Đưa con trỏ vào ô nhập liệu
});

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

// ---------------------------------------------
// Lấy các phần tử
const searchInput = document.getElementById('nav_tool_search_input');
const searchIcon = document.getElementById('nav_tool_search_icon');
const closeButton = document.getElementById('close_search');

// Hàm hiển thị ô tìm kiếm full màn hình
function showSearchInput() {
    searchInput.classList.add('active');
    searchInput.style.display = 'flex'; // Hiện ô tìm kiếm
    closeButton.style.display = 'block'; // Hiện nút đóng
}

// Hàm ẩn ô tìm kiếm
function hideSearchInput() {
    searchInput.classList.remove('active');
    searchInput.style.display = 'none'; // Ẩn ô tìm kiếm
    closeButton.style.display = 'none'; // Ẩn nút đóng
}

// Gắn sự kiện click cho biểu tượng tìm kiếm
searchIcon.addEventListener('click', showSearchInput);

// Gắn sự kiện click cho nút đóng
closeButton.addEventListener('click', hideSearchInput);
