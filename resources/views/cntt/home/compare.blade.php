@extends('cntt.layouts.app')

@section('content')
<!-- Kiểm tra thiết bị di dộng -->
@php
$agent = new Jenssegers\Agent\Agent();
$isMobile = $agent->isMobile(); // Kiểm tra thiết bị di động
@endphp
<div class="container pt-60">
    <div class="d-flex justify-content-between">
        <h3>SO SÁNH SẢN PHẨM</h3>
        <button class="export-compare"><i class="fa-solid fa-print"></i> Export</button>
    </div>

    <ul class="listproduct pro-compare pro-compare_main {{ $isMobile ? 'sticky-3sp' : '' }}">
        <li>
            <p class="title-cp">Tên sản phẩm</p>
            <div class="product-cp">
                <p class="productname-cp" data-id="{{ $product1->id }}">{{ $product1->name }}</p>
                <p class="productname-cp" data-id="{{ $product2->id }}">{{ $product2->name }}</p>
                @if(!empty($product3))
                <p class="productname-cp" data-id="{{ $product3->id }}">{{ $product3->name }}</p>
                @endif
            </div>
        </li>
        <li class="product-dt" data-id="{{ $product1->id }}" data-slug="{{ $product1->slug }}">
            <a href="{{ asset($product1->slug) }}">
                <div class="item-label"></div>
                <div class="item-img">
                    @if(!empty($image1))
                    <img class="thumb ls-is-cached lazyloaded" data-src="{{ asset($image1->image) }}" alt="{{ asset($image1->alt) }}" title="{{ asset($image1->title) }}" src="{{ asset($image1->image) }}">
                    @endif
                </div>
                <h3>{{ $product1->name }}</h3>
                <strong class="price">
                    @if($product1->price == 0)
                    Giá: Liên hệ
                    @else
                    Giá: {{ number_format($product1->price * (1 - $product1->discount / 100), 0, ',', '.') }}₫ @if($product1->discount != 0)<span class="compare-price">{{ number_format($product1->price, 0, ',', '.') }}₫ @endif</span>
                    @endif
                </strong>
            </a>
            <div class="item-bottom">
                <a href="#" class="shiping"></a>
            </div>
            <a href="javascript:;" class="deleteProduct" onclick="DeletedProduct({{ $product1->id }})"><i class="fa-regular fa-circle-xmark"></i></a>
        </li>
        <li class="product-dt" data-id="{{ $product2->id }}" data-slug="{{ $product2->slug }}">
            <a href="{{ asset($product2->slug) }}">
                <div class="item-label"></div>
                <div class="item-img">
                    @if(!empty($image2))
                    <img class="thumb ls-is-cached lazyloaded" data-src="{{ asset($image2->image) }}" alt="{{ asset($image2->alt) }}" title="{{ asset($image2->title) }}" src="{{ asset($image2->image) }}">
                    @endif
                </div>
                <h3>{{ $product2->name }}</h3>
                <strong class="price">
                    @if($product2->price == 0)
                    Giá: Liên hệ
                    @else
                    Giá: {{ number_format($product2->price * (1 - $product2->discount / 100), 0, ',', '.') }}₫ @if($product2->discount != 0)<span class="compare-price">{{ number_format($product2->price, 0, ',', '.') }}₫ @endif</span>
                    @endif
                </strong>
            </a>
            <div class="item-bottom">
                <a href="#" class="shiping"></a>
            </div>
            <a href="javascript:;" class="deleteProduct" onclick="DeletedProduct({{ $product2->id }})"><i class="fa-regular fa-circle-xmark"></i></i></a>
        </li>
        @if(!empty($product3))
        <li class="product-dt" data-id="{{ $product3->id }}" data-slug="{{ $product3->slug }}">
            <a href="{{ asset($product3->slug) }}">
                <div class="item-label"></div>
                <div class="item-img">
                    <img class="thumb ls-is-cached lazyloaded" data-src="{{ asset($image3->image) }}" alt="{{ asset($image3->alt) }}" title="{{ asset($image3->title) }}" src="{{ asset($image3->image) }}">
                </div>
                <h3>{{ $product3->name }}</h3>
                <strong class="price">
                    @if($product3->price == 0)
                    Giá: Liên hệ
                    @else
                    Giá: {{ number_format($product3->price * (1 - $product3->discount / 100), 0, ',', '.') }}₫ @if($product3->discount != 0)<span class="compare-price">{{ number_format($product3->price, 0, ',', '.') }}₫ @endif</span>
                    @endif
                </strong>
            </a>
            <div class="item-bottom">
                <a href="#" class="shiping"></a>
            </div>
            <a href="javascript:;" class="deleteProduct" onclick="DeletedProduct({{ $product3->id }})"><i class="fa-regular fa-circle-xmark"></i></a>
        </li>
        @endif
        <li class="productid-0" @if(!empty($product3)) style="display: none;" @endif>
            <div class="addsp-cp" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <div class="plus">
                    <i></i>
                </div>
                <span>Thêm sản phẩm</span>
            </div>
        </li>
    </ul>
    <div class="fullspecs">
        <div class="parameter-cp col2">
            @foreach($compareCates as $cates)
            <div class="{{ $isMobile ? 'box-detailcp-mb technologi-mb' : 'box-detailcp technologi' }}">
                <div class="{{ $isMobile ? 'title-mb-compare' : 'titletechnologi' }}">
                    <i class="fa-solid fa-circle-chevron-down"></i>
                    <strong>{{ $cates->name }}</strong>
                </div>
                <div class="listtechnologi">
                    @foreach($valueCompares[$cates->id] as $compare)
                    <div class="part-detail">
                        <div class="boxDesktop">
                            <aside class="{{ $isMobile ? 'hasprod-mb' : 'hasprod' }}">
                                <p><span><strong>{{ $compare->key_word }}</strong></span></p>
                            </aside>
                            @if($isMobile)
                            <div class="hasprod_product">
                                <!-- Lấy giá trị so sánh cho sản phẩm 1 -->
                                <aside class="hasprod-mb-pr" data-id="{{ $product1->id }}">
                                    <p class="prop">
                                        <span>
                                            @if(isset($compareProduct1[$compare->id]))
                                            {{ $compareProduct1[$compare->id]->display_compare }}
                                            @endif
                                        </span>
                                    </p>
                                </aside>

                                <!-- Lấy giá trị so sánh cho sản phẩm 2 -->
                                <aside class="hasprod-mb-pr" data-id="{{ $product2->id }}">
                                    <p class="prop">
                                        <span>
                                            @if(isset($compareProduct2[$compare->id]))
                                            {{ $compareProduct2[$compare->id]->display_compare }}
                                            @endif
                                        </span>
                                    </p>
                                </aside>
                                <!-- Lấy giá trị so sánh cho sản phẩm 3 -->
                                <aside class="hasprod-mb-pr">
                                    <p class="prop">
                                        @if(isset($compareProduct3[$compare->id]))
                                        <span>
                                            {{ $compareProduct3[$compare->id]->display_compare }}
                                        </span>
                                        @endif
                                    </p>
                                </aside>
                            </div>
                            @else
                            <!-- Lấy giá trị so sánh cho sản phẩm 1 -->
                            <aside class="hasprod" data-id="{{ $product1->id }}">
                                <p class="prop">
                                    <span>
                                        @if(isset($compareProduct1[$compare->id]))
                                        {{ $compareProduct1[$compare->id]->display_compare }}
                                        @endif
                                    </span>
                                </p>
                            </aside>

                            <!-- Lấy giá trị so sánh cho sản phẩm 2 -->
                            <aside class="hasprod" data-id="{{ $product2->id }}">
                                <p class="prop">
                                    <span>
                                        @if(isset($compareProduct2[$compare->id]))
                                        {{ $compareProduct2[$compare->id]->display_compare }}
                                        @endif
                                    </span>
                                </p>
                            </aside>
                            <!-- Lấy giá trị so sánh cho sản phẩm 3 -->
                            @if(isset($compareProduct3[$compare->id]))
                            <aside class="hasprod" data-id="{{ $product3->id }}">
                                <p class="prop">
                                    <span>
                                        {{ $compareProduct3[$compare->id]->display_compare }}
                                    </span>
                                </p>
                            </aside>
                            @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<div class="bg-popup" style="display: none;"></div>
