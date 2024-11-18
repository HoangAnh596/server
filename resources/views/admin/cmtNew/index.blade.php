@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Bình luận bài viết</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Bình luận</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-end">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Tìm kiếm tên bình luận" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="is_reply" class="form-control">
                            <option value="">Trạng thái</option>
                            <option value="0" {{ $isReply === '0' ? 'selected' : '' }}>Chưa trả lời</option>
                            <option value="1" {{ $isReply === '1' ? 'selected' : '' }}>Đã trả lời</option>
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="col-sm-3">Nội dung bình luận</th>
                        <th class="text-center">Tác giả</th>
                        <th class="col-sm-2 text-center">Mail</th>
                        <th class="text-center">Hiển thị</th>
                        <th class="text-center">Star</th>
                        <th class="text-center">Time</th>
                        <th class="col-sm-2 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($comments->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center">Không có bản ghi nào phù hợp !...</td>
                    </tr>
                    @else
                    @foreach ($comments as $category)
                    @include('admin.cmtNew.partials.children', ['category' => $category, 'level' => 0])
                    @endforeach
                    @endif
                </tbody>
            </table>
            <nav class="float-right">
                {{ $comments->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .toast-top-center>div {
        width: 400px !important;
    }
</style>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.active-checkbox').change(function() {
            var cmtId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("cmtNews.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: cmtId,
                    is_public: value,
                    _token: '{{ csrf_token() }}',
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
                error: function(xhr) {
                    if (xhr.status === 403) {
                        toastr.warning('Bạn không có quyền cập nhật.', 'Cảnh báo', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 3000
                        });
                        setTimeout(function() {
                            window.location.reload()
                        }, 3000);
                    } else {
                        toastr.error('Lỗi cập nhật thứ tự.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                }
            });
        });

        $('.check-star').change(function() {
            var cmtId = $(this).data('id');
            var cmtStar = $(this).val();

            $.ajax({
                url: '{{ route("cmtNews.star") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: cmtId,
                    star: cmtStar,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Đánh giá star được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật star.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        if (errors.star) {
                            // Hiển thị lỗi cụ thể cho trường star
                            toastr.error(errors.star[0], 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                        } else {
                            toastr.error('Lỗi không xác định.', 'Lỗi', {
                                progressBar: true,
                                closeButton: true,
                                timeOut: 5000
                            });
                        }
                    } else if (xhr.status === 403) {
                        toastr.warning('Bạn không có quyền cập nhật.', 'Cảnh báo', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 3000
                        });
                        setTimeout(function() {
                            window.location.reload()
                        }, 3000);
                    } else {
                        toastr.error('Lỗi cập nhật thứ tự.', 'Lỗi', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    }
                }
            });
        });
    });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Các bình luận con thuộc comments này sẽ bị xóa. Bạn muốn xóa chứ?</div>
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
                // Xử lý khi người dùng nhấn "Xóa"
                document.getElementById('confirmButton').addEventListener('click', function() {
                    toastr.clear(); // Xóa thông báo toastr
                    document.getElementById('deleteForm-' + id).submit(); // Gửi form để xóa
                });

                // Xử lý khi người dùng nhấn "Hủy"
                document.getElementById('cancelButton').addEventListener('click', function() {
                    toastr.remove(); // Xóa thông báo toastr khi nhấn nút "Hủy"
                });
            }
        });
    }
</script>
@endsection