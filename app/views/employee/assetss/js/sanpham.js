$(document).ready(function () {
    // Lấy tất cả các dòng sản phẩm
    const allRowProduct = $(".cell_product");
    const close = $("#close");

    // Lấy modal chi tiết sản phẩm
    const ChiTietSanPham = $("#modal_product_detail");

    $(close).click(function (e) { 
        e.preventDefault();
        
        ChiTietSanPham.css({
            display: 'none'
        });
    });
    // Thêm sự kiện click cho từng dòng sản phẩm
    allRowProduct.on('click', function () {
        // Hiển thị modal chi tiết sản phẩm
        ChiTietSanPham.css({
            display: 'flex'
        });

        // Lấy thông tin từ dòng được click
        const idSanPham = $(this).find(".idSanPham").text();
        const tenSanPham = $(this).find(".tenSanPham").text();
        const giaSanPham = $(this).find(".giaSanPham").text();
        const imgSanPham = $(this).find(".imgSanPham").attr("src"); // Sửa: Lấy thuộc tính "src"

        // Gửi dữ liệu qua AJAX
        $.ajax({
            type: "POST",
            url: "/CuaHangDungCu/app/controllers/employee/add_product_detail.php",
            data: {
                action: 'InfoSanPham',
                idSanPham: idSanPham,
                tenSanPham: tenSanPham,
                imgSanPham: imgSanPham,
                giaSanPham: giaSanPham
            },
            success: function(response) {
                // Phân tích phản hồi thành đối tượng JavaScript
                const data = JSON.parse(response);
            
                const kichthuoc = $(".size").val();  
                const mausac = $(".color").val();    
                const name = $("#ProductName").text();  
                const img = $("#imgProduct").attr("src");  
            
                const sizeList = $("#sizeList");
                sizeList.empty();  
            
                data.kichthuoc.forEach(function(size) {
                    
                });
            
                // Tương tự, bạn có thể thêm các tùy chọn màu sắc vào danh sách màu sắc
                const colorList = $("#colorList");
                colorList.empty();  // Xóa các mục trong danh sách màu sắc trước đó
            
                data.mausac.forEach(function(color) {
                    const li = document.createElement('li');
                    li.textContent = color;  // Đặt tên màu sắc làm văn bản cho mục danh sách
                    colorList.appendChild(li);  // Thêm mục vào danh sách màu sắc
                });
            
                // Bạn cũng có thể làm gì đó với các giá trị kích thước và màu sắc đã chọn:
                console.log("Kích thước đã chọn: ", kichthuoc);
                console.log("Màu sắc đã chọn: ", mausac);
                console.log("Tên sản phẩm: ", name);
                console.log("Hình ảnh sản phẩm: ", img);
            },
            
            error: function (error) {
                console.error("Error:", error);
            }
        });
    });
});
