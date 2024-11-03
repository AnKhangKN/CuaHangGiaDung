// Hàm để hiển thị nội dung và thêm class highlight
function showContent(sectionId, element) {
    // Ẩn tất cả các phần nội dung
    var sections = document.getElementsByClassName("content-section");
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = "none";
    }

    // Hiển thị phần nội dung được chọn
    document.getElementById(sectionId).style.display = "block";

    // Xóa class highlight khỏi tất cả các mục trong sidebar
    var items = document.getElementsByClassName("view_infor");
    for (var i = 0; i < items.length; i++) {
        items[i].classList.remove("highlight");
    }

    // Thêm class highlight vào mục được nhấp
    element.classList.add("highlight");
}

// Hiển thị mặc định phần "overview" và thêm highlight vào mục đầu tiên
document.addEventListener("DOMContentLoaded", function() {
    showContent('overview', document.querySelector('.sidebar_list li'));
});

// --------------------------------------------------------------------


function showHistory(btn_history, show_history) {
    const btn = document.getElementById(btn_history);
    const show = document.getElementById(show_history);

    
    btn.addEventListener('click', () => {
        show.style.display = show.style.display === 'none' ? 'block' : 'none';
    });
}

showHistory('purchase_history_btn', 'purchase_history_show_hidden');

// ----------------------------------------------------------------------
function showChangeBox(idBox) {
    // Ẩn tất cả các phần nội dung
    var sections = document.getElementsByClassName("changeBox");

    // Ẩn tất cả các sections
    for (var i = 0; i < sections.length; i++) {
        sections[i].style.display = "none";
    }


    // Hiển thị phần nội dung được chọn
    var selectedSection = document.getElementById(idBox);
    selectedSection.style.display = "block";

    // Thêm sự kiện click cho nút đóng trong phần nội dung đã chọn
    var closeBtn = selectedSection.getElementsByClassName("close_change")[0];
    if (closeBtn) {
        closeBtn.onclick = function() {
            selectedSection.style.display = "none";
        };
    }
}


