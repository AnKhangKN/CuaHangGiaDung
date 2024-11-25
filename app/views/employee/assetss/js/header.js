$(document).ready(function () {
    // Lấy URL hiện tại
    const currentUrl = new URL(window.location.href);
    const currentPage = currentUrl.searchParams.get('page');

    // Lặp qua tất cả các phần tử có class .list_tool
    $('.list_tool_item').each(function () {
        const lsNav = $(this);

        // Lấy href từ thẻ <a> bên trong .list_tool
        const href = lsNav.find('a').attr('href');
        if (href) {
            const hrefPage = new URL(href, window.location.origin).searchParams.get('page');

            // Nếu `page` trong href trùng với `page` hiện tại, thêm class `ishere`
            if (hrefPage === currentPage) {
                lsNav.addClass('ishere');
            }
        }
    });
});
