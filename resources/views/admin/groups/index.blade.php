@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h3 class="mb-2 text-gray-800">Danh sách nhóm sản phẩm</h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control form-outline" placeholder="Tìm kiếm tên nhóm" aria-label="Search" name="keyword" value="">
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                @can('group-add')
                <a href="{{ route('groups.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới nhóm</a>
                @endcan
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="col-sm-3 text-center">Tên nhóm</th>
                        <th class="col-sm-4 text-center">Danh mục sản phẩm</th>
                        <th class="col-sm-1 text-center">STT</th>
                        <th class="text-center">Hiển thị</th>
                        <th class="col-sm-2 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($groups->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Không có bản ghi nào phù hợp !...</td>
                    </tr>
                    @else
                    @foreach ($groups as $val)
                    <tr>
                        <td>{{ (($groups->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                        <td>{{ $val->name }}</td>
                        <td>@if(!empty($val->cate_id)) {{ $val->category->name }} @endif</td>
                        <td>
                            <input type="text" class="form-control check-stt" name="stt" data-id="{{ $val->id }}" style="text-align: center;" value="{{ old('stt', $val->stt) }}">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_public" {{ ($val->is_public == 1) ? 'checked' : '' }}>
                        </td>
                        <td class="action">
                            @can('group-edit')
                            <a href="{{ asset('admin/groups/'.$val->id.'/edit') }}">Chỉnh sửa</a> |
                            @endcan
                            <a href="{{ asset('admin/groups/'.$val->id.'/edit') }}">Xóa cache</a>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            <nav class="float-right">
                {{ $groups->links() }}
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.active-checkbox').change(function() {
            var groupId = $(this).data('id');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("groups.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: groupId,
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

        $('.check-stt').change(function() {
            var idGroup = $(this).data('id');
            var sttGroup = $(this).val();

            $.ajax({
                url: '{{ route("groups.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idGroup,
                    stt: sttGroup,
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Thứ tự được cập nhật thành công.', 'Thành công', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000
                        });
                    } else {
                        toastr.error('Không thể cập nhật thứ tự.', 'Lỗi', {
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
        <div>Bạn chắc chắn xóa Slider này chứ?</div>
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