$(document).ready(function () {
    var cart = $("#cart").children(".cart_contents_table");
    var count_product = cart.length;

    var show_count_product =  $("#count_product");
    show_count_product.text(count_product);

});