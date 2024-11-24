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
// Hàm hiển thị modal
function showChangeInfo(btnId, modalId) {
    const btn = document.getElementById(btnId); // Nút bấm chỉnh sửa
    const modal = document.getElementById(modalId); // Modal cần hiển thị
    const modalBackground = document.querySelector('.modal_change'); // Nền chứa modal

    if (btn && modal && modalBackground) {
        // Hiển thị modal khi nhấn nút
        btn.addEventListener('click', () => {
            // Ẩn tất cả các modal container trước
            const allModals = modalBackground.querySelectorAll('.modal_container');
            allModals.forEach((m) => (m.style.display = 'none'));

            // Hiển thị modal tương ứng
            modalBackground.style.display = 'flex'; // Hiển thị nền
            modal.style.display = 'block'; // Hiển thị modal đúng
        });

        // Ẩn modal khi nhấn nút "x"
        const closeBtn = modal.querySelector('.modal_header_remove'); // Nút đóng
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                modalBackground.style.display = 'none'; // Ẩn nền
                modal.style.display = 'none'; // Ẩn modal container
            });
        }
        
    } else {
        console.error('Không tìm thấy button, modal, hoặc nền:', btnId, modalId);
    }
}

// Gọi hàm cho từng nút chỉnh sửa và modal tương ứng
showChangeInfo('clickChangeName', 'changeName');
showChangeInfo('clickChangePhone', 'changePhone');
showChangeInfo('clickChangeAddress', 'changeAddress');
showChangeInfo('clickChangeEmail', 'changeEmail');
showChangeInfo('clickChangePass', 'changePassword');

// show pass
function showPassWord(btnIcon, showPass) {
    const btn = document.getElementById(btnIcon);
    const show = document.getElementById(showPass);

    if (btn && show) {
        btn.addEventListener('click', () => {
            if (show.type === 'password') {
                btn.classList.remove('fa-eye-slash');
                btn.classList.add('fa-eye');
                show.type = 'text';
            } else {
                btn.classList.remove('fa-eye');
                btn.classList.add('fa-eye-slash');
                show.type = 'password';
            }
        });
    } else {
        console.error("Element not found for IDs:", btnIcon, showPass);
    }
}

showPassWord('showPassLate', 'PassLate');
showPassWord('showPassNew', 'PassNew');
showPassWord('showPassConfirm', 'PassConfirm');

