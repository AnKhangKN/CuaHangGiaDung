$(document).ready(function() {
    // Xử lý sự kiện click cho checkbox
    $('.filter-checkbox').click(function() {
        updateTags(); // Cập nhật các tag
        filter_data(); // Lọc sản phẩm
    });

    // Xử lý sắp xếp checkbox
    $('.filter_arrange').click(function() {
        $('.filter_arrange').not(this).prop('checked', false); // Bỏ chọn các checkbox khác
        console.log('đã được chọn ss');
        filter_data(); // Lọc sản phẩm
    });

    function filter_data() {
        var action = 'getData';
        var color = get_filter('color');
        var size = get_filter('size');
        var price = get_filter('price');
        var arrange = get_filter('arrange');

        // Hiển thị spinner trong khi đang tải
        $('.filter_data').html('<div class="loading_data_by_filter">Loading...</div>');

        $.ajax({
            url: '/CuaHangDungCu/app/controllers/customer/get_data_product.php',
            method: 'POST',
            data: {
                action: action,
                color: color,
                size: size,
                price: price,
                arrange: arrange
            },
            success: function(data) {
                $('.filter_data').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Xử lý lỗi
                $('.filter_data').html('<div class="error">Có lỗi xảy ra. Vui lòng thử lại.</div>');
                console.log('AJAX Error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }

    function get_filter(class_name) {
        var filter = [];
        $('.' + class_name + ':checked').each(function() {
            filter.push($(this).val());
        });
        return filter; // Trả về mảng lọc
    }

    function updateTags() {
        $('.all_products_tags').empty(); // Xóa các tag hiện tại

        // Nhóm bộ lọc giá
        let priceTags = [];
        $('.filter-checkbox.price:checked').each(function() {
            priceTags.push($(this).val());
        });
        if (priceTags.length > 0) {
            $('.all_products_tags').append(`
                <div class="all_products_tags_filter">
                    Giá: <b>${priceTags.join(', ')}</b>
                    <span class="all_products_tags_filter_remove" data-type="price" data-value="${priceTags.join(', ')}">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                </div>
            `);
        }

        // Nhóm bộ lọc màu
        let colorTags = [];
        $('.filter-checkbox.color:checked').each(function() {
            colorTags.push($(this).val());
        });
        if (colorTags.length > 0) {
            $('.all_products_tags').append(`
                <div class="all_products_tags_filter">
                    Màu sắc: <b>${colorTags.join(', ')}</b>
                    <span class="all_products_tags_filter_remove" data-type="color" data-value="${colorTags.join(', ')}">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                </div>
            `);
        }

        // Nhóm bộ lọc kích thước
        let sizeTags = [];
        $('.filter-checkbox.size:checked').each(function() {
            sizeTags.push($(this).val());
        });
        if (sizeTags.length > 0) {
            $('.all_products_tags').append(`
                <div class="all_products_tags_filter">
                    Kích thước: <b>${sizeTags.join(', ')}</b>
                    <span class="all_products_tags_filter_remove" data-type="size" data-value="${sizeTags.join(', ')}">
                        <i class="fa-solid fa-xmark"></i>
                    </span>
                </div>
            `);
        }
    }

    // Khi nhấn "x" trên tag
    $(document).on('click', '.all_products_tags_filter_remove', function() {
        let type = $(this).data('type');
        let value = $(this).data('value').split(', '); // Chia giá trị thành mảng

        // Bỏ chọn tất cả checkbox tương ứng
        value.forEach(val => {
            $(`.filter-checkbox.${type}[value="${val.trim()}"]`).prop('checked', false);
        });

        // Cập nhật lại các tag và lọc sản phẩm
        updateTags();
        filter_data();
    });
});
