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



// --------------------------------------------------------------------
// search
// Lấy các phần tử từ DOM
const boxIcon = document.querySelector('.nav_tool_search_icon_box');
const boxRecommend = document.querySelector('.nav_tool_box');
const boxClose = document.querySelector('.close_search_top');
const boxSearch = document.querySelector('.nav_tool_search');
const inputBox = document.getElementById('nav_tool_search_box');

// Hàm xử lý click vào biểu tượng tìm kiếm
function showSearchBox() {
    boxIcon.style.display = 'none'; // Ẩn biểu tượng tìm kiếm
    boxRecommend.style.display = 'block'; // Hiện hộp gợi ý
    boxClose.style.display = 'block'; // Hiện nút đóng
    boxSearch.style.display = 'block'; // Hiện hộp tìm kiếm
}

// Hàm xử lý click vào nút đóng
function hideSearchBox() {
    boxIcon.style.display = 'block'; // Hiện lại biểu tượng tìm kiếm
    boxRecommend.style.display = 'none'; // Ẩn hộp gợi ý
    boxClose.style.display = 'none'; // Ẩn nút đóng
    boxSearch.style.display = 'none'; // Ẩn hộp tìm kiếm
}

// Gán sự kiện click cho các phần tử
boxIcon.addEventListener('click', showSearchBox);
inputBox.addEventListener('click', showSearchBox);
boxClose.addEventListener('click', hideSearchBox);

// --------------------------------------------------------------------

// Ẩn hiện đang nhập đăng ký
const upUserOption = document.getElementsByClassName('nav_tool_user_option_up')[0]; // Lấy phần tử đầu tiên
const userOptionMark = document.getElementById('nav_tool_mark_id_user');
const userOption = document.getElementById('nav_tool_user_option_id_user');

// Hàm hiển thị tùy chọn người dùng
function showUserOption() {
    userOption.style.display = 'block';
    upUserOption.style.display = 'block';
}

// Hàm ẩn tùy chọn người dùng
function hideUserOption() {
    userOption.style.display = 'none';
    upUserOption.style.display = 'none';
}

// Sự kiện khi nhấp vào biểu tượng
userOptionMark.addEventListener('click', function(event) {
    event.stopPropagation(); // Ngăn chặn sự kiện click lan truyền
    // Kiểm tra trạng thái hiển thị của tùy chọn người dùng
    if (userOption.style.display === 'block' && upUserOption.style.display === 'block') {
        hideUserOption(); // Nếu đang hiển thị thì ẩn đi
    } else {
        showUserOption(); // Nếu không thì hiển thị
    }
});

// Sự kiện khi nhấp ra ngoài tùy chọn người dùng
document.addEventListener('click', function(event) {
    // Kiểm tra nếu nhấp ra ngoài biểu tượng hoặc phần tùy chọn người dùng
    if (!userOptionMark.contains(event.target) && !userOption.contains(event.target)) {
        hideUserOption(); // Ẩn phần tùy chọn người dùng
    }
});

