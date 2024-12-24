// Bắt sự kiện khi cuộn trang
window.onscroll = function() {
    scrollFunction();
};

$(document).ready(function() {
    // Menu
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.w-menu').addClass('fixed-menu');
            $('.w-child-menu').addClass('fixed-child-menu');
        } else {
            $('.w-menu').removeClass('fixed-menu');
            $('.w-child-menu').removeClass('fixed-child-menu');
        }
    });

    // Css reponsive mobile nav
    $('.nav-link-mb').click(function(e){
        e.preventDefault();
        var $this = $(this);
        var id = $this.data('id');
        var $dropdownContent = $('#dropdown-content-' + id);
        // Ẩn tất cả các danh sách thả xuống ngoại trừ danh sách được nhấp
        $this.closest('li').siblings().find('.dropdown-content-mobile').hide();

        // Chuyển đổi nội dung và icon thả xuống
        $this.find('.icon-down').toggle();
        $this.find('.icon-up').toggle();
        $dropdownContent.toggle();
    });

    $("#prd-cate-list .main-cate ul li").hover(
        function() {
            $(this).addClass("active"); // Thêm class active khi hover
            $(this).find("i.fa-chevron-right").css("display", "inline");
        },
        function() {
            $(this).removeClass("active"); // Bỏ class active khi rời khỏi
            $(this).find("i.fa-chevron-right").css("display", "none");
        }
    );

    $('.dn-prd-cate, .dn-main-cate').hover(
        function () {
            $('.dn-main-cate').css('display', 'block');
        },
        function () {
            // Khi chuột rời khỏi cả hai
            setTimeout(() => {
                if (!$('.dn-prd-cate:hover').length && !$('.dn-main-cate:hover').length) {
                    $('.dn-main-cate').css('display', 'none');
                }
            }, 100); // Thêm một khoảng delay để tránh nhấp nháy
        }
    );

    const $toggler = $(".navbar-toggler");
    const $iconBars = $toggler.find(".fa-bars");
    const $iconXmark = $toggler.find(".fa-xmark");

    $toggler.on("click", function () {
        // Kiểm tra trạng thái của các icon và toggle class `d-none`
        $iconBars.toggleClass("d-none");
        $iconXmark.toggleClass("d-none");
    });
});
function scrollFunction() {
    var topLink = document.getElementById("top-link");
    
    // Kiểm tra xem đã cuộn xuống 100px hay chưa
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        topLink.classList.add("active");  // Hiển thị nút
    } else {
        topLink.classList.remove("active");  // Ẩn nút
    }
}

// Cuộn lên đầu trang khi nhấn vào nút
document.getElementById("top-link").addEventListener("click", function(e) {
    e.preventDefault();
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Cuộn mượt mà
    });
});
