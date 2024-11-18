// Bắt sự kiện khi cuộn trang
window.onscroll = function() {
    scrollFunction();
};

$(document).ready(function() {
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
