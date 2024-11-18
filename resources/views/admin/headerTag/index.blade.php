@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h3 class="mb-2 text-gray-800">Danh sách thông tin thẻ tiếp thị</h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control form-outline" placeholder="Tìm kiếm thẻ tiếp thị" aria-label="Search" name="keyWord" value="{{ $keyWord }}">
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                @can('header-tags-add')
                <a href="{{ route('header-tags.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th class="text-center">Tên</th>
                            <th class="text-center">Nội dung</th>
                            <th class="text-center">Ẩn/Hiện</th>
                            <th class="col-sm-2 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($headerTags->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center">Không có bản ghi nào phù hợp !...</td>
                        </tr>
                        @else
                        @foreach ($headerTags as $val)
                        <tr>
                            <td>{{ $val->id }}</td>
                            <td>{{ $val->tag_name }}</td>
                            <td>{{ $val->content }}</td>
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_public" {{ ($val->is_public == 1) ? 'checked' : '' }}>
                            </td>
                            <td class="action">
                                @can('header-tags-edit')
                                <a href="{{ asset('admin/header-tags/'.$val->id.'/edit') }}">Chỉnh sửa</a> |
                                @endcan
                                <a href="{{ asset('admin/header-tags/'.$val->id.'/edit') }}">Xóa cache</a>
                                @can('header-tags-delete')
                                | <a href="javascript:void(0);" onclick="confirmDelete('{{ $val->id }}')">Xóa</a>
                                <form id="deleteForm-{{ $val->id }}" action="{{ route('header-tags.destroy', ['id' => $val->id]) }}" method="post" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                <nav class="float-right">
                    {{ $headerTags->links() }}
                </nav>
            </div>
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
            var headerTagsId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("header-tags.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: headerTagsId,
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
    });

    function confirmDelete(id) {
        toastr.warning(`
        <div>Bạn chắc chắn xóa thẻ tiếp thị này chứ?</div>
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