<!-- Modal -->
<div class="modal fade compare-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modaltitle">So sánh sản phẩm</h3>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">x Đóng</button>
            </div>
            <div class="modal-body">
                <div class="input-text">
                    <form action="javascript:void(0)">
                        <i class="iconcate-search"></i>
                        <input type="hidden" id="cateId" value="{{ $category->id }}">
                        <input type="hidden" id="product1" value="{{ $product1->id }}">
                        <input type="hidden" id="product2" value="{{ $product2->id }}">
                        <input type="hidden" id="slugPro1" value="{{ $product1->slug }}">
                        <input type="hidden" id="slugPro2" value="{{ $product2->slug }}">
                        <input id="kcc" type="text" placeholder="Nhập Tên hoặc Mã sản phẩm để so sánh" onkeyup="SuggestCompare()">
                        <div id="compareResults">
                        </div>
                    </form>
                </div>
                <div class="scroll-container">
                    <h4 class="text-center mt-4">{{ $category->name }} đang khuyến mãi sốc <i class="fa-solid fa-fire" style="color: red;"></i></h4>
                    <ul class="pro-compare pro-compare_viewed">
                        @foreach($saleProducts as $sale)
                        <li class="productitem-cp">
                            <a href="javascript:void(0)" class="main-contain ">
                                <div class="item-label"></div>
                                <div class="item-img">
                                    @if($sale->main_image)
                                    <img class="thumb ls-is-cached lazyloaded" data-src="{{ asset($sale->main_image->image) }}"
                                        alt="{{ $sale->main_image->alt }}" title="{{ $sale->main_image->title }}" src="{{ asset($sale->main_image->image) }}">
                                    @else
                                    <img class="thumb ls-is-cached lazyloaded"
                                        data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" alt="Image Coming Soon" title="Image Coming Soon"
                                        src="{{ asset('storage/images/image-coming-soon.jpg') }}">
                                    @endif
                                </div>
                                <h3 class="text-center">{{ $sale->name }}</h3>
                                <a href="javascript:;" class="add-compare" data-id="{{ $sale->id }}" data-slug="{{ $sale->slug }}" onclick="AddProduct({{ $sale->id }})">
                                    Thêm so sánh
                                </a>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/compare.css') }}">
