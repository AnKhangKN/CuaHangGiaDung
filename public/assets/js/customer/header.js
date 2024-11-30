
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
function searchBox(box_search, btn_search, btn_close) {
    const search_Box = document.getElementById(box_search); // Correct method name
    const search_Btn = document.getElementById(btn_search);
    const closeBtn = document.getElementById(btn_close);

    // Ensure both elements exist
    if (search_Box && search_Btn) {
        search_Btn.addEventListener('click', () => {
            search_Box.style.display = 'flex'; 
        });
        closeBtn.addEventListener('click', () => {
            search_Box.style.display = 'none';
        })
    } 
}

searchBox('search_box', 'nav_tool_search_icon_box_btn', 'search_box_close');



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

$(document).ready(function () {
    $('#search_box_input').on('input', function () {
        const query = $(this).val();

        if (query.length > 0) {
            // Gửi yêu cầu AJAX để tìm kiếm sản phẩm
            $.ajax({
                url: '/CuaHangDungCu/app/controllers/customer/search_products.php', // Đường dẫn tới file xử lý tìm kiếm
                method: 'GET',
                data: { query: query },
                success: function (data) {
                    // Hiển thị kết quả tìm kiếm
                    $('.search_container').html(data);
                    console.log(data);
                },
                error: function () {
                    console.error('Lỗi xảy ra khi tìm kiếm.');
                }
            });
        } else {
            // Nếu không có nội dung tìm kiếm, xóa kết quả
            $('.search_container').html('');
        }
    });
});

