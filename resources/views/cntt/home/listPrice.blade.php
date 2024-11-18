@extends('cntt.layouts.app')

@section('content')
<div class="pt-44" id="check-list">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-check-list">
                    <a href="{{ asset('/')}}">
                        <img title="Logo Công Ty TNHH Việt Thái Dương" alt="Logo Công Ty TNHH Việt Thái Dương" src="{{ asset('storage/images/logo/logo-cnttshopvn.png') }}">
                    </a>
                    <span class="decor"></span>
                    <p class="check-list-title">
                        Công cụ kiểm tra bảng giá toàn cầu tốt nhất <br>
                        Router, Switch, Module Quang, Firewall, Wireless AP...
                    </p>
                    <div class="formcheck">
                        <h1>Giá mã sản phẩm: {{ $key }}</h1>
                        <div id="checklistnumber">
                            <form action="{{ route('home.listPrice') }}" accept-charset="utf-8" method="get" id="checklist">
                                <button class="search-submit" onclick="document.getElementById('checklist').submit()">CHECK GIÁ</button>
                                <button class="search-submit1" onclick="document.getElementById('checklist').submit()"><i class="fa fa-search"></i></button>
                                <input type="text" name="key" value="{{ $key }}" id="partvalue" placeholder="Mã sản phẩm...">
                            </form>
                        </div>
                    </div>
                    @if(!empty($key))
                    <div class="table-responsive">
                        <table class="table-view-check-list">
                            <thead>
                                <tr>
                                    <th width="60px">#No</th>
                                    <th width="80px;">Hình ảnh</th>
                                    <th width="160px;">Part name</th>
                                    <th width="100px;">Giá List</th>
                                    <th width="140px;">Giá thị trường</th>
                                    <th>Mô tả</th>
                                    <th width="120px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->isEmpty())
                                <td colspan="12" style="padding: 15px 0; font-size: 1.2rem">Vui lòng liên hệ tới bộ phận kinh doanh để được báo giá tốt nhất</td>
                                @else
                                @foreach($products as $product)
                                <tr>
                                    <td class="thutu-check-list">{{ $loop->iteration }}</td>
                                    @php
                                    $mainImage = $product->product_images ? $product->product_images->firstWhere('main_img', 1) : null;
                                    @endphp

                                    @if($mainImage)
                                    @php
                                    $imagePath = $mainImage->image;
                                    $directory = dirname($imagePath);
                                    $filename = basename($imagePath);
                                    $newDirectory = $directory . '/small';
                                    $newImagePath = $newDirectory . '/' . $filename;
                                    @endphp
                                    <td class="img-check-list">
                                        <img class="img-size" src="{{ asset($newImagePath) }}" alt="{{ $mainImage->alt }}" title="{{ $mainImage->title }}">
                                    </td>
                                    @else
                                    <td class="img-check-list">
                                        <img class="lazyload img-size" src="{{ asset('storage/images/image-coming-soon.jpg') }}" data-src="{{ asset('storage/images/image-coming-soon.jpg') }}" width="206" height="206" alt="Image Coming Soon" title="Image Coming Soon">
                                    </td>
                                    @endif
                                    <td class="sku-check-list">
                                        <a title="{{ $product->title_seo }}" href="{{ asset($product->slug) }}" target="_blank"><strong>{{ $product->code }}</strong></a>
                                    </td>
                                    <td class="listprice-check-list">
                                        Updating...
                                    </td>
                                    <td class="pricemarket-check-list">
                                        Updating...
                                    </td>
                                    <td class="desc">
                                        Giá List của sản phẩm <strong>{{ $product->code }}</strong> được cập nhật liên tục. Hãy liên hệ tới Nvidiavn.vn theo thông tin trên website để nhận được báo giá bán sản phẩm mới nhất, rẻ nhất thị trường.
                                    </td>

                                    <td class="buttom-check-list">
                                        <a title="Liên hệ để được báo giá tốt sản phẩm CBS110-16T-EU" class="btn-best-price-check" data-bs-toggle="modal" data-bs-target="#priceModal" data-bs-target="#priceModal"
                                            data-code="{{ $product->code }}" data-slug="{{ $product->slug }}">
                                            Giá tốt
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="price-modal">
    <!-- Modal -->
    <div class="modal fade" id="priceModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Yêu cầu nhận giá tốt về sản phẩm <span class="price-code"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger hide" id="price-error"></div>
                    <div class="form-group mb-2">
                        <label for="name">Họ tên</label>
                        <input type="text" name="name" class="form-control" id="name">
                        <span class="name-price-erros" style="color: red;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="phone">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" id="phone">
                        <span class="phone-price-errors" style="color: red;"></span>
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="form-group mb-2">
                        <label for="amount">Số lượng cần mua</label>
                        <input type="number" min="1" class="form-control" name="amount" id="amount">
                    </div>
                    <div class="form-group">
                        <label>Mục đích mua hàng: </label>
                        <label><input value="0" name="purpose" type="radio" style="margin-left: 15px; margin-right: 5px;">Công ty</label>
                        <label><input value="1" name="purpose" type="radio" style="margin-left: 15px; margin-right: 5px;">Dự án</label>
                    </div>
                </div>
                @if (!empty($products))
                <input type="hidden" name="code" id="code">
                <input type="hidden" name="slug" id="slug">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @endif
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary send-price">Gửi yêu cầu</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('cntt/css/listprice.css') }}">
<style>
    .search-h2 {
        font-size: 1rem;
        margin: 0;
    }

    .src-fixed {
        position: sticky;
        top: 56px;
        left: 0;
        width: 100%;
        z-index: 999;
    }
    .modal-header h5 {
        font-size: 16px;
    }
    .price-modal .hide {
        display: none;
    }
    .price-code {
        color: #76b900;
    }
