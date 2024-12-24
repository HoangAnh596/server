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

    // Cấu hình tùy chỉnh server
    // Xử lý cho radio
    $('.item input[type="radio"]').on('change', function () {
        const groupName = $(this).attr('name'); // Lấy tên nhóm của radio
        // Loại bỏ is-checked chỉ trong các item có cùng nhóm name
        $(`.item input[name="${groupName}"]`).closest('.item').removeClass('is-checked');
        // Thêm is-checked vào item chứa radio được chọn
        if ($(this).is(':checked')) {
            $(this).closest('.item').addClass('is-checked');
        }
    });

    // Xử lý cho checkbox
    $('.item input[type="checkbox"]').on('change', function () {
        if ($(this).is(':checked')) {
            // Thêm is-checked nếu checkbox được chọn
            $(this).closest('.item').addClass('is-checked');
        } else {
            // Loại bỏ is-checked nếu checkbox không được chọn
            $(this).closest('.item').removeClass('is-checked');
        }
    });
    
    // Khi trang load: Lấy giá trị ban đầu
    renderCheckedItems();

    // Cấu hình tùy chỉnh
    // $(window).on('scroll', function() {
    //     const $config = $('.conf-config');
    // const configOffset = $config.data('originalOffset') || $config.offset()?.top || 0; // Lưu vị trí gốc
    // const scrollPosition = $(this).scrollTop();

    // // Lưu giá trị offset gốc một lần duy nhất
    // if (!$config.data('originalOffset')) {
    //     $config.data('originalOffset', configOffset);
    // }

    // // Kiểm tra nếu vị trí cuộn lớn hơn hoặc bằng vị trí của .conf-config
    // if (scrollPosition >= configOffset) {
    //     $config.addClass('fixed-config');
    // } else {
    //     $config.removeClass('fixed-config');
    // }
    // });
});

function getCheckedItems() {
    // Tạo một mảng để lưu các item có is_checked
    let checkedItems = [];

    // Duyệt qua tất cả các radio và checkbox đã được chọn
    $('input[type="radio"]:checked, input[type="checkbox"]:checked').each(function () {
        let selectedItem = $(this).closest('.item'); // Tìm item chứa input
        let productId = selectedItem.data('product_id'); // Lấy product_id
        let nameProduct = selectedItem.data('name-product');
        let nameGroup = selectedItem.data('name-group');
        let qtyValue = selectedItem.find('input[name="item_qty"]').val(); // Lấy giá trị qty

        // Thêm thông tin vào mảng checkedItems
        checkedItems.push({
            product_id: productId,
            name_product: nameProduct,
            name_group: nameGroup,
            is_checked: true,
            quantity: qtyValue
        });
    });

    return checkedItems;
}

function groupCheckedItems(checkedItems) {
    // Tạo object để gộp các item theo name_group
    let groupedItems = {};

    checkedItems.forEach(item => {
        if (item.quantity <= 0) return;  // Bỏ qua các item có quantity <= 0
        // Nếu name_group đã tồn tại thì cộng dồn quantity
        if (groupedItems[item.name_group]) {
            groupedItems[item.name_group].quantity += item.quantity;
            groupedItems[item.name_group].products.push({
                name_product: item.name_product,
                quantity: item.quantity
            });
        } else {
            // Nếu name_group chưa tồn tại thì tạo mới
            groupedItems[item.name_group] = {
                name_group: item.name_group,
                quantity: item.quantity,
                products: [
                    { name_product: item.name_product, quantity: item.quantity }
                ]
            };
        }
    });

    return groupedItems;
}

function renderCheckedItems() {
    let checkedItems = getCheckedItems();

    // Gộp các item có chung name_group
    let groupedItems = groupCheckedItems(checkedItems);

    // Tạo nội dung HTML cho danh sách groupedItems
    let content = Object.values(groupedItems).map(group => {
        let productDetails = group.products.map(product => {
            return `<div><strong>${product.quantity}x</strong> ${product.name_product}</div>`;
        }).join('');
        return `
            <li>
                <strong>${group.name_group} :</strong>
                ${productDetails}
            </li>`;
    }).join('');

    // Cập nhật nội dung trong thẻ .conf-widget
    $('.conf-widget ul').html(content);
}

// Cập nhật nội dung mỗi khi radio hoặc checkbox thay đổi
$('input[type="radio"], input[type="checkbox"], input[name="item_qty"]').on('change input', function () {
    renderCheckedItems();
});
document.addEventListener('DOMContentLoaded', function () {
    const modalElement = document.getElementById('confPrint');
    const redDiv = document.querySelector('.top-red-div'); // Thẻ đã tồn tại

    if (modalElement) { // Kiểm tra modalElement có tồn tại
        // Khi modal hiển thị
        modalElement.addEventListener('show.bs.modal', function () {
            if (redDiv) {
                redDiv.style.display = 'flex'; // Hiển thị thẻ
            }
        });

        // Khi modal bị ẩn
        modalElement.addEventListener('hidden.bs.modal', function () {
            if (redDiv) {
                redDiv.style.display = 'none'; // Ẩn thẻ
            }
        });
    }
});