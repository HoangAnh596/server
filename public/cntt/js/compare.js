$(document).ready(function() {
    $('.bg-popup').hide();
    // bộ lọc filter
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 320) {
            $('.pro-compare').addClass('sticky-cp');
            $('.fixed-top').hide();
        } else {
            $('.pro-compare').removeClass('sticky-cp');
            $('.fixed-top').show();
        }
    });

    // Khi click vào thẻ li class productid-0 để mở modal, ẩn .pro-compare
    $('.productid-0 .addsp-cp').on('click', function() {
        if ($(window).scrollTop() > 320) {
            $('.scroll-container .pro-compare').css('display', 'none');
            $('.bg-popup').show();
            $('.sticky-cp').css('right', '18px');
        }
    });

    // Hiển thị lại .pro-compare khi modal đóng
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('.scroll-container .pro-compare').css('display', 'block');
        $('.bg-popup').hide();
        $('.sticky-cp').css('right', '0');
    });
});