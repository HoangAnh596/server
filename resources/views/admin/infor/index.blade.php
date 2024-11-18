@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h3 class="mb-2 text-gray-800">Danh sách thông tin liên hệ kinh doanh</h3>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group sr-product">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Tìm kiếm tên or số điện thoại" aria-label="Search" name="keyword" value="{{ $keyWord }}">
                    </div>
                    <div class="form-group">
                    <select name="role" class="form-control">
                        <option value="">Vị trí</option>
                        <option value="0">Phòng kinh doanh</option>
                        <option value="1">Phòng kỹ thuật</option>
                        <option value="2">Phòng kinh doanh dự án</option>
                        <option value="3">Phòng kinh doanh máy chủ serve</option>
                        <option value="4">Phòng kế toán</option>
                    </select>
                </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <div>
                @can('hotline-add')
                <a href="{{ route('infors.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th class="col-sm-2 text-center">Tên</th>
                            <th class="col-sm-2 text-center">Phòng</th>
                            <th class="text-center">Số điện thoại</th>
                            <th class="col-sm-1 text-center">Stt</th>
                            <th class="text-center">Nhận báo giá</th>
                            <th class="text-center">Hỗ trợ</th>
                            <th class="text-center">Liên hệ</th>
                            <th class="col-sm-2 text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($infors->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">Không có bản ghi nào phù hợp !...</td>
                        </tr>
                        @else
                        @foreach ($infors as $val)
                        <tr>
                        <td>{{ (($infors->currentPage()-1)*10) + $loop->iteration }}</td>
                            <td>{{ $val->name }}</td>
                            <td>
                                @if($val->role == 0) Kinh doanh
                                @elseif($val->role == 1) Kỹ thuật
                                @elseif($val->role == 2) Dự án
                                @elseif($val->role == 3) Máy chủ serve
                                @elseif($val->role == 4) Kế toán
                                @endif
                            </td>
                            <td>{{ $val->phone }}</td>
                            <td>
                                <input type="text" class="form-control check-stt" name="stt" data-id="{{ $val->id }}" style="text-align: center;" value="{{ old('stt', $val->stt) }}">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="send_price" {{ ($val->send_price == 1) ? 'checked' : '' }}>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_public" {{ ($val->is_public == 1) ? 'checked' : '' }}>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_contact" {{ ($val->is_contact == 1) ? 'checked' : '' }}>
                            </td>
                            <td class="action">
                                @can('hotline-edit')
                                <a href="{{ asset('admin/infors/'.$val->id.'/edit') }}">Chỉnh sửa</a> |
                                @endcan
                                <a href="{{ asset('admin/infors/'.$val->id.'/edit') }}">Nhân bản</a> |
                                <a href="{{ asset('admin/infors/'.$val->id.'/edit') }}">Xóa cache</a>
                                @can('hotline-delete')
                                | <a href="javascript:void(0);" onclick="confirmDelete('{{ $val->id }}')">Xóa</a>
                                <form id="deleteForm-{{ $val->id }}" action="{{ route('infors.destroy', ['id' => $val->id]) }}" method="post" style="display: none;">
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
                    {{ $infors->links() }}
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
        $('.active-checkbox').change(function() {
            var idInfor = $(this).data('id');
            var field = $(this).data('field');
            var value = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: '{{ route("infors.isCheckbox") }}',
                method: 'POST',
                data: {
                    id: idInfor,
                    field: field,
                    value: value,
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
            var idInfor = $(this).data('id');
            var sttInfor = $(this).val();

            $.ajax({
                url: '{{ route("infors.checkStt") }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: idInfor,
                    stt: sttInfor,
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
        <div>Bạn chắc chắn xóa thông tin hotline này chứ?</div>
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