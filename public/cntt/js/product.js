$(document).ready(function() {
    $('.group-prod').each(function() {
        if ($(this).height() > 150) {
            $(this).find('.group-show-more').show();
        }
    });
    $('.group-show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.group-prod').css('max-height', '10000px');
    });

    // Đảm bảo rằng ảnh chỉ được thêm vào modal một lần
    if ($('#imageModal .modal-content img').length === 0) {
        $('.gallery-trigger img').each(function() {
            const currentImage = $(this).clone();
            $('#imageModal .modal-content').append(currentImage);
        });
    }

    $('.content-product').each(function() {
        if ($(this).height() > 350) {
            $(this).find('.show-more').show();
        }
    });
    $('.show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.content-product').css('max-height', '10000px');
    });
    // Xử lý sự kiện khi bấm vào mục trong mục lục
    $('.seo-item-container a').on('click', function() {
        $('.show-more').css('display', 'none'); // Ẩn tất cả nút show-more
        $('.content-product').css('max-height', '10000px'); // Mở rộng chiều cao của .content-product
    });

    // Khi nhấn vào .gallery-trigger img, hiển thị modal và cuộn tới vị trí ảnh đã nhấp
    $('.gallery-trigger img').on('click', function(e) {
        e.preventDefault();
    
        const modal = $('#imageModal');
        const modalContent = modal.find('.modal-content');
    
        // Ẩn cuộn của trang
        $('body').addClass('no-scroll');
    
        // Hiển thị modal với hiệu ứng fadeIn
        modal.fadeIn(300);
    
        // Đợi một thời gian ngắn để modal được hiển thị hoàn toàn
        setTimeout(() => {
            const clickedImageSrc = $(this).attr('src').trim();
            const normalizedClickedImageSrc = clickedImageSrc.replace('/large/', '/');
            let imageFound = false;
    
            // Đợi các ảnh được tải xong
            modalContent.find('img').each(function() {
                const imageSrc = $(this).attr('src').trim();
                const normalizedImageSrc = imageSrc.replace('/large/', '/');
                
                // Nếu ảnh đã load
                if (this.complete) {
                    if (normalizedImageSrc === normalizedClickedImageSrc) {
                        imageFound = true;
                        const targetPosition = $(this).position().top + modalContent.scrollTop();
                        modalContent.animate({ scrollTop: targetPosition }, 600); // 600ms là thời gian cuộn
                    }
                } else {
                    // Nếu ảnh chưa load xong, đợi load xong
                    $(this).on('load', function() {
                        if (!imageFound && normalizedImageSrc === normalizedClickedImageSrc) {
                            imageFound = true;
                            const targetPosition = $(this).position().top + modalContent.scrollTop();
                            modalContent.animate({ scrollTop: targetPosition }, 600); // 600ms là thời gian cuộn
                        }
                    });
                }
            });
    
            if (!imageFound) {
                console.error("Image not found in modal.");
            }
        }, 100);
    });    

    $('.close').on('click', function() {
        $('#imageModal').fadeOut(300, function() {
            // Hiển thị lại cuộn của trang
            $('body').removeClass('no-scroll');
        });
    });
    
    $(window).on('click', function(e) {
        if ($(e.target).is('#imageModal')) {
            $('#imageModal').fadeOut(300, function() {
                // Hiển thị lại cuộn của trang
                $('body').removeClass('no-scroll');
            });
        }
    });

    // Câu hỏi sản phẩm 
    document.querySelectorAll('.button__show-faq').forEach((button, index) => {
        button.addEventListener('click', () => {
            const accordionContent = button.nextElementSibling;
            accordionContent.classList.toggle('active');
    
            // Điều chỉnh max-height cho accordion__content
            if (accordionContent.classList.contains('active')) {
                accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
            } else {
                accordionContent.style.maxHeight = '0';
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    var toggler = document.getElementsByClassName("caret");
    for (var i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function(e) {
            e.preventDefault();
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
});
// $('.filtering').slick({
//     slidesToShow: 4,
//     slidesToScroll: 4
// });

// var filtered = false;

// $('.js-filter').on('click', function() {
//     if (filtered === false) {
//         $('.filtering').slick('slickFilter', ':even');
//         $(this).text('Unfilter Slides');
//         filtered = true;
//     } else {
//         $('.filtering').slick('slickUnfilter');
//         $(this).text('Filter Slides');
//         filtered = false;
//     }
// });