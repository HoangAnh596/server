@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between">
        <h3 class="mb-2 text-gray-800">Danh sách câu hỏi thường gặp</h3>
        <h6 aria-label="breadcrumb">
            <ol class="breadcrumb bg-light">
                <li class="breadcrumb-item"><a href="javascript: void(0);">Câu hỏi</a></li>
                <li class="breadcrumb-item active">Danh sách</li>
            </ol>
        </h6>
    </div>
    <!-- DataTales Example -->

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <form class="d-sm-inline-block form-inline mr-auto my-2 my-md-0 ">
                <div class="input-group">
                    <div class="form-group">
                        <input type="search" class="form-control" placeholder="Tìm kiếm theo tên" aria-label="Search" name="keyword" value="{{ $keyword }}">
                    </div>
                    <div class="form-group">
                        <select name="cate" class="form-control">
                            <option value="">Danh mục sản phẩm</option>
                            @foreach($categories as $category)
                            @include('admin.question.partials.category_search', ['category' => $category, 'level' => 0])
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"> <i class="fas fa-search fa-sm"></i> </button>
                    </div>
                </div>
            </form>
            <!-- <div>
                <a href="{{ route('questions.create') }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-circle-plus"></i> Thêm mới</a>
            </div> -->
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="">No.</th>
                        <th class="col-sm-4 text-center">Câu hỏi</th>
                        <th class="col-sm-2 text-center">Tên danh mục</th>
                        <th class="col-sm-2 text-center">Tên sản phẩm</th>
                        <th class="text-center">STT</th>
                        <th class="text-center">Hiển thị</th>
                        <th class="col-sm-2 text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if($questions->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center">Không có bản ghi nào phù hợp !...</td>
                    </tr>
                    @else
                    @foreach ($questions as $val)
                    <tr>
                        <td>{{ (($questions->currentPage()-1)*config('common.default_page_size')) + $loop->iteration }}</td>
                        <td>
                            <p>{{ $val->title }}</p>
                        </td>
                        <td>
                            @if($val->category) <a href="{{ asset($val->category->slug) }}" target="_blank">{{ $val->category->name }}</a> @endif
                        </td>
                        <td>
                            @if($val->product) <a href="{{ asset($val->product->slug) }}" target="_blank">{{ $val->product->name }}</a> @endif
                        </td>
                        <td class="text-center">
                            <input type="text" class="check-stt" name="stt" data-id="{{ $val->id }}" style="width: 40px;text-align: center;" value="{{ old('stt', $val->stt) }}">
                        </td>
                        <td class="text-center">
                            <input type="checkbox" class="active-checkbox" data-id="{{ $val->id }}" data-field="is_public" {{ ($val->is_public == 1) ? 'checked' : '' }}>
                        </td>
                        <td class="action">
                            @can('question-edit')
                            <a href="{{ asset('admin/questions/'.$val->id.'/edit') }}">Chỉnh sửa</a> |
                            @endcan
                            <a href="{{ asset('admin/questions') }}">Xóa cache</a>
                            @can('question-delete')
                            | <a href="javascript:void(0);" onclick="confirmDelete('{{ $val->id }}')">Xóa</a>
                            <form id="deleteForm-{{ $val->id }}" action="{{ route('questions.destroy', ['id' => $val->id]) }}" method="post" style="display: none;">
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
                {{ $questions->links() }}
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
                url: '{{ route("questions.isCheckbox") }}',
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
                url: '{{ route("questions.checkStt") }}',
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
        <div>Bạn chắc chắn xóa câu hỏi này chứ?</div>
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