<style>
    .modal-header {
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }

    #modaltitle {
        flex-grow: 1;
        /* Để tiêu đề chiếm không gian giữa */
        text-align: center;
    }

    #compareResults {
        margin: 0 16px;
        width: 95%;
    }

    .modal-title {
        margin: 0;
        line-height: 1.42857143;
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* Căn hai phần tử ở hai đầu */
        padding: 10px;
        border-bottom: 1px solid #e5e5e5;
    }

    .modal-header .close {
        border: 1px solid #76b900;
        padding: 2px 8px;
        font-size: 0.9rem;
        border-radius: 3px;
    }

    @media (min-width: 1200px) {

        .h3,
        h3 {
            font-size: 1.25rem;
        }
    }

    @media (min-width: 992px) {
        .modal-dialog {
            max-width: 600px;
            margin: 30px auto;
        }
    }
</style>
@endsection
@section('js')
<script src="{{asset('cntt/js/compare.js')}}"></script>
<script type="text/javascript">
    function SuggestCompare() {
        let searchText = $('#kcc').val();
        let cateId = $('#cateId').val();
        let product1 = $('#product1').val();
        let product2 = $('#product2').val();
        let slugPro1 = $('#slugPro1').val();
        let slugPro2 = $('#slugPro2').val();

        // Kiểm tra nếu không có giá trị nhập thì không thực hiện tìm kiếm
        if (searchText.trim() === '') {
            $('#compareResults').html(''); // Xóa kết quả nếu không có từ khóa tìm kiếm
            $('#compareResults').hide();
            return;
        }

        $.ajax({
            url: '{{ route("home.compareCate") }}', // Đường dẫn tới API tìm kiếm sản phẩm
            method: 'GET',
            data: {
                query: searchText,
                id: cateId,
                product1: product1,
                product2: product2,
            },
            success: function(response) {
                let results = '';

                // Nếu có dữ liệu trả về
                if (response.length > 0) {
                    response.forEach(function(product) {
                        results += `<div class="compare-outer">
                                    <div class="compare-row">
                                        <div class="compare-title">
                                            <a href="so-sanh-${slugPro1}-vs-${slugPro2}-vs-${product.slug}">
                                                <strong style="color:#ff0000;">${product.code}</strong> ${product.name}
                                            </a>
                                        </div>
                                    </div>
                                </div>`;
                    });
                    // Hiển thị kết quả tìm kiếm
                    $('#compareResults').html(results).show();
                } else {
                    results = '<div class="search-item">Không tìm thấy sản phẩm</div>';
                }

                // Hiển thị kết quả tìm kiếm
                $('#compareResults').html(results);
            },
            error: function() {
                $('#compareResults').html('<div class="search-item">Lỗi khi tìm kiếm sản phẩm</div>');
            }
        });
    }

    $('.export-compare').click(function(e) {
        e.preventDefault();
        // Tìm tất cả các phần tử có class "productname-cp"
        let productIds = [];
        $('.productname-cp').each(function() {
            productIds.push($(this).data('id'));
        });
        console.log(productIds);

        $.ajax({
            url: '{{ route("export.compare") }}',
            type: 'POST',
            data: JSON.stringify({
                products: productIds
            }),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            xhrFields: {
                responseType: 'blob' // Để tải file
            },
            success: function(response) {
                console.log(response);
                var blob = new Blob([response]);
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'bang-so-sanh.xlsx';
                link.click();
            },
            error: function(xhr) {
                // Xử lý lỗi không phải validation (500, etc.)
                toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi', {
                    progressBar: true,
                    closeButton: true,
                    timeOut: 5000
                });
            }
        });
    });

    function DeletedProduct(productId) {
        // Tìm tất cả thẻ li có class product-dt
        const productItems = document.querySelectorAll('li.product-dt');

        if (productItems.length === 1) {
            // Nếu chỉ còn một sản phẩm, ẩn nút xóa
            const deleteButton = productItems[0].querySelector('.deleteProduct');
            if (deleteButton) {
                deleteButton.style.display = 'none';
            }
            return; // Không xóa phần tử nếu chỉ còn 1
        }

        // Tìm thẻ <li> có thuộc tính data-id bằng productId
        const productElement = document.querySelector('li.product-dt[data-id="' + productId + '"]');

        if (productElement) {
            // Xóa phần tử <p> tương ứng trong danh sách tên sản phẩm
            const productNameElement = document.querySelector('p.productname-cp[data-id="' + productId + '"]');
            if (productNameElement) {
                productNameElement.remove(); // Xóa phần tử <p> chứa tên sản phẩm
            }

            // Tìm tất cả thẻ <aside> có class 'hasprod' và thuộc tính data-id tương ứng
            const hasprodElements = document.querySelectorAll('aside.hasprod[data-id="' + productId + '"]');

            // Duyệt qua tất cả các phần tử tìm được và xóa chúng
            hasprodElements.forEach(element => {
                element.remove();
            });

            // Tạo bản sao của phần tử "productid-0"
            const addProductElement = document.querySelector('li.productid-0').cloneNode(true);
            addProductElement.style.display = 'flex'; // Hiển thị nút "Thêm sản phẩm"

            // Thay thế phần tử đã xóa bằng phần tử mới
            productElement.replaceWith(addProductElement); // Thay thế sản phẩm bị xóa
        }

        // Tìm tất cả sản phẩm hiện có và nút "Thêm sản phẩm"
        const ulElement = document.querySelector('ul.pro-compare');
        const productIdElement = ulElement.querySelector('li.productid-0');

        // Di chuyển "nút Thêm sản phẩm" xuống cuối cùng
        ulElement.appendChild(productIdElement);

        // Kiểm tra lại sau khi xóa, nếu chỉ còn 1 sản phẩm thì ẩn nút xóa
        const updatedProductItems = document.querySelectorAll('li.product-dt');
        if (updatedProductItems.length === 1) {
            const lastDeleteButton = updatedProductItems[0].querySelector('.deleteProduct');
            if (lastDeleteButton) {
                lastDeleteButton.style.display = 'none';
            }
        }
    }

    function AddProduct(saleId) {
        // Lấy tất cả các sản phẩm còn lại
        const productItems = document.querySelectorAll('li.product-dt');

        // Lấy slug từ các sản phẩm còn lại
        const slugs = Array.from(productItems).map(item => item.getAttribute('data-slug')).filter(slug => slug);

        // Lấy slug của sale từ data attribute của nút
        const saleSlug = document.querySelector(`a.add-compare[data-id="${saleId}"]`).getAttribute('data-slug');

        // Tạo đường dẫn mới
        const comparePath = `so-sanh-${slugs.join('-vs-')}-vs-${saleSlug}`;

        // Chuyển hướng đến đường dẫn mới
        window.location.href = `{{ asset('${comparePath}') }}`;
    }
</script>
@endsection