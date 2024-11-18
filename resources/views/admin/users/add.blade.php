@extends('layouts.app')
@section('content')
<div class="card shadow">
    <div class="text-center mt-4">
        <h1 class="h4 text-gray-900 mb-4">Tạo mới tài khoản!</h1>
    </div>
    <form class="user" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-header d-flex justify-content-between">
            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
            <div>
                <button class="btn btn-primary btn-sm" id="submit" type="submitCateNew"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
            </div>
        </div>
        <div class="text-dark card-body border-top">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                        <i class="fa-solid fa-user"></i>
                        Thông tin tài khoản
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                        <i class="fa-solid fa-square-share-nodes"></i>
                        Cấu hình mạng xã hội
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#password-tab" type="button" role="tab">
                        <i class="fa-solid fa-lock"></i>
                        Cấu hình đăng nhập
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                    @include("admin.users.shared.add-config")
                </div>
                <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                    @include("admin.users.shared.add-social")
                </div>
                <div class="tab-pane fade" id="password-tab" role="tabpanel">
                    @include("admin.users.shared.add-pass")
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('js')
<script src="{{ asset('cntt/js/slug.js') }}"></script>
<script>
    $('.select2_init').select2({
        placeholder: 'Chọn vai trò',
        allowClear: true,
    });

    let timeout = null;
    let updateSlug = true;

    function validateSlug(slug) {
        // Biểu thức chính quy để kiểm tra định dạng của slug
        const regex = /^[a-z0-9]+(-[a-z0-9]+)*$/;
        return regex.test(slug);
    }

    function checkDuplicate() {
        clearTimeout(timeout);
        timeout = setTimeout(async function() {
            if (updateSlug) {
                await createSlug();
            }

            const name = document.getElementById('name').value;
            const slug = document.getElementById('slug').value;

            // Xóa thông báo lỗi trước đó
            document.getElementById('name-error').innerText = "";
            document.getElementById('slug-error').innerText = "";
            // Chỉ kiểm tra nếu slug không rỗng
            if (updateSlug && name.trim() !== "") {
                await createSlug();
            }
            // Kiểm tra định dạng slug
            if (slug.trim() === "") {
                document.getElementById('slug-error').innerText = 'Url không được để trống';
            } else if (!validateSlug(slug)) {
                document.getElementById('slug-error').innerText = 'Url không hợp lệ. Chỉ chấp nhận chữ cái thường, số và dấu gạch ngang.';
            } else {
                // Nếu slug hợp lệ, kiểm tra trùng lặp
                await $.ajax({
                    url: "{{ route('users.checkName') }}",
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.slug_exists) {
                            document.getElementById('slug-error').innerText = 'Url đã tồn tại';
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }, 1000);
    }
    // Đặt updateSlug là true khi tên thay đổi
    document.getElementById('name').addEventListener('input', function() {
        updateSlug = true;
        checkDuplicate();
    });

    // Đặt updateSlug là false khi slug thay đổi
    document.getElementById('slug').addEventListener('input', function() {
        updateSlug = false;
        checkDuplicate();
    });
</script>
@endsection