// Bắt sự kiện khi cuộn trang
window.onscroll = function() {
    scrollFunction();
};

$(document).ready(function() {
    // Kiểm tra nếu người dùng chưa truy cập trước đó
    if (!sessionStorage.getItem("modalShown")) {
        // Hiển thị modal
        $("#locationModel").modal("show");

        // Lưu trạng thái vào sessionStorage
        sessionStorage.setItem("modalShown", "true");
    } else {
        // Hiển thị lại vị trí đã chọn từ localStorage
        const savedLocation = localStorage.getItem("selectedLocation");
        if (savedLocation) {
            $('a[data-bs-target="#locationModel"]').text(savedLocation);
        }
    }
    // Kiểm tra vị trí người dùng
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            // Lấy tọa độ latitude và longitude của người dùng
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            console.log(latitude, longitude);
            
            // Sử dụng API để lấy tên thành phố (hoặc xác định thành phố gần nhất)
            fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.address) {
                        const city = data.address.city || data.address.town || data.address.village;

                        // Kiểm tra nếu thành phố là Hà Nội và chọn giá trị
                        if (city && city.includes("Hà Nội")) {
                            $('select[name="location"] option[value="1"]').prop('selected', true);
                        } else if (city && city.includes("Đà Nẵng")) {
                            $('select[name="location"] option[value="2"]').prop('selected', true);
                        } else if (city && city.includes("Hồ Chí Minh")) {
                            $('select[name="location"] option[value="3"]').prop('selected', true);
                        }
                    }
                })
                .catch(error => console.error("Error fetching location data:", error));
        }, function (error) {
            console.error("Lỗi lấy vị trí địa lý:", error);
        });
    }
    // Khi modal đóng, cập nhật vị trí vào thẻ <li>
    $('#locationModel').on('hidden.bs.modal', function() {
        // Lấy giá trị vị trí được chọn
        const selectedLocation = $('#locationModel select.form-select').find(":selected").text();
// console.log(selectedLocation);

        // Kiểm tra nếu giá trị không phải là "Chọn vị trí"
        if (selectedLocation !== "Chọn vị trí") {
            // Cập nhật nội dung của thẻ <li>
            $('a[data-bs-target="#locationModel"]').text(selectedLocation);
            // Lưu giá trị vào localStorage
            localStorage.setItem("selectedLocation", selectedLocation);
        }
    });

    // Menu
    $(window).on('scroll', function() {
        if ($(window).width() > 1200 && window.location.pathname !== "/") {
            if ($(this).scrollTop() > 200) {
                $('#app').addClass('fixed-app');
                $('.form-serach').addClass('fixed-menu');
                $('.w-child-menu').addClass('fixed-child-menu');
            } else {
                $('#app').removeClass('fixed-app');
                $('.form-serach').removeClass('fixed-menu');
                $('.w-child-menu').removeClass('fixed-child-menu');
            }
        } else {
            $('#app').removeClass('fixed-app');
            $('.form-serach').removeClass('fixed-menu');
            $('.w-child-menu').removeClass('fixed-child-menu');
        }
    });

    // Css reponsive mobile nav
    $('.nav-link-mb').click(function(e) {
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

    $("#prd-cate-list .main-cate > ul > li").hover(
        function() {
            $(this).addClass("active");
        },
        function() {
            $(this).removeClass("active");
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
