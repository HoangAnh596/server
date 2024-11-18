@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Chỉnh sửa so sánh</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">So sánh</a></li>
                <li class="breadcrumb-item active">Chỉnh sửa</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow">
        <form id="uploadImageForm" action="{{ route('compares.update', $compare->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (!empty($compare))
            <input type="hidden" name="id" value="{{ $compare->id }}">
            @endif
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
                        @include("admin.compare.shared.edit-config")
                    </div>
                    <div class="tab-pane fade" id="wallet-tab" role="tabpanel">
                        @include("admin.compare.shared.edit-compare")
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
    document.addEventListener('DOMContentLoaded', function() {
        const options = document.querySelectorAll('#parent_id option');
        options.forEach(option => {
            option.style.display = 'block';
            option.addEventListener('click', function() {
                const level = parseInt(this.getAttribute('data-level'));
                options.forEach(opt => {
                    if (parseInt(opt.getAttribute('data-level')) > level) {
                        opt.style.display = opt.style.display === 'none' ? 'block' : 'none';
                    }
                });
            });
        });
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
        $('#edit-compare').click(function(e) {
            e.preventDefault();
            // Lấy giá trị từ input
            var compareName = $('#keyword').val().trim();

            if (compareName) {
                // Kiểm tra tên compare có trùng hay không
                if (isDuplicateCompare(compareName)) {
                    toastr.error('Tên bộ lọc đã tồn tại. Vui lòng nhập một tên khác.', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                } else {
                    // Thêm vào bảng
                    var newRow = `<tr>
                            <td>{{ $compare->valueCompares->count() + 1 }}</td>
                            <td class="text-center">
                                ${compareName}
                                <input type="hidden" name="key_word[]" value="${compareName}">
                            </td>
                            <td><a href="javascript:void(0);" class="btn-sm delete-compare">Xóa</a></td>
                        </tr>`;
                    // Thêm dòng mới vào đầu tbody
                    $('#existing-items').prepend(newRow);

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
        // Event delegation for dynamically added elements
        $('#compares-table').on('click', '.delete-compare', function() {
            $(this).closest('tr').remove();
            updateIndex();
        });

        $('.btn-destroy').on('click', function(e) {
            e.preventDefault();

            var id = $(this).data('id'); // Lấy ID từ thuộc tính data-id
            var url = $(this).attr('href'); // Lấy URL từ href

            confirmDeleteImg(id, url); // Gọi hàm confirmDelete
        });

        function confirmDeleteImg(id, url) {
            toastr.warning(`
                <div>Bạn chắc chắn muốn xóa chứ?</div>
                <div style="margin-top: 15px;">
                    <button type="button" id="confirmButton" class="btn btn-danger btn-sm" style="margin-right: 10px;">Xóa</button>
                    <button type="button" id="cancelButton" class="btn btn-secondary btn-sm">Hủy</button>
                </div>
            `, 'Cảnh báo', {
                closeButton: false,
                timeOut: 0, // Vô hiệu hóa tự động loại bỏ
                extendedTimeOut: 0,
                tapToDismiss: false,
                positionClass: "toast-top-center",
                onShown: function() {
                    document.getElementById('confirmButton').addEventListener('click', function() {
                        toastr.remove(); // Xóa thông báo toastr

                        // Thực hiện xóa đối tượng bằng AJAX
                        $.ajax({
                            url: url,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(result) {
                                // Xóa hàng khỏi bảng nếu xóa thành công
                                $('a[data-id="' + id + '"]').closest('tr').remove();
                            },
                            error: function(xhr) {
                                alert('Có lỗi xảy ra, vui lòng thử lại.');
                            }
                        });
                    });

                    document.getElementById('cancelButton').addEventListener('click', function() {
                        toastr.remove(); // Xóa thông báo toastr khi nhấn nút "Hủy"
                    });
                }
            });
        }

        $('.check-stt').change(function() {
            var idCate = $(this).data('id');
            var stt = $(this).val();
            console.log(stt);
            $.ajax({
                url: '{{ route("detailCompare.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idCate,
                    stt: stt,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Trạng thái được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật trạng thái.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                },
                error: function() {
                    toastr.error('Lỗi cập nhật trạng thái.', 'Lỗi', {
                        progressBar: true,
                        closeButton: true,
                        timeOut: 5000
                    });
                }
            });
        });
    });
</script>
@endsection