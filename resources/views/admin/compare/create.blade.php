@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Thêm mới so sánh</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">So sánh</a></li>
                <li class="breadcrumb-item active">Thêm mới</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('compares.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="card-header d-flex justify-content-between">
                <a href="{{ route('compares.index') }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-backward"></i> Quay lại</a>
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
                        @include("admin.compare.shared.add-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.compare.shared.add-compare")
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
<script>
    let timeout = null;

    function checkDuplicate() {
        clearTimeout(timeout);
        timeout = setTimeout(async function() {
            const name = document.getElementById('name').value.trim();

            // Xóa thông báo lỗi trước đó
            document.getElementById('name-error').innerText = "";

            if (name === "") {
                document.getElementById('name-error').innerText = 'Tên không được để trống';
                return;
            }

            // Kiểm tra trùng lặp cho name
            await $.ajax({
                url: "{{ route('compares.checkName') }}",
                type: 'POST',
                data: {
                    name: name,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    if (data.name_exists) {
                        document.getElementById('name-error').innerText = 'Tên đã tồn tại';
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }, 1000);
    }

    // Đặt sự kiện khi name thay đổi
    document.getElementById('name').addEventListener('input', function() {
        checkDuplicate();
    });


    $(document).ready(function() {
        // Hàm để cập nhật số thứ tự
        function updateIndex() {
            $('#compares-table tbody tr').each(function(index) {
                $(this).find('td:first').text(index);
            });
        }

        // Hàm để kiểm tra tên compare có trùng hay không
        function isDuplicateCompare(name) {
            var isDuplicate = false;
            $('#compares-table tbody tr td:nth-child(2)').each(function() {
                if ($(this).text().trim() === name.trim()) {
                    isDuplicate = true;
                    return false; // Break the loop
                }
            });
            return isDuplicate;
        }
        $('#add-compare').click(function(e) {
            e.preventDefault();
            // Lấy giá trị từ input
            var compareName = $('#keyword').val().trim();

            if (compareName) {
                // Kiểm tra tên compare có trùng hay không
                if (isDuplicateCompare(compareName)) {
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
                                ${compareName}
                                <input type="hidden" name="key_word[]" value="${compareName}">
                            </td>
                            <td><a href="javascript:void(0);" class="btn-sm delete-compare">Xóa</a></td>
                        </tr>`;
                    $('#compares-table tbody').append(newRow);

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
        $('#compares-table').on('click', '.delete-compare', function() {
            $(this).closest('tr').remove();
            // Cập nhật số thứ tự sau khi xóa
            updateIndex();
        });
    });
</script>
@endsection