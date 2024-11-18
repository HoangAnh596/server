$(document).ready(function() {
    // Xem thêm 
    $('.content-cate').each(function() {
        if ($(this).height() > 350) {
            $(this).find('.show-more').show();
        }
    });
    $('.show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.content-cate').css('max-height', '10000px');
    });

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

    $('.outstand-prod').each(function() {
        if ($(this).height() > 350) {
            $(this).find('.outstand-show-more').show();
        }
    });
    $('.outstand-show-more').on('click', function() {
        $(this).css('display', 'none'); // Ẩn nút show-more
        $('.outstand-prod').css('max-height', '10000px');
    });

    // bộ lọc filter
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 100) {
            $('.ft-fixed').addClass('fixed-filter');
        } else {
            $('.ft-fixed').removeClass('fixed-filter');
        }
    });


    // Khi nút show-filter được nhấp
    $('.show-filter').on('click', function(e) {
        e.preventDefault();
        var $showFilter = $(this); // Lấy nút show-filter được nhấp
        var $childFilter = $showFilter.next('.child-filter'); // Lấy child-filter tương ứng
        // Kiểm tra xem child-filter hiện đang hiển thị hay ẩn
        if ($childFilter.is(':visible')) {
            $childFilter.hide(); // Nếu đang hiển thị, thì ẩn đi
        } else {
            // Ẩn tất cả các child-filter khác và xóa border-blue từ các show-filter không có btn-child-filter nào được chọn
            $('.child-filter').not($childFilter).hide().each(function() {
                var $siblingChildFilter = $(this);
                var $siblingShowFilter = $siblingChildFilter.prev('.show-filter');
                if ($siblingChildFilter.find('.btn-child-filter.border-blue').length === 0) {
                    $siblingShowFilter.removeClass('border-blue');
                }
            });

            $childFilter.show(); // Hiển thị child-filter tương ứng
            $showFilter.addClass('border-blue'); // Thêm border-blue cho nút hiện tại
        }
    });

    // Đóng menu thả xuống khi nhấp vào bên ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.show-filter, .child-filter').length) {
            $('.child-filter').slideUp();
            $('.show-filter').each(function() {
                var $showFilter = $(this);
                var $childFilter = $showFilter.next('.child-filter');
                if ($childFilter.find('.btn-child-filter.border-blue').length === 0) {
                    $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
                }
            });
        }
    });

    var selectedFilters = {};
    var totalFilters = {};
    var topFilter = ''; // Mảng để lưu trữ bộ lọc được chọn đứng đầu
    var otherFilters = []; // Mảng để lưu trữ href của các bộ lọc khác
    var selectedOrder = []; // Mảng lưu trữ thứ tự chọn của các bộ lọc
    var restoredSelectedOrder = []; // Biến toàn cục để lưu trữ selectedOrder đã khôi phục
    var resPath = false; // Biến toàn cục để kiểm tra path
    var resParams = false; // Biến toàn cục để kiểm tra params tham số
    // Thêm hoặc loại bỏ lớp border-blue khi nhấp vào btn-child-filter
    $('.btn-child-filter').on('click', function(e) {
        e.preventDefault();
        var $btnChildFilter = $(this);
        $btnChildFilter.toggleClass('border-blue');
        $(this).closest('.child-filter').find('.filter-button').show();
        var $showFilter = $btnChildFilter.closest('.child-filter').prev('.show-filter');
        
        var filterName = $showFilter.attr('name');
        var filterValue = $btnChildFilter.attr('id');
        var filterHref = $btnChildFilter.attr('data-href');

        if ($btnChildFilter.hasClass('border-blue')) {
            // Nếu được chọn, thêm giá trị vào danh sách các bộ lọc đã chọn
            if (!selectedFilters[filterName]) {
                selectedFilters[filterName] = [];
            }
            selectedFilters[filterName].push({
                value: filterValue,
                href: filterHref,
                isTopFilter: $showFilter.hasClass('top-filter'),
                isSpecialFilter: $showFilter.hasClass('special-filter')
            });
            if (!totalFilters[filterName]) {
                totalFilters[filterName] = [];
            }
            totalFilters[filterName].push({
                value: filterValue,
            });

            if ($showFilter.hasClass('top-filter')) {
                if (!topFilter) { // Kiểm tra nếu topFilter chưa được đặt
                    topFilter = filterHref; // Lưu trữ top-filter nếu có
                }
            } else {
                otherFilters.push(filterHref); // Lưu trữ các bộ lọc khác
            }

            selectedOrder.push({
                filterName: filterName,
                filterHref: filterHref,
                isTopFilter: $showFilter.hasClass('top-filter'),
                isSpecialFilter: $showFilter.hasClass('special-filter')
            });
            // Chỉ tính hai cái đầu tiên được chọn
            if (selectedOrder.length > 2) {
                selectedOrder = selectedOrder.slice(0, 2);
            }
        } else {
            // Nếu bị bỏ chọn, xóa giá trị khỏi danh sách các bộ lọc đã chọn
            selectedFilters[filterName] = selectedFilters[filterName].filter(function(filter) {
                return filter.value !== filterValue;
            });
            if (selectedFilters[filterName].length === 0) {
                delete selectedFilters[filterName]; // Xóa bộ lọc nếu không còn giá trị nào
            }
            
            if ($showFilter.hasClass('top-filter')) {
                topFilter = ''; // Xóa top-filter nếu bị bỏ chọn
            } else {
                otherFilters = otherFilters.filter(function(href) {
                    return href !== filterHref;
                });
            }
        }
        // Cập nhật restoredSelectedOrder
        restoredSelectedOrder = [...selectedOrder];

        // Gọi AJAX để gửi các bộ lọc đã chọn tới backend
        // Tạo đối tượng chỉ chứa các giá trị value từ selectedFilter được chọn
        var selectedValues = {};
        for (var key in selectedFilters) {
            if (selectedFilters.hasOwnProperty(key)) {
                selectedValues[key] = selectedFilters[key].map(function(filter) {
                    return filter.value;
                });
            }
        }
        var filterUrl = $('.web-filter').data('url');
        $.ajax({
            url: filterUrl, // Đổi URL thành route xử lý filter của bạn
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                filters: JSON.stringify(selectedValues)
            },
            success: function(response) {
                // Xử lý phản hồi từ backend (ví dụ: cập nhật danh sách sản phẩm)
                var $resultCount = $('.total-reloading');
                var $readMoreButton = $('.btn-filter-readmore');
                
                $resultCount.text(response.count);
                
                if (response.count === 0) {
                    $readMoreButton.prop('disabled', true); // Vô hiệu hóa nút nếu total bằng 0
                    $readMoreButton.addClass('disabled'); // Thêm lớp 'disabled' để áp dụng CSS
                } else {
                    $readMoreButton.prop('disabled', false); // Kích hoạt nút nếu total khác 0
                    $readMoreButton.removeClass('disabled'); // Xóa lớp 'disabled' nếu có
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
    // Hàm kiểm tra số lượng phần tử với giá trị isTopFilter được chỉ định trong tất cả các khóa
    function countFiltersInAll(selectedFilters, isTopFilterValue) {
        var filterCount = 0;

        // Duyệt qua tất cả các khóa trong selectedFilters
        Object.keys(selectedFilters).forEach(function(key) {
            // Lấy mảng bộ lọc cho từng khóa
            var filters = selectedFilters[key];
            // Đếm số lượng phần tử với isTopFilter có giá trị isTopFilterValue
            var filteredItems = filters.filter(function(filter) {
                return filter.isTopFilter === isTopFilterValue;
            });
            filterCount += filteredItems.length;
        });

        return filterCount;
    }

    if (typeof slug !== 'undefined') {
        // Xử lý nút "Xem kết quả"
        $('.btn-filter-readmore').on('click', function() {
            // Kiểm tra và xóa thuộc tính 'page' khỏi đối tượng selectedFilters
            if (selectedFilters.hasOwnProperty('page')) {
                delete selectedFilters['page'];
            }
            var topFilterCount = countFiltersInAll(selectedFilters, true); // Tính số lượng phần tử với isTopFilter = true trong tất cả các khóa 
            var notTopFilterCount = countFiltersInAll(selectedFilters, false); // Tính số lượng phần tử với isTopFilter = false trong tất cả các khóa
            // Sắp xếp restoredSelectedOrder để đảm bảo top-filter luôn đứng đầu
            restoredSelectedOrder.sort(function(a, b) {
                return b.isTopFilter - a.isTopFilter;
            });
            if (restoredSelectedOrder.length === 2) {
                selectedOrder = restoredSelectedOrder;
            }
            var queryParams = '';
            var firstFilter = selectedOrder[0] || null;
            var secondFilter = selectedOrder[1] || null;

            // Lấy URL hiện tại
            var currentUrl = window.location.href;

            // Tạo đối tượng URL từ URL hiện tại
            var url = new URL(currentUrl);

            // Tạo URL mới chỉ bao gồm phần đường dẫn chính, không có tham số query
            var newUrl = url.origin + url.pathname;

            var newUrl = window.location.href.split('?')[0];
            var urlParts = newUrl.split(slug); // Tách phần URL trước và sau "-" đầu tiên
            console.log(urlParts);
            console.log('newUrl', newUrl);
            if (firstFilter && secondFilter) {
                console.log(333333);
                
                var firstIsTopFilter = firstFilter.isTopFilter;
                var secondIsTopFilter = secondFilter.isTopFilter;
                if (firstIsTopFilter && secondIsTopFilter) {
                    console.log('Cả hai đều là top-filter => false');
                    var queryParams = Object.keys(selectedFilters).map(function(key) {
                        return key + '=' + selectedFilters[key].map(function(filter) {
                            return filter.value;
                        }).join(',');
                    }).join('&');
                    console.log('topFilterCount', topFilterCount);
                    console.log('notTopFilterCount', notTopFilterCount);
                    console.log('resParams', resParams);
                    console.log('restoredSelectedOrder', restoredSelectedOrder);
                    console.log('queryParams', queryParams);
                    
                    
                    if (topFilterCount === 1 && notTopFilterCount === 1 && restoredSelectedOrder.length > 0 && resPath === true) {
                        newUrl = urlParts[0] + slug + '-' + topFilter + '-' + otherFilters[0];
                    // } else if (topFilterCount === 0 && notTopFilterCount === 1 && restoredSelectedOrder.length > 0 && resParams === true) {
                    //     newUrl = urlParts[0] + slug + '-' + otherFilters[0];
                    } else if (topFilterCount === 0 && notTopFilterCount === 1 && restoredSelectedOrder.length > 0 && resParams === true) {
                        newUrl += '?' + queryParams;
                    } else if (topFilterCount === 0 && notTopFilterCount === 0 && restoredSelectedOrder.length > 0 && resParams === true && (Object.keys(selectedFilters).length === 0)) {
                        newUrl = urlParts[0] + slug;
                    } else if (topFilterCount === 1 && restoredSelectedOrder.length > 0 && resPath === false) {
                        newUrl += '-' + topFilter;
                    } else if (topFilterCount === 1 && restoredSelectedOrder.length > 0 && resPath === true) {
                        newUrl = urlParts[0] + slug + '-' + topFilter;
                    } else {
                        newUrl += '?' + queryParams;
                    }
                } else if (firstIsTopFilter || secondIsTopFilter) {
                    console.log('Có 1 cái top-filter => true');
                    var top = firstIsTopFilter ? firstFilter.filterHref : secondFilter.filterHref;
                    var other = firstIsTopFilter ? secondFilter.filterHref : firstFilter.filterHref;
                    var queryParams = Object.keys(selectedFilters).map(function(key) {
                        return key + '=' + selectedFilters[key].map(function(filter) {
                            return filter.value;
                        }).join(',');
                    }).join('&');
                    console.log('resParams', resParams);
                    if (firstFilter.isSpecialFilter === false && secondFilter.isSpecialFilter === true){
                        if(topFilterCount === 1 && notTopFilterCount >= 1) {
                            newUrl += '?' + queryParams;
                        }
                    } else if (firstFilter.isSpecialFilter === undefined && secondFilter.isSpecialFilter === true ){
                        if(topFilterCount <= 1 && notTopFilterCount >= 1) {
                            newUrl = urlParts[0] + slug + '-' + top + '?' + queryParams;
                        }
                    } else {
                        if(topFilterCount === 0 && notTopFilterCount === 1 && otherFilters.length === 1 && resPath === true) {
                            newUrl = urlParts[0] + slug + '-' + other;
                        } else if(topFilterCount === 1 && notTopFilterCount === 1 && otherFilters.length >= 1 && resPath === true) {
                            newUrl = urlParts[0] + slug + '-' + top + '-' + otherFilters[0];
                        } else if(topFilterCount === 1 && notTopFilterCount === 1 && otherFilters.length === 0 && resPath === true) {
                            newUrl = urlParts[0] + slug + '-' + top + '-' + other;
                        } else if(topFilterCount === 1 && notTopFilterCount === 0 && otherFilters.length < 1 && resPath === true) {
                            newUrl = urlParts[0] + slug + '-' + top; // Nối chuỗi
                        } else if(topFilterCount === 1 && otherFilters.length < 1 && resPath === true) {
                            newUrl = urlParts[0] + slug + '-' + topFilter + '-' + other; // Nối chuỗi
                        } else if(topFilterCount === 1 && notTopFilterCount === 1 && resPath === false && resParams === false) {
                            newUrl += '-' + top + '-' + otherFilters[0];
                        } else if(topFilterCount === 0 && notTopFilterCount === 0 && resParams === true && (Object.keys(selectedFilters).length === 0)) {
                            newUrl = urlParts[0] + slug;
                        } else if(topFilterCount === 0 && notTopFilterCount === 1 && otherFilters.length < 1 && resPath === true && resParams === false) {
                            newUrl = urlParts[0] + slug + '-' + other; //sửa
                        } else if(topFilterCount === 0 && notTopFilterCount === 0 && otherFilters.length < 1 && resPath === true) {
                            newUrl = urlParts[0] + slug; //sửa
                        } else if(topFilterCount === 1 && notTopFilterCount === 0 && resParams === true) {
                            console.log(122223212323);
                            newUrl += '-' + top + '?' + queryParams;
                        } else {
                            newUrl += '?' + queryParams;
                        }
                    }
                } else {
                    // Trường hợp cả hai đều không có top-filter => false
                    console.log('Cả hai đều không là top-filter => false');
                    queryParams = Object.keys(selectedFilters).map(function(key) {
                        return key + '=' + selectedFilters[key].map(function(filter) {
                            return filter.value;
                        }).join(',');
                    }).join('&');
                    // if(secondFilter.isSpecialFilter === false) {
                    //     console.log(444);
                    //     // newUrl += '-' + otherFilters[1] + '?' + queryParams;
                    // } else 
                    if(firstFilter.isSpecialFilter === true && secondFilter.isSpecialFilter === true) {
                        newUrl += '?' + queryParams;
                    } else {
                        if(otherFilters.length < 1 && resPath === false && resParams === true && (Object.keys(selectedFilters).length === 0)) {
                            newUrl = urlParts[0] + slug;
                        } else if(otherFilters.length < 1 && resPath === false && resParams === true) {
                            newUrl = urlParts[0] + slug;
                        } else if(notTopFilterCount === 1 && resPath === false && resParams === false) {
                            newUrl += '-' + otherFilters[0];
                        } else if(notTopFilterCount >= 2 && resPath === false && resParams === false) {
                            newUrl += '?' + queryParams;
                        } else {
                            newUrl += '?' + queryParams;
                        }
                    }
                }
            } else if (firstFilter) {
                
                queryParams = Object.keys(selectedFilters).map(function(key) {
                    return key + '=' + selectedFilters[key].map(function(filter) {
                        return filter.value;
                    }).join(',');
                }).join('&');
                if(firstFilter.isSpecialFilter === true) {
                    newUrl += '?' + queryParams;
                } else {
                    // sửa phần 1 bộ lọc
                    if (Object.keys(selectedFilters).length === 0) {
                        selectedFilters = null;
                    }
                    // Chỉ có một bộ lọc được chọn
                    if (topFilterCount === 1) {
                        newUrl += '-' + firstFilter.filterHref;
                    } else if (topFilterCount === 0 && notTopFilterCount === 1) {
                        newUrl += '-' + firstFilter.filterHref;
                    } else if (topFilterCount === 0 && notTopFilterCount === 0 && resParams === true) {
                        newUrl = urlParts[0] + slug;
                    } else if (topFilterCount === 0 && notTopFilterCount === 0 && resPath === true) {
                        newUrl = urlParts[0] + slug;
                    }
                }
            } 
            console.log('newUrl', newUrl);
            window.location.href = newUrl; // Chuyển hướng đến URL mới
        });
    }
    // Xử lý nút bỏ chọn
    $('.btn-filter-close').on('click', function() {
        var $childFilter = $(this).closest('.child-filter');
        var $showFilter = $childFilter.prev('.show-filter');
        var filterName = $showFilter.attr('name');
        var filterValue = $childFilter.find('.btn-child-filter').data('value');
        // Xóa bộ lọc đã chọn từ selectedFilters
        if (selectedFilters[filterName]) {
            selectedFilters[filterName] = selectedFilters[filterName].filter(function(filter) {
                return filter.value != filterValue;
            });

            // Xóa khóa nếu mảng bộ lọc rỗng
            if (selectedFilters[filterName].length === 0) {
                delete selectedFilters[filterName];
            }
        }
        if (resParams === true || resPath === true) {
            delete selectedFilters[filterName]; // Xóa bộ lọc đã chọn
            $childFilter.find('.btn-child-filter').removeClass('border-blue'); // Xóa border-blue từ tất cả btn-child-filter
            $childFilter.hide();
            $showFilter.removeClass('border-blue'); // Xóa border-blue từ show-filter tương ứng
            // Cập nhật URL
            if (Object.keys(selectedFilters).length > 0) {
                var queryParams = Object.keys(selectedFilters).map(function(key) {
                    return key + '=' + selectedFilters[key].map(function(filter) {
                        return filter.value;
                    }).join(',');
                }).join('&');
        
                var currentUrl = window.location.href.split('?')[0]; // Lấy URL hiện tại mà không có query parameters
                newUrl = currentUrl + (queryParams ? '?' + queryParams : '');
            }
            if (Object.keys(selectedFilters).length === 0) {
                var currentUrl = window.location.href.split('?')[0]; // Lấy URL hiện tại mà không có query parameters
                newUrl = currentUrl.split('-')[0];
            }
        }
        window.location.href = newUrl; // Chuyển hướng đến URL mới
    });

    // Khởi tạo trạng thái ban đầu từ query parameters
    function initFiltersFromUrl() {
        // var queryParams = new URLSearchParams(window.location.search);
        
        // Lấy URL hiện tại
        var currentUrl = window.location.href;

        // Tạo đối tượng URL từ URL hiện tại
        var url = new URL(currentUrl);

        // Tạo đối tượng URLSearchParams từ tham số query
        var queryParams = new URLSearchParams(url.search);

        // Xóa tham số 'page' nếu nó tồn tại
        queryParams.delete('page');

        var urlPath  = window.location.pathname;
        var pathParts = urlPath.split('/');
         // Tìm slug hợp lệ từ đường dẫn
        var foundSlug = validSlugs.find(slug => urlPath.includes(slug));
        
        if (foundSlug) {
            if(queryParams.size === 0 && urlPath.startsWith('/' + foundSlug + '-')) {
                console.log(11113333);
                
                var lastPart = pathParts[pathParts.length - 1];  // Lấy phần tử cuối cùng của đường dẫn
                var filters = lastPart.split('-');  // Phân tách phần tử cuối cùng bằng dấu "-"
                // Khởi tạo các biến để lưu trữ các bộ lọc
                var topFilter = null;
                var otherFil = [];
    
                // Kiểm tra các phần tử của filters và xác định top-filter dựa trên HTML
                filters.forEach(function(filter) {
                    var $btnChildFilter = $('.btn-child-filter[data-href="' + filter + '"]');
                    if ($btnChildFilter.closest('.child-filter').prev('.show-filter').hasClass('top-filter')) {
                        if (!topFilter) {
                            topFilter = filter;
                        }
                    } else {
                        otherFil.push(filter);
                    }
                });
                var otherFiltersStr = otherFil.join('-');
                otherFiltersStr = otherFiltersStr.replace(new RegExp('^' + foundSlug + '-'), '');
                var queryPath = {};
                if (topFilter) {
                    queryPath['filter1'] = [topFilter];
                }
                if (otherFil.length > 0) {
                    queryPath['filter2'] = [otherFiltersStr];
                }
                // Xử lý các tham số từ path
                Object.keys(queryPath).forEach(function(value, key) {
                    var values = queryPath[value];
                    values.forEach(function(href) {
                        var $btnChildFilter = $('.btn-child-filter[data-href="' + href + '"]');
                        $btnChildFilter.addClass('border-blue');
            
                        var $showFilter = $btnChildFilter.closest('.child-filter').prev('.show-filter');
                        var filterName = $showFilter.attr('name');
                        var filterIds = $btnChildFilter.attr('id');
                        if ($showFilter.hasClass('top-filter')) {
                            if (!topFilter) {
                                topFilter = href;
                            }
                        } else {
                            otherFil.push(href);
                        }
                        if (filterName !== undefined) {
                            // Cập nhật selectedFilters và totalFilters
                            if (!selectedFilters[filterName]) {
                                selectedFilters[filterName] = [];
                            }
    
                            selectedFilters[filterName].push({
                                value: filterIds,
                                href: href,
                                isTopFilter: $showFilter.hasClass('top-filter')
                            });
                            if (!totalFilters[key]) {
                                totalFilters[key] = [];
                            }
                            totalFilters[key].push({
                                value: filterIds,
                            });
                            selectedOrder.push({
                                filterName: filterName,
                                filterHref: href,
                                isTopFilter: $showFilter.hasClass('top-filter')
                            });
                        }
    
                        if (selectedOrder.length > 2) {
                            selectedOrder = selectedOrder.slice(0, 2);
                        }
                        // Đặt resPath thành true nếu có bất kỳ btn-child-filter nào được chọn
                        resPath = true;
                        restoredSelectedOrder = [...selectedOrder]; // Lưu lại selectedOrder vào biến toàn cục
                        // Hiển thị filter-button nếu có bất kỳ btn-child-filter nào được chọn
                        var $parentShowFilter = $btnChildFilter.closest('.child-filter').prev('.show-filter');
                        $parentShowFilter.addClass('border-blue')
                        var $childFilter = $parentShowFilter.next('.child-filter');
                        if ($btnChildFilter.length > 0) {
                            $childFilter.find('.filter-button').show();
                        }
                    });
                });
            }else if (urlPath.startsWith('/' + foundSlug)) {
                queryParams.forEach(function(value, key) {
                    var values = value.split(',');
                    
                    if (!selectedFilters[key]) {
                        selectedFilters[key] = [];
                    }
                    values.forEach(function(id) {
                        var $btnChildFilter = $('.btn-child-filter[id="' + id + '"]');
                        $btnChildFilter.addClass('border-blue');
                        var filterHref = $btnChildFilter.attr('data-href');
                        selectedFilters[key].push({
                            value: id,
                            href: filterHref,
                        });
                        if (!totalFilters[key]) {
                            totalFilters[key] = [];
                        }
                        totalFilters[key].push({
                            value: id,
                        });
        
                        var $showFilter = $btnChildFilter.closest('.child-filter').prev('.show-filter');
                        
                        if ($showFilter.hasClass('top-filter')) {
                            if (!topFilter) {
                                topFilter = filterHref;
                            }
                        } else {
                            otherFilters.push(filterHref);
                        }
        
                        selectedOrder.push({
                            filterName: key,
                            filterHref: filterHref,
                            isTopFilter: $showFilter.hasClass('top-filter')
                        });

                        resParams = true;
                        selectedOrder = selectedOrder.slice(0, 2);// Chỉ giữ hai cái chọn đầu tiên
                            restoredSelectedOrder = [...selectedOrder]; // Lưu lại selectedOrder vào biến toàn cục
                    });
        
                    var $showFilter = $('.show-filter[name="' + key + '"]');
                    $showFilter.addClass('border-blue');
                    var $childFilter = $showFilter.next('.child-filter');
                    if (values.length > 0) {
                        $childFilter.find('.filter-button').show();
                    }
                });
            }
        }
    }
    if (typeof validSlugs !== 'undefined') {
        initFiltersFromUrl(); // Khởi tạo trạng thái từ URL khi trang được tải
    }
    // Ẩn tất cả các child-filter khi người dùng cuộn trang
    $(window).on('scroll', function() {
        $('.child-filter').hide();
        $('.show-filter').each(function() {
            var $showFilter = $(this);
            var $childFilter = $showFilter.next('.child-filter');
            if ($childFilter.find('.btn-child-filter.border-blue').length === 0) {
                $showFilter.removeClass('border-blue'); // Xóa border-blue nếu không có btn-child-filter nào được chọn
            }
        });
    }); 
});

document.addEventListener("DOMContentLoaded", function() {

    // Xử lý menu ở website
    const navLinks = document.querySelectorAll('.nav-link-web');
    const dropdownContents = document.querySelectorAll('.dropdown-content');
    
    const defaultActive = document.querySelector('.dropdown-sub[data-default="true"]');

    navLinks.forEach(link => {
        link.addEventListener('mouseenter', function() {
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-content')) {
                dropdown.style.display = 'block';
            }
        });

        link.addEventListener('mouseleave', function() {
            const dropdown = this.nextElementSibling;
            if (dropdown && dropdown.classList.contains('dropdown-content')) {
                dropdown.style.display = 'none';
                resetActiveSubmenu();
            }
        });

        const dropdownContent = link.nextElementSibling;
        if (dropdownContent && dropdownContent.classList.contains('dropdown-content')) {
            dropdownContent.addEventListener('mouseenter', function() {
                this.style.display = 'block';
            });

            dropdownContent.addEventListener('mouseleave', function() {
                this.style.display = 'none';
                resetActiveSubmenu();
            });
        }
    });
    const submenus = document.querySelectorAll('.dropdown-sub');
    submenus.forEach(submenu => {
        submenu.addEventListener('mouseenter', function() {
            this.classList.add('active');
        });

        submenu.addEventListener('mouseleave', function() {
            this.classList.remove('active');
        });
    });

    function resetActiveSubmenu() {
        submenus.forEach(submenu => {
            submenu.classList.remove('active');
        });
        if (defaultActive) {
            defaultActive.classList.add('active');
        }
    }

    // Js search
    var searchToggle = document.getElementById('searchToggleMenu');
    var faSearch = document.getElementById('faSearch');
    var faXmark = document.getElementById('faXmark');
    // var modal = new bootstrap.Modal(document.getElementById('templatemo_search'));
    var modalElement = document.getElementById('templatemo_search');
    var modal = null;

    if (searchToggle && faSearch && faXmark && modalElement) {
        modal = new bootstrap.Modal(modalElement);

        searchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            if (faSearch.style.display !== 'none') {
                faSearch.style.display = 'none';
                faXmark.style.display = 'inline';
                modal.show(); // Hiển thị modal
            } else {
                faSearch.style.display = 'inline';
                faXmark.style.display = 'none';
                modal.hide(); // Hiển thị modal
            }
        });

        // Reset icons when the modal is hidden
        modalElement.addEventListener('hidden.bs.modal', function() {
            faSearch.style.display = 'inline';
            faXmark.style.display = 'none';
        });
    // } else {
    //     console.error('One or more elements are not found in the DOM.');
    }
});