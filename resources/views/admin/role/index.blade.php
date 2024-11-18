@extends('layouts.app')
@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h6>
    </div>
    <div class="card-header py-3 d-flex justify-content-between">
        <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
            <div class="input-group sr-product">
                <div class="form-group">
                    <input type="search" class="form-control" placeholder="Tìm kiếm tên, email tài khoản" aria-label="Search" name="keyword" value="{{ $keyword }}">
                </div>
                <div class="form-group">
                    <select name="role" class="form-control">
                        <option value="">Vai trò</option>
                        <option value="1">Quản trị viên</option>
                        <option value="0">Người dùng</option>
                    </select>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                </div>
            </div>
        </form>
        <div>
            @can('role-add')
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên tài khoản</th>
                        <th>Mô tả vai trò</th>
                        <th class="col-sm-2 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($roles->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Không có bản ghi nào phù hợp !...</td>
                        </tr>
                    @else
                    @foreach($roles as $val)
                    <tr>
                        <td>{{ (($roles->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                        <td>{{ $val->name }}</td>
                        <td>{{ $val->display_name }}</td>
                        <td class="action">
                            @can('role-edit')
                            <a href="{{ asset('admin/roles/'.$val->id.'/edit') }}">Chỉnh sửa</a> |
                            @endcan
                            <a href="{{ asset('admin/roles') }}">Xóa cache</a>
                            @can('role-delete')
                            | <a href="javascript:void(0);" onclick="confirmDelete('{{ $val->id }}')">Xóa</a>
                            <form id="deleteForm-{{ $val->id }}" action="{{ route('roles.destroy', ['id' => $val->id]) }}" method="post" style="display: none;">
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
            {{$roles->appends(request()->query())->links()}}
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
    function confirmDelete(id) {
        toastr.warning(`
        <div>Các vai trò thuộc tài khoản này sẽ bị xóa. Bạn muốn xóa chứ?</div>
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