@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới bộ lọc</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bộ lọc</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('filter.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('filter.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
                <div>
                    <button class="btn btn-primary btn-sm " type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                    <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
                </div>
            </div>
            <div class="card-body border-top p-9">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info-tab" type="button" role="tab">
                            <i class="bi bi-info-circle-fill"></i>
                            Thông tin chi tiết
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#wallet-tab" type="button" role="tab">
                            <i class="bi bi-wallet2"></i>
                            Giá trị bộ lọc
                        </button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="info-tab" role="tabpanel">
                        @include("admin.filter.shared.add-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.filter.shared.add-filter")
                    </div>
                </div>
            </div>

            <div class="mt-4 pb-4 mr-4 float-right">
                <button class="btn btn-primary btn-sm" type="submit"><i class="fa-solid fa-floppy-disk"></i> Lưu</button>
                <!-- <button class="btn btn-info btn-sm" type="reset"><i class="fa-solid fa-eraser"></i> Clear</button> -->
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('cntt/js/slug.js') }}"></script>
<script>
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
                    url: "{{ route('filters.checkName') }}",
                    type: 'POST',
                    data: {
                        name: name,
                        slug: slug,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(data) {
                        if (data.name_exists) {
                            document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                        }

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

    $(document).ready(function() {
        // Hàm để cập nhật số thứ tự
        function updateIndex() {
            $('#filters-table tbody tr').each(function(index) {
                $(this).find('td:first').text(index);
            });
        }

        // Hàm để kiểm tra tên filter có trùng hay không
        function isDuplicateFilter(name) {
            var isDuplicate = false;
            $('#filters-table tbody tr td:nth-child(2)').each(function() {
                if ($(this).text().trim() === name.trim()) {
                    isDuplicate = true;
                    return false; // Break the loop
                }
            });
            return isDuplicate;
        }
        $('#add-filter').click(function(e) {
            e.preventDefault();
            // Lấy giá trị từ input
            var filterName = $('#keyword').val().trim();

            if (filterName) {
                // Kiểm tra tên filter có trùng hay không
                if (isDuplicateFilter(filterName)) {
                    toastr.error('Tên bộ lọc đã tồn tại. Vui lòng nhập một tên khác', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                } else {
                    // Thêm vào bảng
                    var newRow = `<tr>
                            <td></td>
                            <td class="text-center">
                                ${filterName}
                                <input type="hidden" name="key_word[]" value="${filterName}">
                            </td>
                            <td class="text-center">
                                <input type="number" name="stt[]" style="width: 50px;text-align: center;" value="999">
                            </td>
                            <td><a href="javascript:void(0);" class="btn-sm delete-filter">Xóa</a></td>
                        </tr>`;
                    $('#filters-table tbody').append(newRow);

                    // Clear input
                    $('#keyword').val('');

                    // Cập nhật số thứ tự
                    updateIndex();
                }
            } else {
                toastr.error('Vui lòng nhập tên bộ lọc.', 'Lỗi', {
                    progressBar: true,
                    closeButton: true,
                    timeOut: 5000
                });
            }
        });
        // Xử lý sự kiện click cho nút xóa
        $('#filters-table').on('click', '.delete-filter', function() {
            $(this).closest('tr').remove();
            // Cập nhật số thứ tự sau khi xóa
            updateIndex();
        });
    });
</script>
@endsection