</style>
@endsection
@section('js')
<!-- Link to Swiper's JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="{{asset('cntt/js/product.js')}}"></script>
<script type="text/javascript">
    // Báo giá
    document.querySelector('.send-price').addEventListener('click', function(e) {
        e.preventDefault();
        let submitButton = this;
        let csrfToken = document.querySelector('input[name="_token"]').value;

        // Vô hiệu hóa nút submit để ngăn gửi nhiều lần
        submitButton.disabled = true;
        let nameElement = document.getElementById('name');
        let phoneElement = document.getElementById('phone');
        let emailElement = document.getElementById('email');
        let amountElement = document.getElementById('amount');
        let purposeElement = document.querySelector('input[name="purpose"]:checked');
        let codeElement = document.getElementById('code');
        let slugElement = document.getElementById('slug');

        // Kiểm tra xem các phần tử có tồn tại không
        if (!nameElement || !phoneElement) {
            document.getElementById('price-error').innerText = 'Vui lòng điền đầy đủ thông tin!';
            document.getElementById('price-error').classList.remove('hide');
            submitButton.disabled = false; // Kích hoạt lại nút submit
            return;
        }

        let nameValue = nameElement.value.trim();
        let phoneValue = phoneElement.value.trim();

        // Ẩn thông báo trước khi gửi form
        document.getElementById('price-error').classList.add('hide');

        let isValid = true;
        let errorMessages = {};

        // Kiểm tra trường 'name'
        if (nameValue.length < 3 || nameValue.length > 256) {
            isValid = false;
            errorMessages.name = 'Họ tên phải có từ 3 đến 256 ký tự.';
        } else {
            document.querySelector('.name-price-erros').innerText = '';
        }
        if (errorMessages.name) {
            document.querySelector('.name-price-erros').innerText = errorMessages.name;
        }

        // Kiểm tra trường 'phone'
        const phonePattern = /^[0-9]{10,12}$/;
        if (!phonePattern.test(phoneValue)) {
            isValid = false;
            errorMessages.phone = 'Số điện thoại không hợp lệ.';
        } else {
            document.querySelector('.phone-price-errors').innerText = '';
        }
        if (errorMessages.phone) {
            document.querySelector('.phone-price-errors').innerText = errorMessages.phone;
        }

        // Nếu không hợp lệ thì ngừng xử lý và hiển thị lỗi
        if (!isValid) {
            document.getElementById('price-error').innerText = 'Vui lòng kiểm tra lại thông tin của bạn.';
            document.getElementById('price-error').classList.remove('hide');
            submitButton.disabled = false; // Kích hoạt lại nút submit
            return;
        }

        let data = {
            name: nameElement.value,
            phone: phoneElement.value,
            email: emailElement ? emailElement.value : null,
            amount: amountElement ? amountElement.value : null,
            purpose: purposeElement ? purposeElement.value : 0,
            code: codeElement.value,
            slug: slugElement.value,
        };

        fetch('{{ route("price.request") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Đóng modal bằng Bootstrap JavaScript API
                    let modalElement = document.querySelector('#priceModal'); // Thay '#yourModalId' bằng ID của modal
                    let modal = bootstrap.Modal.getInstance(modalElement);
                    if (modal) {
                        modal.hide();
                    }
                    toastr.success('Yêu cầu báo giá đã được gửi thành công', 'Thành công', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 10000
                    });
                    // Xóa dữ liệu cũ
                    document.getElementById('name').value = '';
                    document.getElementById('phone').value = '';
                    document.getElementById('email').value = '';
                    document.getElementById('amount').value = '';
                    document.querySelectorAll('input[name="purpose"]').forEach(radio => radio.checked = false);
                    document.getElementById('code').value = '';
                    document.getElementById('slug').value = '';
                } else {
                    document.getElementById('price-error').innerText = data.error;
                    document.getElementById('price-error').classList.remove('hide');
                }
                submitButton.disabled = false; // Kích hoạt lại nút submit sau khi xử lý xong
            })
            .catch(error => {
                document.getElementById('price-error').innerText = 'Đã xảy ra lỗi khi gửi yêu cầu.';
                document.getElementById('price-error').classList.remove('hide');
                submitButton.disabled = false; // Kích hoạt lại nút submit nếu xảy ra lỗi
            });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const priceModal = document.getElementById('priceModal');
        priceModal.addEventListener('show.bs.modal', function (event) {
            // Lấy nút kích hoạt modal
            const button = event.relatedTarget;
            // Lấy dữ liệu từ các thuộc tính data của nút
            const code = button.getAttribute('data-code');
            const slug = button.getAttribute('data-slug');

            // Gán dữ liệu vào các thành phần trong modal
            priceModal.querySelector('.price-code').textContent = code;
            priceModal.querySelector('#code').value = code;
            priceModal.querySelector('#slug').value = slug;
        });
    });
</script>
@endsection